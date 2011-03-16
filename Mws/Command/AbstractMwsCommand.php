<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Mws\Command;

use Guzzle\Service\Command\AbstractCommand;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Common\Inflector;
use Guzzle\Service\Aws\Mws\Model\CsvReport;
use Guzzle\Service\Aws\Mws\Model\ResultIterator;
use Guzzle\Common\XmlElement;

/**
 * MWS command base class
 *
 * All MWS commands inherit this default functionality.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class AbstractMwsCommand extends AbstractCommand
{
    /**
     * @var string MWS operation name
     */
    protected $action;

    /**
     * @var string HTTP request method
     */
    protected $requestMethod = RequestInterface::GET;

    /**
     * @var string xpath query to records in result
     */
    protected $recordPath;

    /**
     * Prepare command before execution
     */
    protected function build()
    {
        if (!$this->action) {
            // @codeCoverageIgnoreStart
            throw new \Exception('You must define an action name');
            // @codeCoverageIgnoreEnd
        }

        if (!$this->request) {
            $this->request = $this->client->createRequest($this->requestMethod);
        }

        $this->request->getQuery()->set('Action', $this->action);

        // Set authorization fields
        $config = $this->getClient()->getConfig();
        $this->request->getQuery()
            ->set('AWSAccessKeyId', $config['access_key_id'])
            ->set('Marketplace', $config['marketplace_id'])
            ->set('Merchant', $config['merchant_id']);

        // Add any additional method params
        foreach($this->data as $param => $value) {
            if ($param == 'headers') {
                continue;
            }
            $param = ucfirst(Inflector::camel($param));
            if (is_array($value)) {
                // It's an array, convert to amazon array naming convention
                foreach($value as $listName => $listValues) {
                    foreach($listValues as $i => $listValue) {
                        $this->request->getQuery()->set($param . '.' . $listName . '.' . ($i + 1), $listValue);
                    }
                }
                $this->request->getQuery()->remove($param);
            } else if ($value instanceof \DateTime) {
                // It's a date, format as ISO 8601 string
                $this->request->getQuery()->set($param, $value->format('c'));
            } else if (is_bool($value)) {
                // It's a bool, convert to string
                $this->request->getQuery()->set($param, $value ? 'true' : 'false');
            } else {
                // It's a scalar
                $this->request->getQuery()->set($param, $value);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function process()
    {
        parent::process();

        if (strpos($this->getResponse()->getBody(true), '<?xml') !== false) {
            $body = $this->getResponse()->getBody(true);
            $body = preg_replace('# xmlns=[^ >]*#', '', $body);
            $this->result = new \SimpleXMLElement($body);
        }

        if ($this->result instanceof \SimpleXMLElement) {

            // Get result object from XML response
            $this->result = new XmlElement($this->result->asXML());

            // @codeCoverageIgnoreStart
            if (empty($this->resultNode)) {
                $resultNode = $this->action . 'Result';
            } else {
                $resultNode = $this->resultNode;
            }
            // @codeCoverageIgnoreEnd
            $this->result = $this->result->{$resultNode};

            // Iterable result
            if ($this instanceof AbstractIterableMwsCommand || $this instanceof AbstractIterableMwsOrderCommand) {
                $nextCommand = Inflector::snake($this->action . 'ByNextToken');

                $records = $this->result;
                if ($this->recordPath) {
                    $records = $this->result->xpath($this->recordPath);
                }

                // Get next token unless HasNext property is set to false
                $nextToken = (string)$this->result->NextToken;
                if (!empty($this->result->HasNext)) {
                    if ($this->result->HasNext == 'false') {
                        $nextToken = null;
                    }
                }

                $this->result = new ResultIterator($this->getClient(), array(
                    'next_token'    => $nextToken,
                    'next_command'  => $nextCommand,
                    'resources'     => $records,
                    'result_node'   => $resultNode,
                    'record_path'   => $this->recordPath
                ));
                
            } else if (!empty($this->recordPath)) {
                $this->result = $this->result->xpath($this->recordPath);
            }

        } else if ($this->result->getContentType() == 'application/octet-stream') {
            // Get CSV data array
            $this->result = new CsvReport($this->getResponse()->getBody(true));
        }
    }
}
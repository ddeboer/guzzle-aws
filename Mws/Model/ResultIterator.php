<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Mws\Model;

use Guzzle\Service\ResourceIterator;

/**
 * Iterator for commands with iterable results
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class ResultIterator extends ResourceIterator
{
    /**
     * Send request to get the next page of results
     */
    protected function sendRequest()
    {
        // Throttle requests by waiting 1 second
        sleep(1);
        
        $command = $this->client->getCommand($this->data['next_command'])
            ->setNextToken($this->getNextToken());
        $response = $this->client->execute($command);
        $this->processResult($response);
    }

    /**
     * Process results, add
     *
     * @param SimpleXMLElement $result
     */
    protected function processResult(\SimpleXMLElement $result)
    {
        if ($result->{$this->data['result_node']}) {
            $records = $result->{$this->data['result_node']}->toArray();
        } else {
            $records = $result->xpath($this->data['record_path']);
        }
        
        $this->resourceList = $records;
        $this->retrievedCount += count($this->resourceList);
        $this->currentIndex = 0;

        // @codeCoverageIgnoreStart
        if ((string) $result->HasNext == 'true') {
            $this->nextToken = (string) $result->NextToken;
        } else {
            $this->nextToken = null;
        }
        // @codeCoverageIgnoreEnd
    }
}
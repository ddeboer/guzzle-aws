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
 * Any commany which can issue a next token will return an instance
 * of this class as it's result. Iterating over this object with foreach()
 * will automatically get additional pages as needed.
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
        // @codeCoverageIgnoreStart
        if ($result->{$this->data['result_node']}) {
            $records = $result->{$this->data['result_node']}->toArray();
        } else {
            $records = $result->xpath($this->data['record_path']);
        }
        // @codeCoverageIgnoreEnd
        
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
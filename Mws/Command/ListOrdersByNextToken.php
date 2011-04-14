<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Command;

/**
 * The ListOrdersByNextToken operation returns the next page of orders using the NextToken value that was
 * returned by your previous request to either ListOrders or ListOrdersByNextToken. If NextToken is not
 * returned, there are no more pages to return.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 *
 * @guzzle next_token doc="Next token" required="true"
 */
class ListOrdersByNextToken extends AbstractMwsOrderCommand
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'ListOrdersByNextToken';

    /**
     * {@inheritdoc}
     */
    protected $resultNode = 'ListOrdersByNextTokenResult';

    /**
     * Set next token
     *
     * @param string $nextToken
     *
     * @return ListOrdersByNextToken
     */
    public function setNextToken($nextToken)
    {
        return $this->set('next_token', $nextToken);
    }
}
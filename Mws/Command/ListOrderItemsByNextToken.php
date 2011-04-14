<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Command;

/**
 * The ListOrderItemsByNextToken operation returns the next page
 * of order items using the NextToken value that was returned by
 * your previous request to either ListOrderItems or
 * ListOrderItemsByNextToken. If NextToken is not returned, there
 * are no more pages to return.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 *
 * @guzzle next_token doc="Next token" required="true"
 */
class ListOrderItemsByNextToken extends AbstractMwsOrderCommand
{
    /**
     * {@inheritdoc}
     */
    protected $action = 'ListOrderItemsByNextToken';

    /**
     * {@inheritdoc}
     */
    protected $recordPath = '//OrderItems/OrderItem';

    /**
     * Set next token
     *
     * @param string $nextToken
     *
     * @return ListOrderItemsByNextToken
     */
    public function setNextToken($nextToken)
    {
        return $this->set('next_token', $nextToken);
    }
}
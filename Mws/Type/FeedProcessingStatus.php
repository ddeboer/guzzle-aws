<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Mws\Type;

/**
 * Feed processing statuses
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 * @codeCoverageIgnore
 */
class FeedProcessingStatus
{
    const SUBMITTED = '_SUBMITTED_';
    const IN_PROGRESS = '_IN_PROGRESS_';
    const CANCELLED = '_CANCELLED_';
    const DONE = '_DONE_';
}
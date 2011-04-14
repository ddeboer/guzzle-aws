<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Aws\Signature;

use Guzzle\Http\QueryString;

/**
 * Amazon Web Services signature version 2
 *
 * @author Michael Dowling <michael@guzzlephp.org>
 */
class SignatureV2 extends AbstractSignature
{
    /**
     * {@inheritdoc}
     */
    protected $phpHashingAlgorithm = 'sha256';

    /**
     * {@inheritdoc}
     */
    protected $awsHashingAlgorithm = 'HmacSHA256';

    /**
     * {@inheritdoc}
     */
    protected $signatureVersion = '2';

    /**
     * {@inheritdoc}
     */
    public function calculateStringToSign(array $request, array $options = null)
    {
        if (is_null($options) || !isset($options['endpoint'])) {
            return '';
        }

        if (!array_key_exists('ignore', $options)) {
            $options['ignore'] = array('awsSignature', 'Signature');
        } else {
            $options['ignore'] = (array) $options['ignore'];
        }

        if (!array_key_exists('sort_method', $options)) {
            $options['sort_method'] = 'strcmp';
        }

        if (!array_key_exists('method', $options)) {
            $options['method'] = 'GET';
        }

        $serviceEndpoint = parse_url($options['endpoint']);

        // Sort the request and create the canonicalized query string
        $parameterString = '';
        uksort($request, $options['sort_method']);

        foreach ($request as $k => $v) {
            if ($k && $v && !in_array($k, $options['ignore'])) {
                if ($parameterString) {
                    $parameterString .= '&';
                }
                $parameterString .= rawurlencode($k) . '=' . rawurlencode($v);
            }
        }

        return $options['method'] . "\n"
               . $serviceEndpoint['host'] . "\n"
               . (isset($serviceEndpoint['path']) ? $serviceEndpoint['path'] : '/') . "\n"
               . $parameterString;
    }
}
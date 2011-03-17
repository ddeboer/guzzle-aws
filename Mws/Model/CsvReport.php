<?php
/**
 * @package Guzzle PHP <http://www.guzzlephp.org>
 * @license See the LICENSE file that was distributed with this source code.
 */

namespace Guzzle\Service\Aws\Mws\Model;

use \IteratorAggregate;
use \Countable;
use \ArrayIterator;
use \InvalidArgumentException;
use \UnexpectedValueException;

/**
 * CSV report model
 *
 * For MWS commands that return CSV data instead of XML, this class
 * is used to wrap the response. The CSV data is converted to an array
 * of rows, and each row is an array of field => value pairs.
 *
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class CsvReport implements IteratorAggregate, Countable
{
    /**
     * @var array Row data
     */
    protected $rows = array();

    /**
     * @var array Field names
     */
    protected $fieldNames = array();

    /**
     * Initialize CSV data
     *
     * @param string|array $data CSV data
     *
     * @throws InvalidArgumentException if the $data value is not a string or array
     * @throws UnexpectedValueException if a row cannot be parsed
     */
    public function __construct($data)
    {
        if (is_array($data)) {
            
            if (!isset($data[0])) {
                // @codeCoverageIgnoreStart
                throw new InvalidArgumentException('Data rows must be numerically keyed');
                // @codeCoverageIgnoreEnd
            }
            $this->fieldNames = array_keys($data[0]);
            $this->rows = $data;

        } else if (is_string($data)) {
            
            // Split rows by newlines
            $this->rows = str_getcsv($data, "\n");
            foreach($this->rows as &$row) {
                // Split columns by tab
                $row = str_getcsv($row, "\t");
            }

            // First row is the header, use as array keys
            $this->fieldNames = array_shift($this->rows);

            // Iterate over remaining rows, parse into columns
            foreach($this->rows as $i => &$row) {
                if (count($this->fieldNames) != count($row)) {
                    throw new UnexpectedValueException('Error parsing row ' . $i);
                }
                $row = array_combine($this->fieldNames, $row);
            }
            
        } else {
            throw new InvalidArgumentException(
                '$data must be a string or an array'
            );
        }

        unset($data);
    }

    /**
     * Magic method, alias of toString()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Get CSV data rows
     *
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Get CSV field names
     *
     * @return array
     */
    public function getFieldNames()
    {
        return $this->fieldNames;
    }

    /**
     * Get iterator instance
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->rows);
    }

    /**
     * Get row count
     *
     * @return int
     */
    public function count()
    {
        return count($this->rows);
    }

    /**
     * Get report as CSV string
     *
     * @return string
     */
    public function toString()
    {
        // Make the first line of the CSV the columns
        $out = implode("\t", $this->getFieldNames()) . PHP_EOL;
        // Add each row to the CSV
        foreach($this->rows as $row) {
            $out .= implode("\t", $row) . PHP_EOL;
        }
        
        return trim($out);
    }
}
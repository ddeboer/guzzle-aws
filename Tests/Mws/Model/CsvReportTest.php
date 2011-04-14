<?php

namespace Guzzle\Aws\Tests\Mws\Model;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Aws\Mws\Model\CsvReport;

/**
 * @covers Guzzle\Aws\Mws\Model\CsvReport
 * @author Harold Asbridge <harold@shoebacca.com>
 */
class CsvReportTest extends GuzzleTestCase
{
    public function testCsvReport()
    {
        // Valid tab-separated data
        $data = "A\tB\tC\n";
        $data .= "1\t2\t3\n";
        $data .= "4\t5\t6\n";

        $report = new CsvReport($data);
        $report->__construct($data);

        // Expected parsed format
        $expected = array(
            array(
                'A' => 1,
                'B' => 2,
                'C' => 3
            ),
            array(
                'A' => 4,
                'B' => 5,
                'C' => 6
            )
        );
        
        $this->assertEquals($expected, $report->getRows());
        $this->assertEquals(2, $report->count());
        $this->assertInstanceOf('\ArrayIterator', $report->getIterator());

        $report = new CsvReport($expected);
        $this->assertEquals($expected, $report->getRows());

        $str = $report->__toString();
        $this->assertInternalType('string', $str);
    }

    public function testBadCsvData()
    {
        $broken = "A\tB\n";
        $broken .= "1\n";
        $this->setExpectedException('UnexpectedValueException');
        $report = new CsvReport($broken);
    }

    public function testBadType()
    {
        $this->setExpectedException('InvalidArgumentException');
        $report = new CsvReport(false);
    }
}
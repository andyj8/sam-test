<?php

namespace App\Tests\Unit\Metric\Parse;

use App\Metric\ByteCount;
use App\Metric\Parse\JsonParser;
use DateTime;
use PHPUnit\Framework\TestCase;

class JsonParserTest extends TestCase
{
    public function testParsesJson()
    {
        $input = '{
          "data": [
            {
              "metricData": [
                {
                  "metricValue": 12693166.98,
                  "dtime": "2018-01-29"
                }
              ]
            }
          ]
        }';

        $parser = new JsonParser();
        $data = $parser->parse($input);

        $this->assertCount(1, $data->metrics());
        $this->assertEquals(new ByteCount(12693166.98), $data->metrics()[0]->value);
        $this->assertEquals(new DateTime('2018-01-29'), $data->metrics()[0]->dateTime);
    }
}

<?php


use Receiver\Parser\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{

    public function testSetData(): void
    {

        $this->expectException('RuntimeException');
        $this->expectExceptionCode(100);
        $this->expectExceptionMessage('Undefined data');
        $parser = new Parser();
        $parser->setData();
    }

    public function testGetResult()
    {
        $data = '{
          "meta": {
            "request_id": "ECgInKkKyl23bNgrkqUBaVaXBlYuE_rp"
          },
          "data": {
            "page": 1,
            "posts": [
              {
                "id": "post5d8686002016b_f63e4554",
                "from_name": "Rosann Eide",
                "from_id": "user_9",
                "message": "Test",
                "type": "status",
                "created_time": "2019-01-01T17:10:19+00:00"
              }
            ]
          }
        }';
        $array = json_decode($data, true);
        $parser = new Parser();
        $parser->setData($array);

        $this->assertIsArray($array);
        $this->assertTrue(isset($array['data']['posts']));
        $this->assertEquals(1, sizeof($array['data']['posts']));
        $this->assertEquals('ECgInKkKyl23bNgrkqUBaVaXBlYuE_rp', $array['meta']['request_id']);

        $parser->parseData();
        $result = $parser->getResult();
        $this->assertIsArray($result);

        // Test average section
        $this->assertTrue(isset($result['average']['2019-01']));
        $this->assertEquals(4, $result['average']['2019-01']['length']);
        $this->assertEquals(1, $result['average']['2019-01']['count']);
        $this->assertEquals(4, $result['average']['2019-01']['average']);

        // Test total_posts section
        $this->assertTrue(isset($result['total_posts']['01']));
        $this->assertEquals(array('count' => 1), $result['total_posts']['01']);

        // Test longest section
        $this->assertTrue(isset($result['longest']['2019-01']));
        $this->assertEquals(array(
            'id' => 'post5d8686002016b_f63e4554',
            'length' => 4
        ), $result['longest']['2019-01']);

        $this->assertTrue(isset($result['average_posts_month']));
        $this->assertEquals(1, $result['average_posts_month']);
    }
}

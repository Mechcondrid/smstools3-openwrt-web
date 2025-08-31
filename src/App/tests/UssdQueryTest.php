<?php
/**
 * Created by PhpStorm.
 * User: Mahadir
 * Date: 5/23/2015
 * Time: 2:21 PM
 */

namespace App\tests;


use App\Libraries\UssdQuery;
use PHPUnit\Framework\TestCase;

class UssdQueryTest extends TestCase {

    private $param;

    /**
     * @var UssdQuery
     */
    private $ussdQuery;

    protected function setUp(): void
    {
        $this->ussdQuery = new UssdQuery();
    }

    public function mockShell($param)
    {
        //mock the query result
        $this->param = $param;
        $result = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'gsm_ussd_result.txt');
        return $result;
    }

    public function sendCommand($command='*124#')
    {
        $this->ussdQuery->setShell(array($this,'mockShell'));
        $this->ussdQuery->sendCommand($command);
    }

    public function testSendCommand()
    {
        $command = '*124#';
        $this->sendCommand($command);
        $pattern = str_replace('*','\\*',$command);
        $this->assertMatchesRegularExpression('/\"AT\+CUSD=1, '.$pattern.' ,15\"/',
            $this->param,
            'Check if the send command exist in shell execute');
    }

    public function testGetRawUssdUCS2()
    {
        $this->sendCommand();
        $this->ussdQuery->parseResult();
        $this->assertNotEmpty($this->ussdQuery->getUSSDTextMessage());

    }


    public function testGetRawUssdUCS2Exception()
    {
        $this->expectException(\Exception::class);
        $array = $this->ussdQuery->getRawUssdUCS2();
    }

    public function testGetTextResult()
    {
        $this->sendCommand();
        $textMessage = $this->ussdQuery->getTextResult();
        //var_dump($this->ussdQuery->getUSSDRequireReply());
        $this->assertNotEmpty($textMessage);
    }

    public function testGetJsonResult()
    {
        $this->sendCommand();
        $jsonMessage = $this->ussdQuery->getJsonResult();
        $obj = json_decode($jsonMessage);
        //var_dump($obj);

        $this->assertObjectHasProperty('payload',$obj,'');
        $this->assertObjectHasProperty('message',$obj->payload,'');
        $this->assertObjectHasProperty('needReply',$obj->payload,'');
        $this->assertObjectHasProperty('error',$obj,'');
        $this->assertObjectHasProperty('success',$obj,'');

        $this->assertNotEmpty($obj->payload->message);
        $this->assertTrue($obj->success,'Success attribute value should be true');
    }

    public function testErrorGetJsonResult()
    {
        $jsonMessage = $this->ussdQuery->getJsonResult();
        $obj = json_decode($jsonMessage);
        //var_dump($obj);

        $this->assertObjectHasProperty('payload',$obj,'');
        $this->assertObjectHasProperty('exception',$obj->error,'');
        $this->assertObjectHasProperty('error',$obj,'');
        $this->assertObjectHasProperty('success',$obj,'');

        $this->assertFalse($obj->success,'Success attribute value should be false');
    }


}

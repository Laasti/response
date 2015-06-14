<?php

namespace Laasti\Response\Test;

use PHPUnit_Framework_TestCase;

class ResponderTest extends PHPUnit_Framework_TestCase
{

    public function testResponder()
    {
        $data = new \Dflydev\DotAccessData\Data;
        $responder = new \Laasti\Response\Responder($data);
        $responder->setData('page.title', 'My title');
        var_dump($responder->exportData());
    }

    public function testPlainPhpEngine()
    {
        $data = new \Dflydev\DotAccessData\Data;
        $engine = new \Laasti\Response\Engines\PlainPhp([__DIR__]);
        $responder = new \Laasti\Response\Responder($data, $engine);
        $responder->setData('page.title', 'My title');
        $response = $responder->view('plainphp-template');
        echo $response->getContent();
        $this->assertEquals($response->getContent(), 'My title');
    }

}

<?php

namespace Laasti\Response\Test;

use Dflydev\DotAccessData\Data;
use Laasti\Response\Engines\PlainPhp;
use Laasti\Response\Responder;
use Laasti\Response\ViewResponse;
use PHPUnit_Framework_TestCase;

class ResponderTest extends PHPUnit_Framework_TestCase
{

    public function testPlainPhpEngine()
    {
        $data = new Data;
        $engine = new PlainPhp([__DIR__]);
        $responder = new Responder($data, $engine);
        $responder->setData('page.title', 'My title');

        $response = $responder->view('plainphp-template');
        $this->assertEquals($response->getContent(), 'My title');

        $response = $responder->view('plainphp-template.php');
        $this->assertEquals($response->getContent(), 'My title');

    }

    public function testTemplateLocations()
    {
        $engine = new PlainPhp([__DIR__]);

        $engine->addLocation('/append-folder');
        $engine->prependLocation('/prepend-folder');

        $locations = \PHPUnit_Framework_Assert::readAttribute($engine, 'locations');

        $this->assertEquals('/append-folder', $locations[2]);
        $this->assertEquals('/prepend-folder', $locations[0]);

    }

    public function testNotFound()
    {
        $engine = new PlainPhp([__DIR__]);
        $this->setExpectedException("Laasti\Response\Exceptions\TemplateNotFoundException");
        $this->assertEquals('Test title', $engine->render('plainphp-template', ['page' => ['title' => 'Test title']]));
        $engine->render('template-notfound');
        
    }

    public function testTemplateEngineAssigment()
    {
        $data = new Data;
        $engine = new PlainPhp([__DIR__]);
        $responder = new Responder($data, $engine);
        $engine2 = new PlainPhp([__DIR__]);

        $this->assertTrue($responder->getTemplateEngine() === $engine);
        $responder->setTemplateEngine($engine2);
        $this->assertTrue($responder->getTemplateEngine() !== $engine);
        $this->assertTrue($responder->getTemplateEngine() === $engine2);

    }

    public function testResponderData()
    {
        $data = new Data;
        $engine = new PlainPhp([__DIR__]);
        $responder = new Responder($data, $engine);

        $responder->setData('first', 1);
        $responder->addData(['batch' => 2, 'another' => 3]);
        $this->assertTrue(['first'=> 1, 'batch' => 2, 'another' => 3] == $responder->exportData());
        $responder->setData('first', 4);
        $this->assertTrue($responder->getData('first') === 4);
        $this->assertTrue($responder->getData('notexist') === null);
        $this->assertTrue($responder->getData('notexist', 4) === 4);
        $responder->unsetData('first');
        $this->assertTrue(['batch' => 2, 'another' => 3] == $responder->exportData());
        $responder->clearData();
        $this->assertTrue(count($responder->exportData()) === 0);
        $responder->setData('append', ['test']);
        $responder->appendData('append', 'test2');
        $this->assertTrue(['test', 'test2'] == $responder->getData('append'));
    }

    public function testNoViewResponse()
    {
        $engine = new PlainPhp([__DIR__]);
        $response = new ViewResponse($engine);

        $this->setExpectedException("RuntimeException");
        $response->getContent();

    }

    public function testViewTemplateEngine()
    {
        $engine = new PlainPhp([__DIR__]);
        $engine2 = new PlainPhp([__DIR__]);
        $response = new ViewResponse($engine);

        $this->assertTrue($response->getTemplateEngine() === $engine);
        $response->setTemplateEngine($engine2);
        $this->assertTrue($response->getTemplateEngine() === $engine2);

    }

    public function testSetViewdata()
    {
        $engine = new PlainPhp([__DIR__]);
        $response = new ViewResponse($engine);

        $this->expectOutputString('Test');
        $response->setView('plainphp-template');
        $response->setViewdata(['page' => ['title' => 'Test']]);
        $response->sendContent();
    }

    public function testSetData()
    {
        $engine = new PlainPhp([__DIR__]);
        $response = new ViewResponse($engine);

        $this->expectOutputString('Testdata');
        $response->setView('plainphp-template');
        $response->setData('page', ['title' => 'Testdata']);
        $response->sendContent();
    }

    public function testFailCreateView()
    {
        $engine = new PlainPhp([__DIR__]);
        $response = new ViewResponse($engine);

        $this->setExpectedException("InvalidArgumentException");
        $response->create();
    }

}

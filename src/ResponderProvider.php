<?php

namespace Laasti\Response;

use League\Container\ServiceProvider;

class ResponderProvider extends ServiceProvider
{
    protected $provides = [
        'Laasti\Response\Engines\TemplateEngineInterface',
        'Laasti\Response\Engines\PlainPhp',
        'Laasti\Response\Data\DataInterface',
        'Laasti\Response\Data\ArrayData',
        'Laasti\Response\ResponderInterface',
        'Laasti\Response\Responder',
    ];

    public function register()
    {
        $di = $this->getContainer();

        $di->add('Laasti\Response\ResponderInterface', 'Laasti\Response\Responder');
        $di->add('Laasti\Response\Responder', null, true)->withArguments(['Laasti\Response\Data\DataInterface', 'Laasti\Response\Engines\TemplateEngineInterface']);
        $di->add('Laasti\Response\Engines\TemplateEngineInterface', 'Laasti\Response\Engines\PlainPhp');
        $di->add('Laasti\Response\Engines\PlainPhp')->withArguments(['config.responder.locations']);
        $di->add('Laasti\Response\Data\DataInterface', 'Laasti\Response\Data\ArrayData');
        $di->add('Laasti\Response\Data\ArrayData')->withArguments(['config.responder.data']);
    }
}

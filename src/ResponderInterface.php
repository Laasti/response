<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Laasti\Response;

use Laasti\Response\Engines\TemplateEngineInterface;

/**
 *
 * @author Sonia
 */
interface ResponderInterface
{

    public function getData($key);
    public function exportData();
    public function setData($key, $data);
    public function addData(array $data);
    public function clearData();
    public function unsetData($key);
    public function appendData($key, $data);
    public function setTemplateEngine(TemplateEngineInterface $engine);
    public function redirect($uri);
    public function json();
    public function view($template);
    public function raw();

}

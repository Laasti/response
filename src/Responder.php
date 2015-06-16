<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Laasti\Response;

use Dflydev\DotAccessData\DataInterface;
use Laasti\Response\Engines\TemplateEngineInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of Responder
 *
 * @author Sonia
 */
class Responder implements ResponderInterface
{

    protected $dataBag;
    protected $templateEngine;
    protected $raw;
    protected $json;
    protected $view;
    protected $redirect;

    public function __construct(DataInterface $dataBag, TemplateEngineInterface $templateEngine = null, Response $raw = null, JsonResponse $json = null, RedirectResponse $redirect = null, ViewResponse $view = null)
    {
        $this->dataBag = $dataBag;
        $this->templateEngine = $templateEngine;
        $this->raw = $raw ?: new Response();
        $this->json = $json ?: new JsonResponse();
        $this->redirect = $redirect ?: new RedirectResponse('/');
        $this->view = $view ?: new ViewResponse();
    }

    public function getData($key)
    {
        return $this->dataBag->get($key);
    }

    public function exportData()
    {
        return $this->dataBag->export();
    }

    public function setData($key, $data)
    {
        $this->dataBag->set($key, $data);
        return $this;
    }

    public function addData(array $array)
    {
        $this->dataBag->import($array);
        return $this;
    }

    public function clearData()
    {
        $class = get_class($this->dataBag);
        
        $this->dataBag = new $class;
        return $this;
    }

    public function unsetData($key)
    {
        $this->dataBag->remove($key);
        return $this;
    }

    public function appendData($key, $data)
    {
        $this->dataBag->append($key, $data);
        return $this;
    }

    public function setTemplateEngine(TemplateEngineInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
        return $this;
    }

    public function redirect($url, $status = 302, $headers = [])
    {
        return $this->redirect->create($url, $status, $headers);
    }

    public function json($status = 200, $headers = [])
    {
        return $this->json->create($this->exportData(), $status, $headers);
    }

    public function view($template, $status = 200, $headers = [])
    {
        return $this->view->create($this->templateEngine, $template, $this->exportData(), $status, $headers);
    }

    public function raw($content = '', $status = 200, $headers = [])
    {
        return $this->raw->create($content, $status, $headers);
    }
}

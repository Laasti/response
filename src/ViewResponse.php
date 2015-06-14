<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Laasti\Response;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of ViewResponse
 *
 * @author Sonia
 */
class ViewResponse extends Response
{
    protected $template;
    protected $view;
    protected $context;

    public function __construct(TemplateEngineInterface $template = null, $view = null, $context = [], $status = 200, $headers = array())
    {
        $this->template = $template;
        $this->view = $view;
        $this->context = $context;

        parent::__construct('', $status, $headers);
    }

    public static function create($template = null, $view = '', $context = [], $status = 200, $headers = array())
    {
        if (!$template instanceof TemplateEngineInterface) {
            throw new \InvalidArgumentException('The first argument of ViewResponse::create must be an instance of Laasti\Response\TemplateEngineInterface');
        }
        return new static($template, $view, $context, $status, $headers);
    }

    public function getTemplateEngine() {
        return $this->template;
    }

    public function setTemplateEngine(TemplateEngineInterface $template) {
        $this->template = $template;
        return $this;
    }

    public function setView($view) {
        $this->view = $view;
        return $this;
    }

    public function setContext($view) {
        $this->context = $view;
        return $this;
    }

    public function setData($key, $value) {
        $this->context[$key] = $value;
        return $this;
    }

    public function getContent()
    {
        if (is_null($this->view)) {
            throw new RuntimeException('No view was set for the ViewResponse object.');
        }
        return $this->template->render($this->view, $this->context);
    }


    public function sendContent()
    {
        echo $this->getContent();

        return $this;
    }

}


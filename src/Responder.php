<?php

namespace Laasti\Response;

use Dflydev\DotAccessData\DataInterface;
use Laasti\Response\Engines\TemplateEngineInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * {@inheritdoc}
 */
class Responder implements ResponderInterface
{

    protected $dataBag;
    protected $templateEngine;
    protected $raw;
    protected $json;
    protected $view;
    protected $redirect;
    protected $file;
    protected $stream;

    public function __construct(
            DataInterface $dataBag, TemplateEngineInterface $templateEngine = null,
            Response $raw = null, JsonResponse $json = null,
            RedirectResponse $redirect = null, ViewResponse $view = null,
            BinaryFileResponse $file = null, StreamedResponse $stream = null
    ){
        $this->dataBag = $dataBag;
        $this->templateEngine = $templateEngine;
        $this->raw = $raw ? : new Response();
        $this->json = $json ? : new JsonResponse();
        $this->redirect = $redirect ? : new RedirectResponse('/');
        $this->view = $view ? : new ViewResponse();
        $this->file = $file ? : new BinaryFileResponse(__FILE__);
        $this->stream = $stream ? : new StreamedResponse();
    }

    /**
     * {@inheritdoc}
     */
    public function getData($key, $default = null)
    {
        return $this->dataBag->get($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function setData($key, $data)
    {
        $this->dataBag->set($key, $data);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function unsetData($key)
    {
        $this->dataBag->remove($key);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function appendData($key, $data)
    {
        $this->dataBag->append($key, $data);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addData(array $array)
    {
        $this->dataBag->import($array);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function exportData()
    {
        return $this->dataBag->export();
    }

    /**
     * {@inheritdoc}
     */
    public function clearData()
    {
        $class = get_class($this->dataBag);

        $this->dataBag = new $class;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateEngine()
    {
        return $this->templateEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplateEngine(TemplateEngineInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function redirect($url, $status = 302, $headers = [])
    {
        return $this->redirect->create($url, $status, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function json($status = 200, $headers = [])
    {
        return $this->json->create($this->exportData(), $status, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function view($template, $status = 200, $headers = [])
    {
        return $this->view->create($this->templateEngine, $template, $this->exportData(), $status, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function raw($content = '', $status = 200, $headers = [])
    {
        return $this->raw->create($content, $status, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function download($file = null, $status = 200, $headers = array(),
            $public = true, $contentDisposition = null, $autoEtag = false,
            $autoLastModified = true)
    {
        return $this->file->create($file, $status, $headers, $public, $contentDisposition, $autoEtag, $autoLastModified);
    }

    /**
     * {@inheritdoc}
     */
    public function stream($callable = null, $status = 200, $headers = array())
    {
        return $this->stream->create($callable, $status, $headers);
    }

}

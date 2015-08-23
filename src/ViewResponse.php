<?php

namespace Laasti\Response;

use InvalidArgumentException;
use Laasti\Response\Engines\TemplateEngineInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

/**
 * A response that renders a template using the template engine
 */
class ViewResponse extends Response
{

    /**
     * Template engine
     * @var TemplateEngineInterface
     */
    protected $template;

    /**
     * View to render
     * @var string
     */
    protected $view;

    /**
     * The data to pass to the view
     * @var array
     */
    protected $viewdata;

    public function __construct(TemplateEngineInterface $template = null, $view = null, $viewdata = [], $status = 200, $headers = array())
    {
        $this->template = $template;
        $this->view = $view;
        $this->viewdata = $viewdata;

        parent::__construct('', $status, $headers);
    }

    /**
     * Instantiates a new ViewResponse
     * @param TemplateEngineInterface $template
     * @param string $view
     * @param array $viewdata
     * @param int $status
     * @param array $headers
     * @return \static
     * @throws InvalidArgumentException
     */
    public static function create($template = null, $view = '', $viewdata = [], $status = 200, $headers = array())
    {
        if (!$template instanceof TemplateEngineInterface) {
            throw new InvalidArgumentException('The first argument of ViewResponse::create must be an instance of Laasti\Response\Engines\TemplateEngineInterface');
        }
        return new static($template, $view, $viewdata, $status, $headers);
    }

    /**
     * Returns the current template engine
     * @return TemplateEngineInterface
     */
    public function getTemplateEngine()
    {
        return $this->template;
    }

    /**
     * Sets a new template engine
     * @param TemplateEngineInterface $template
     * @return ViewResponse
     */
    public function setTemplateEngine(TemplateEngineInterface $template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Sets a new view to render
     * @param string $view
     * @return ViewResponse
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Overwrites the current viewdata array
     * @param array $data
     * @return ViewResponse
     */
    public function setViewdata($data)
    {
        $this->viewdata = $data;
        return $this;
    }

    /**
     * Sets a new value in the viewdata
     * @param string $key
     * @param mixed $value
     * @return ViewResponse
     */
    public function setData($key, $value)
    {
        $this->viewdata[$key] = $value;
        return $this;
    }

    /**
     * Renders the template
     * @return string
     * @throws RuntimeException
     */
    public function getContent()
    {
        if (is_null($this->view)) {
            throw new RuntimeException('No view was set for the ViewResponse object.');
        }
        return $this->template->render($this->view, $this->viewdata);
    }

    /**
     * Outputs the rendered content
     * @return ViewResponse
     */
    public function sendContent()
    {
        echo $this->getContent();

        return $this;
    }

}

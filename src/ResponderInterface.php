<?php

namespace Laasti\Response;

use Laasti\Response\Engines\TemplateEngineInterface;

/**
 * Functionality that must be implemented by a responder
 */
interface ResponderInterface
{

    /**
     * Returns the value of the viewdata key
     * @param string $key
     */
    public function getData($key, $default = null);

    /**
     * Sets the value of the viewdata key
     * @param string $key
     * @param mixed $data
     */
    public function setData($key, $data);

    /**
     * Removes viewdata key
     * @param string $key
     */
    public function unsetData($key);

    /**
     * Adds data to a viewdata key
     * @param string $key
     * @param mixed $data
     */
    public function appendData($key, $data);


    /**
     * Adds data in a batch
     * @param array $data
     */
    public function addData(array $data);

    /**
     * Exports all data
     */
    public function exportData();

    /**
     * Clears all data
     */
    public function clearData();

    /**
     * Returns the current template engine
     */
    public function getTemplateEngine();

    /**
     * Sets a new template engine
     * @param TemplateEngineInterface $engine
     */
    public function setTemplateEngine(TemplateEngineInterface $engine);

    /**
     * Redirects the user to a new page
     * @param string $uri
     * @param int $status
     * @param array $headers
     */
    public function redirect($uri, $status = 302, $headers = []);

    /**
     * Returns a JSON encoded response of the viewdata
     * @param int $status
     * @param array $headers
     */
    public function json($status = 200, $headers = []);

    /**
     * Renders the template using the template engine and the viewdata
     *
     * @param string $template
     * @param int $status
     * @param array $headers
     */
    public function view($template, $status = 200, $headers = []);

    /**
     * Returns the content as is. Can be used to output raw HTML.
     * @param string $content
     * @param int $status
     * @param array $headers
     */
    public function raw($content, $status = 200, $headers = []);

    /**
     * Returns a response to download a file
     * @param string $file
     * @param int $status
     * @param array $headers
     */
    public function download($file, $status = 200, $headers = []);

    /**
     * Returns a streamable response
     * @param callable $callable
     * @param int $status
     * @param array $headers
     */
    public function stream($callable, $status = 200, $headers = []);

}

<?php

namespace Laasti\Response\Engines;

use Laasti\Response\Engines\TemplateEngineInterface;
use Laasti\Response\Exceptions\TemplateNotFoundException;

/**
 * A template engine that works as plain PHP
 * The first level of viewdata is declared as variables
 */
class PlainPhp implements TemplateEngineInterface
{

    /**
     * The different folders to look for templates
     * @var array
     */
    protected $locations;

    /**
     * Constructor
     * @param array $locations
     */
    public function __construct($locations = [])
    {
        $this->locations = $locations;
    }

    /**
     * Adds a new folder to look for templates
     * @param string $folder
     * @return PlainPhp
     */
    public function addLocation($folder)
    {
        array_push($this->locations, $folder);
        return $this;
    }

    /**
     * Prepends a new folder to look for templates
     * @param string $folder
     * @return PlainPhp
     */
    public function prependLocation($folder)
    {
        array_unshift($this->locations, $folder);
        return $this;
    }

    /**
     * Renders a template, the first level of data is extracted as variables
     * @param string $file
     * @param array $data
     * @return type
     */
    public function render($file, $data = [])
    {
        $filepath = $this->findTemplateFile($file);
        extract($data);
        ob_start();
        include $filepath;
        $content = ob_get_contents();
        @ob_end_clean();
        return $content;
    }

    /**
     * Finds the file by looping through locations
     * @param string $file
     * @return string
     * @throws TemplateNotFoundException
     */
    protected function findTemplateFile($file)
    {
        //Add missing extension
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $file = ($ext === '') ? $file . '.php' : $file;

        $found = false;
        foreach ($this->locations as $location) {
            if (is_file($location . '/' . $file)) {
                $found = true;
                $file = $location . '/' . $file;
                continue;
            }
        }

        if (!$found) {
            throw new TemplateNotFoundException('This template was not found in any of the registered locations: ' . $file);
        }

        return $file;
    }

}

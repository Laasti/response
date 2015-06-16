<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Laasti\Response\Engines;

use Laasti\Response\Exceptions\TemplateNotFoundException;
use Laasti\Response\Engines\TemplateEngineInterface;

/**
 * Description of PlainPhp
 *
 * @author Sonia
 */
class PlainPhp implements TemplateEngineInterface
{
    protected $locations;

    public function __construct($locations = [])
    {
        $this->locations = $locations;
    }

    public function addLocation($folder) {
        $this->locations[] = $folder;
        return $this;
    }

    public function prependLocation($folder) {
        array_unshift($this->locations, $folder);
        return $this;
    }

    public function render($file, array $data = []) {
        extract($data);
        ob_start();
        include $this->findTemplateFile($file);
        $content = ob_get_contents();
        @ob_end_clean();
        return $content;
    }

    protected function findTemplateFile($file)
    {
        //Add missing extension
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $file = ($ext === '') ? $file.'.php' : $file;

        $found = false;
        foreach ($this->locations as $location) {
            if (is_file($location.'/'.$file)) {
                $found = true;
                $file = $location.'/'.$file;
            }
        }

        if (!$found) {
            throw new TemplateNotFoundException('This template was not found in any of the registered locations: '.$file);
        }

        return $file;
    }
}

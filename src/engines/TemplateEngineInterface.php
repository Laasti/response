<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Laasti\Response\Engines;

/**
 *
 * @author Sonia
 */
interface TemplateEngineInterface
{
    public function render($template_file, array $data = null);
}

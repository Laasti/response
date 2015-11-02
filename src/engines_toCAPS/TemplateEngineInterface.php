<?php

namespace Laasti\Response\Engines;

/**
 * Interface for template engines
 */
interface TemplateEngineInterface
{

    /**
     * Renders the template file using the data
     * @param type $template_file
     * @param array $data
     */
    public function render($template_file, $data = null);
}

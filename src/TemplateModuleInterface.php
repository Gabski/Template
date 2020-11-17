<?php

namespace Template;

/**
 * Interface TemplateModuleInterface
 * @package Template
 */
interface TemplateModuleInterface
{
    /**
     *
     */
    const START_TAG = "{% ";
    /**
     *
     */
    const END_TAG = " %}";

    /**
     * @param string $source
     * @return string
     */
    public function processSource(string $source): string;
}
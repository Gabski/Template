<?php

namespace Template;

interface TemplateModuleInterface
{
    const START_TAG = "{% ";
    const END_TAG   = " %}";

    public function processSource(string $source): string;
}
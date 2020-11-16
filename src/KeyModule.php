<?php

namespace Template;

class KeyModule implements TemplateModuleInterface
{
    private $keys;

    public function __construct(array $keys)
    {
        $this->keys = $keys;
    }

    public function processSource(string $source): string
    {
        $newSource = $source;

        if (!empty($this->keys)) {
            foreach ($this->keys as $key => $value) {
                $newSource = str_replace(self::START_TAG . $key . self::END_TAG, $value, $newSource);
            }
        }

        return $newSource;
    }
}
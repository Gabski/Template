<?php

namespace Template;

/**
 * Class Template
 * @package Template
 */
class Template
{
    private $template, $keys, $path, $type, $source;

    /**
     * Template constructor.
     * @param null   $template
     * @param array  $keys
     * @param string $path
     * @param string $type
     */
    public function __construct($template = null, $keys = [], $path = "templates/", $type = "tpl")
    {
        $this->keys = $keys;
        $this->load($template, $path, $type);
    }

    /**
     * @param null   $template
     * @param string $path
     * @param string $type
     */
    public function load($template = null, $path = "templates/", $type = "tpl")
    {
        $this->template = $template;
        $this->path     = $path;
        $this->type     = $type;

        $this->source = file_get_contents($this->path . $this->template . '.' . $this->type);
    }

    /**
     * @param $key
     * @param $value
     */
    public function addKey($key, $value)
    {
        $this->keys[$key] = $value;
    }

    /**
     * @return bool
     */
    public function render()
    {
        if (!$this->source) {
            return false;
        }

        $modules = [
            new IncludeModule($this->path),
            new KeyModule($this->keys),
        ];

        foreach ($modules as $module) {
            $this->source = $module->processSource($this->source);
        }

        return $this->source;
    }
}
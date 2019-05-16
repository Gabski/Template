<?php
class Template
{
    private $template, $keys, $path, $type;

    public function __construct($template = null, $path = "templates/", $type = "tpl")
    {
        $this->load($template, $path, $type);
    }

    public function load($template = null, $path = "templates/", $type = "tpl")
    {
        $this->template = $template;
        $this->path = $path;
        $this->type = $type;
    }

    public function key($key, $value)
    {

        $this->keys[strtoupper($key)] = $value;
    }

    public function init()
    {

        $source = @file_get_contents($this->path . $this->template . '.' . $this->type);

        if ($source) {

            preg_match_all("/{include (.*?)}/i", $source, $matches);

            if (!empty($matches)) {
                for ($i = 0; $i < count($matches[0]); $i++) {
                    $new = @file_get_contents($this->path . $matches[1][$i]);
                    $source = str_replace($matches[0][$i], $new, $source);
                }
            }

            if (!empty($this->keys)) {
                foreach ($this->keys as $key => $value) {
                    $source = str_replace('{' . $key . '}', $value, $source);
                }
            }

            return $source;
        } else {
            return false;
        }
    }
}
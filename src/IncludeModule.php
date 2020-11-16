<?php

namespace Template;

class IncludeModule implements TemplateModuleInterface
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function processSource(string $source): string
    {
        $newSource = $source;

        preg_match_all("/" . self::START_TAG . "include (.*?)" . self::END_TAG . "/i", $newSource, $matches);

        if (!empty($matches)) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $new       = file_get_contents($this->path . $matches[1][$i]);
                $newSource = str_replace($matches[0][$i], $new, $newSource);
            }
        }


        return $newSource;
    }
}
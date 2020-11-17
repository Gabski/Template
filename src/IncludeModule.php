<?php

namespace Template;

/**
 * Class IncludeModule
 * @package Template
 */
class IncludeModule implements TemplateModuleInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * IncludeModule constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @param string $source
     * @return string
     */
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
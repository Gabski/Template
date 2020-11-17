<?php

namespace Template;

/**
 * Class KeyModule
 * @package Template
 */
class KeyModule implements TemplateModuleInterface
{
    /**
     * @var array
     */
    private $keys;

    /**
     * KeyModule constructor.
     * @param array $keys
     */
    public function __construct(array $keys)
    {
        $this->keys = $keys;
    }

    /**
     * @param string $source
     * @return string
     */
    public function processSource(string $source): string
    {
        $newSource = $source;

        if (!empty($this->keys)) {
            foreach ($this->keys as $key => $value) {


                if ($this->array_module($key, $value, $newSource)) {
                    continue;
                }

                if ($this->object_module($key, $value, $newSource)) {
                    continue;
                }

                $newSource = str_replace(self::START_TAG . $key . self::END_TAG, $value, $newSource);
            }
        }

        $this->if_module($newSource);

        return $newSource;
    }


    /**
     * @param $key
     * @param $value
     * @param $source
     * @return bool
     */
    private function array_module($key, $value, &$source)
    {
        if (is_array($value)) {
            foreach ($value as $arrayKey => $arrayValue) {

                if (is_array($arrayValue)) {
                    foreach ($arrayValue as $arrayKey2 => $arrayValue2) {
                        $source =
                            str_replace(self::START_TAG . $key . ':' . $arrayKey . ':' . $arrayKey2 . self::END_TAG,
                                $arrayValue2, $source);

                    }

                    $source = str_replace(self::START_TAG . $key . ":" . $arrayKey . self::END_TAG, "[Array]", $source);

                    continue;
                }

                $source =
                    str_replace(self::START_TAG . $key . ":" . $arrayKey . self::END_TAG, $arrayValue, $source);
            }

            $source = str_replace(self::START_TAG . $key . self::END_TAG, "[Array]", $source);

            return true;
        }

        return false;
    }


    /**
     * @param $key
     * @param $value
     * @param $source
     * @return bool
     */
    private function object_module($key, $value, &$source)
    {
        if (is_object($value)) {

            $class_methods = get_class_methods($value);

            foreach ($class_methods as $method) {

                if (strpos($method, 'get') === false && strpos($method, 'has') === false && strpos($method,
                        'is') === false) {
                    continue;
                }

                $source =
                    str_replace(self::START_TAG . $key . "." . $method . self::END_TAG, $value->$method(), $source);
            }

            $source = str_replace(self::START_TAG . $key . self::END_TAG, "[Obj]", $source);

            return true;
        }

        return false;
    }

    /**
     * @param $source
     */
    private function if_module(&$source)
    {
        preg_match_all("/" . self::START_TAG . "if (.*?)" . self::END_TAG . "(.*?)" . self::START_TAG . "endif" . self::END_TAG . "/i",
            $source, $matches);


        if (!empty($matches)) {


            for ($i = 0; $i < count($matches[0]); $i++) {

                $isTrue =
                    $matches[1][$i] !== "false" &&
                    $matches[1][$i] !== "null" &&
                    $matches[1][$i] !== 0 &&
                    $matches[1][$i] !== "0";

                $change = $isTrue ? $matches[2][$i] : "";
                $source = str_replace($matches[0][$i], $change, $source);
            }
        }

    }
}
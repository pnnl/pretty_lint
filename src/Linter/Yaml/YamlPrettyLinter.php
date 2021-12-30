<?php

/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 4:10 PM
 */

namespace Pnnl\PrettyJSONYAML\Linter\Yaml;

use Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter;
use Pnnl\PrettyJSONYAML\Parser\YamlParser;
use ReflectionException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlPrettyLinter
 *
 * @package Pnnl\PrettyJSONYAML\Linter\Yaml
 */
class YamlPrettyLinter extends AbstractPrettyLinter
{
    /**
     * @var YamlParser
     */
    protected $parser;

    /**
     * This method can be used to determine the Symfony Linter version.
     * If this method returns true, you are using Symfony YAML > 3.1.
     *
     * @link http://symfony.com/blog/new-in-symfony-3-1-customizable-yaml-parsing-and-dumping
     *
     * @return bool
     * @throws ReflectionException
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public static function supportsFlags(): bool
    {
        return YamlParser::supportsFlags();
    }

    /**
     * @return bool
     */
    public function isInstalled(): bool
    {
        return class_exists(Yaml::class);
    }

    /**
     * @param int $indent
     */
    public function setIndent($indent): void
    {
        $this->parser->setIndent($indent);
    }

    /**
     * @param boolean $flag
     */
    public function setObjectSupport($flag): void
    {
        $this->parser->setObjectSupport($flag);
    }

    /**
     * @param bool $flag
     */
    public function setParseConstants($flag): void
    {
        // Yaml::PARSE_CUSTOM_TAGS is only available in Symfony Yaml >= 3.3
        $this->parser->setParseConstants($flag);
    }

    /**
     * @param bool $flag
     */
    public function setParseCustomTags($flag): void
    {
        // Yaml::PARSE_CONSTANT is only available in Symfony Yaml >= 3.2
        $this->parser->setParseCustomTags($flag);
    }

    /**
     * @param boolean $flag
     */
    public function setExceptionOnInvalidType($flag): void
    {
        $this->parser->setExceptionOnInvalidType($flag);
    }
}

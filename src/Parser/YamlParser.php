<?php

/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/9/18
 * Time: 5:36 PM
 */

namespace Pnnl\PrettyJSONYAML\Parser;

use ReflectionClass;
use ReflectionException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlParser
 *
 * @package Pnnl\PrettyJSONYAML\Parser
 */
class YamlParser extends AbstractParser
{
    /** @var bool $objectSupport - True if object support is enabled, false otherwise */
    private $objectSupport = false;

    /** @var bool $invalidTypeExc - True if an exception must be thrown on invalid types false otherwise */
    private $invalidTypeExc = false;

    /** @var bool $parseCustomTags - True if custom tags needs to be parsed */
    private $parseCustomTags = false;

    /** @var bool $parseConstants - True if PHP constants needs to be parsed */
    private $parseConstants = false;

    /**
     * {@inheritdoc}
     *
     * @throws \ReflectionException
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function parse($content): array
    {
        // Lint on Symfony Yaml < 3.1
        if (!self::supportsFlags()) {
            return Yaml::parse($content, $this->invalidTypeExc, $this->objectSupport);
        }

        // Lint on Symfony Yaml >= 3.1
        $flags = 0;
        $flags |= $this->objectSupport ? Yaml::PARSE_OBJECT : 0;
        $flags |= $this->invalidTypeExc ? Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE : 0;
        $flags |= $this->parseConstants ? Yaml::PARSE_CONSTANT : 0;
        $flags |= $this->parseCustomTags ? Yaml::PARSE_CUSTOM_TAGS : 0;
        return Yaml::parse($content, $flags);
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function dump(array $data): string
    {
        // Cannot use INF since it returns a float and Yaml::dump requires an INT
        return Yaml::dump($data, PHP_INT_MAX, $this->indent);
    }

    /**
     * This method can be used to determine the Symfony Linter version.
     * If this method returns true, you are using Symfony YAML > 3.1.
     *
     * @link http://symfony.com/blog/new-in-symfony-3-1-customizable-yaml-parsing-and-dumping
     *
     * @return bool
     * @throws ReflectionException
     */
    public static function supportsFlags(): bool
    {
        $class = new ReflectionClass(Yaml::class);
        $method = $class->getMethod('parse');
        $params = $method->getParameters();

        return $params[1]->getName() === 'flags';
    }

    /**
     * @param boolean $flag
     */
    public function setObjectSupport($flag): void
    {
        $this->objectSupport = $flag;
    }

    /**
     * @param boolean $flag
     */
    public function setExceptionOnInvalidType($flag): void
    {
        $this->invalidTypeExc = $flag;
    }

    /**
     * @param bool $flag
     */
    public function setParseCustomTags($flag): void
    {
        // Yaml::PARSE_CONSTANT is only available in Symfony Yaml >= 3.2
        $defined = defined('Symfony\Component\Yaml\Yaml::PARSE_CONSTANT');
        $this->parseCustomTags = $flag && $defined;
    }

    /**
     * @param bool $flag
     */
    public function setParseConstants($flag): void
    {
        // Yaml::PARSE_CUSTOM_TAGS is only available in Symfony Yaml >= 3.3
        $defined = defined('Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS');
        $this->parseConstants = $flag && $defined;
    }
}

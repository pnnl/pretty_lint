<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/9/18
 * Time: 5:36 PM
 */

namespace Pnnl\PrettyJSONYAML\Parser;

use Pnnl\PrettyJSONYAML\Exception\OrderException;
use Pnnl\PrettyJSONYAML\Linter\LintError;
use Pnnl\PrettyJSONYAML\Linter\Yaml\YamlPrettyLintError;
use ReflectionClass;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;


class YamlParser implements ParserInterface
{

    /**
     * True if object support is enabled, false otherwise
     *
     * @var bool
     */
    private $objectSupport = false;

    /**
     * True if an exception must be thrown on invalid types false otherwise
     *
     * @var bool
     */
    private $exceptionOnInvalidType = false;

    /**
     * True if custom tags needs to be parsed
     *
     * @var bool
     */
    private $parseCustomTags = false;

    /**
     * True if PHP constants needs to be parsed
     *
     * @var bool
     */
    private $parseConstants = false;

    /** @var int $indent */
    private $indent;


    /**
     * {@inheritdoc}
     */
    public function __construct($indent = 2)
    {
        $this->indent = $indent;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($data)
    {
        // Lint on Symfony Yaml < 3.1
        if (!$this->supportsFlags()) {
            return Yaml::parse($data,
              $this->exceptionOnInvalidType,
              $this->objectSupport);
        }

        // Lint on Symfony Yaml <= 3.1
        $flags = 0;
        $flags |= $this->objectSupport ? Yaml::PARSE_OBJECT : 0;
        $flags |= $this->exceptionOnInvalidType ? Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE : 0;
        $flags |= $this->parseConstants ? Yaml::PARSE_CONSTANT : 0;
        $flags |= $this->parseCustomTags ? Yaml::PARSE_CUSTOM_TAGS : 0;
        return Yaml::parse($data, $flags);
    }

    /**
     * {@inheritdoc}
     */
    public function parseFile($fileName)
    {
        return Yaml::parseFile($fileName);
    }

    /**
     * {@inheritdoc}
     */
    public function dump(array $data)
    {
        return Yaml::dump($data, 0, $this->indent);
    }

    /**
     * {@inheritdoc}
     */
    public function dumpFile(array $data, $filename)
    {
        $yaml = $this->dump($data);
        file_put_contents($filename, $yaml);
    }

    /**
     * {@inheritdoc}
     */
    public function setIndent($indent)
    {
        $this->indent = $indent;
    }

    /**
     * This method can be used to determine the Symfony Linter version.
     * If this method returns true, you are using Symfony YAML > 3.1.
     *
     * @link http://symfony.com/blog/new-in-symfony-3-1-customizable-yaml-parsing-and-dumping
     *
     * @return bool
     */
    private function supportsFlags()
    {
        $rc = new ReflectionClass(Yaml::class);
        $method = $rc->getMethod('parse');
        $params = $method->getParameters();

        return $params[1]->getName() === 'flags';
    }
}

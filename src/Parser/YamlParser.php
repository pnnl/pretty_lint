<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/9/18
 * Time: 5:36 PM
 */

namespace Pnnl\PrettyJSONYAML\Parser;

use GrumPHP\Util\Filesystem;
use ReflectionClass;
use ReflectionException;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;


class YamlParser implements ParserInterface
{

    /** @var bool $objectSupport - True if object support is enabled, false otherwise */
    private $objectSupport = false;

    /** @var bool $exceptionOnInvalidType - True if an exception must be thrown on invalid types false otherwise */
    private $exceptionOnInvalidType = false;

    /** @var bool $parseCustomTags - True if custom tags needs to be parsed */
    private $parseCustomTags = false;

    /** @var bool $parseConstants - True if PHP constants needs to be parsed */
    private $parseConstants = false;

    /** @var int $indent - number of spaces to indent each level */
    private $indent;

    /** @var Filesystem $filesystem */
    private $filesystem;

    /**
     * {@inheritdoc}
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($content)
    {
        // Lint on Symfony Yaml < 3.1
        if (!$this->supportsFlags()) {
            return Yaml::parse($content, $this->exceptionOnInvalidType,
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
    public function parseFile(SplFileInfo $file)
    {
        return Yaml::parseFile($file->getPathname());
    }

    /**
     * {@inheritdoc}
     */
    public function dump(array $data)
    {
        return Yaml::dump($data, INF, $this->indent);
    }

    /**
     * {@inheritdoc}
     */
    public function dumpFile(array $data, SplFileInfo $file)
    {
        $yaml = $this->dump($data);
        $this->filesystem->dumpFile($file->getPathname(), $yaml);
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
     * @throws ReflectionException
     */
    public static function supportsFlags()
    {
        $rc = new ReflectionClass(Yaml::class);
        $method = $rc->getMethod('parse');
        $params = $method->getParameters();

        return $params[1]->getName() === 'flags';
    }

    /**
     * @param boolean $objectSupport
     */
    public function setObjectSupport($objectSupport)
    {
        $this->objectSupport = $objectSupport;
    }

    /**
     * @param boolean $exceptionOnInvalidType
     */
    public function setExceptionOnInvalidType($exceptionOnInvalidType)
    {
        $this->exceptionOnInvalidType = $exceptionOnInvalidType;
    }

    /**
     * @param bool $parseCustomTags
     */
    public function setParseCustomTags($parseCustomTags)
    {
        // Yaml::PARSE_CONSTANT is only available in Symfony Yaml >= 3.2
        $this->parseCustomTags = $parseCustomTags && defined('Symfony\Component\Yaml\Yaml::PARSE_CONSTANT');
    }

    /**
     * @param bool $parseConstants
     */
    public function setParseConstants($parseConstants)
    {
        // Yaml::PARSE_CUSTOM_TAGS is only available in Symfony Yaml >= 3.3
        $this->parseConstants = $parseConstants && defined('Symfony\Component\Yaml\Yaml::PARSE_CUSTOM_TAGS');
    }
}

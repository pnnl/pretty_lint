<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 4:10 PM
 */

namespace Pnnl\PrettyJSONYAML\Linter\Yaml;


use GrumPHP\Collection\LintErrorsCollection;
use GrumPHP\Linter\Yaml\YamlLintError;
use GrumPHP\Util\Filesystem;
use Pnnl\PrettyJSONYAML\Exception\OrderException;
use Pnnl\PrettyJSONYAML\Linter\LinterInterface;
use Pnnl\PrettyJSONYAML\Parser\ParserInterface;
use Pnnl\PrettyJSONYAML\Parser\YamlParser;
use ReflectionException;
use Seld\JsonLint\ParsingException;
use SplFileInfo;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlPrettyLinter
 *
 * @package Pnnl\PrettyJSONYAML\Linter\Yaml
 */
class YamlPrettyLinter implements LinterInterface
{

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * YamlLinter constructor.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->parser = new YamlParser();
    }

    /**
     * @param SplFileInfo $file
     *
     * @return LintErrorsCollection
     */
    public function lint(SplFileInfo $file)
    {
        $errors = new LintErrorsCollection();

        try {
            $this->parser->parseFile($file);
        } catch (ParseException $exception) {
            $exception->setParsedFile($file->getPathname());
            $errors[] = YamlLintError::fromParseException($exception);
        }

        return $errors;
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
        return YamlParser::supportsFlags();
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        return class_exists(Yaml::class);
    }

    /**
     * @param boolean $objectSupport
     */
    public function setObjectSupport($objectSupport)
    {
        $this->parser->setObjectSupport($objectSupport);
    }

    /**
     * @param boolean $exceptionOnInvalidType
     */
    public function setExceptionOnInvalidType($exceptionOnInvalidType)
    {
        $this->parser->setExceptionOnInvalidType($exceptionOnInvalidType);
    }

    /**
     * @param bool $parseCustomTags
     */
    public function setParseCustomTags($parseCustomTags)
    {
        // Yaml::PARSE_CONSTANT is only available in Symfony Yaml >= 3.2
        $this->parser->setParseCustomTags($parseCustomTags);
    }

    /**
     * @param bool $parseConstants
     */
    public function setParseConstants($parseConstants)
    {
        // Yaml::PARSE_CUSTOM_TAGS is only available in Symfony Yaml >= 3.3
        $this->parser->setParseConstants($parseConstants);
    }

    /**
     * {@inheritdoc}
     */
    public static function errorFromOrderException(OrderException $e)
    {
        return YamlPrettyLintError::fromOrderException($e);
    }

    /**
     * {@inheritdoc}
     */
    public static function errorFromParseException(ParseException $e)
    {
        return YamlPrettyLintError::fromParseException($e);
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public static function errorFromParsingException(ParsingException $e)
    {
        throw new \Exception("Undefined method errorFromParsingException. JSON related error with YAML Linter.");
    }
}


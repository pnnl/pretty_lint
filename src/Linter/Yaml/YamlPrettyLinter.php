<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 4:10 PM
 */

namespace Pnnl\PrettyJSONYAML\Linter\Yaml;


use GrumPHP\Util\Filesystem;
use Pnnl\PrettyJSONYAML\Exception\OrderException;
use Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter;
use Pnnl\PrettyJSONYAML\Parser\YamlParser;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlPrettyLinter
 *
 * @package Pnnl\PrettyJSONYAML\Linter\Yaml
 */
class YamlPrettyLinter extends AbstractPrettyLinter
{

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

    /**
     * {@inheritdoc}
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct($filesystem);
        $this->parser = new YamlParser();
    }

    /**
     * {@inheritdoc}
     */
    public function isInstalled()
    {
        return class_exists(Yaml::class);
    }
}

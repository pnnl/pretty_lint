<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 4:13 PM
 */

namespace Pnnl\PrettyJSONYAML\Linter;


use GrumPHP\Linter\LinterInterface as GLinterInterface;
use Pnnl\PrettyJSONYAML\Exception\OrderException;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Interface LinterInterface
 *
 * @package Pnnl\PrettyJSONYAML\Linter
 */
interface LinterInterface extends GLinterInterface
{

    /**
     * @param OrderException $e
     *
     * @return PrettyLintErrorInterface
     */
    public static function errorFromOrderException(OrderException $e);

    /**
     * @param ParseException $e
     *
     * @return PrettyLintErrorInterface
     */
    public static function errorFromParseException(ParseException $e);

    /**
     * @param ParsingException $e
     *
     * @return PrettyLintErrorInterface
     */
    public static function errorFromParsingException(ParsingException $e);
}

<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/10/18
 * Time: 6:27 AM
 */

namespace Pnnl\PrettyJSONYAML\Linter;


use Pnnl\PrettyJSONYAML\Exception\OrderException;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Yaml\Exception\ParseException;

interface PrettyLintErrorInterface
{

    /**
     * PrettyLintErrorInterface constructor.
     *
     * @param string $type
     * @param string $error
     * @param string $file
     * @param int    $line
     * @param null   $snippet
     */
    public function __construct(
      $type,
      $error,
      $file,
      $line = -1,
      $snippet = null
    );

    /**
     * @param OrderException $e
     *
     * @return self
     */
    public static function fromOrderException(OrderException $e);

    /**
     * @param ParseException $e
     *
     * @return self
     */
    public static function fromParseException(ParseException $e);

    /**
     * @param ParsingException $e
     *
     * @return self
     */
    public static function fromParsingException(ParsingException $e);

    /**
     * @return string
     */
    public function getSnippet();

    /**
     * @return string
     */
    public function __toString();

}

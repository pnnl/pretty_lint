<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 4:10 PM
 */

namespace Pnnl\PrettyJSONYAML\Linter\Yaml;


use GrumPHP\Linter\LintError;
use GrumPHP\Linter\Yaml\YamlLintError;
use Pnnl\PrettyJSONYAML\Exception\OrderException;
use Symfony\Component\Yaml\Exception\ParseException;

class YamlPrettyLintError extends LintError
{

    /** @var string */
    private $snippet;

    /**
     * YamlPrettyLintError constructor.
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
    ) {
        parent::__construct($type, $error, $file, $line);
        $this->snippet = $snippet;
    }

    /**
     * @param OrderException $e
     *
     * @return YamlPrettyLintError
     */
    public static function fromOrderException(OrderException $e)
    {
        return new YamlPrettyLintError(
          LintError::TYPE_ERROR,
          $e->getMessage(),
          $e->getParsedFile(),
          $e->getParsedLine(),
          $e->getSnippet()
        );
    }

    /**
     * @param ParseException $e
     *
     * @return YamlLintError
     */
    public static function fromParseException(ParseException $e)
    {
        return new YamlLintError(
          LintError::TYPE_ERROR,
          $e->getMessage(),
          $e->getParsedFile(),
          $e->getParsedLine(),
          $e->getSnippet()
        );
    }

    public function getSnippet()
    {
        return $this->snippet;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('[%s] %s', strtoupper($this->getType()), $this->getError());
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/9/18
 * Time: 5:29 PM
 */

namespace Pnnl\PrettyJSONYAML\Linter\Json;


use GrumPHP\Linter\Json\JsonLintError;
use GrumPHP\Linter\LintError;
use Pnnl\PrettyJSONYAML\Exception\OrderException;
use Seld\JsonLint\ParsingException;
use SplFileInfo;

class JsonPrettyLintError extends LintError
{

    /** @var string */
    private $snippet = '';

    /**
     * YamlPrettyLintError constructor.
     *
     * @param string $type
     * @param string $error
     * @param string $file
     * @param int    $line
     * @param ''     $snippet
     */
    public function __construct(
      $type,
      $error,
      $file,
      $line = -1,
      $snippet = ''
    ) {
        parent::__construct($type, $error, $file, $line);
        $this->snippet = $snippet;
    }

    /**
     * @param OrderException $e
     *
     * @return JsonPrettyLintError
     */
    public static function fromOrderException(OrderException $e)
    {
        return new JsonPrettyLintError(
          LintError::TYPE_ERROR,
          $e->getMessage(),
          $e->getParsedFile(),
          $e->getParsedLine(),
          $e->getSnippet()
        );
    }

    /**
     * @param SplFileInfo      $file
     * @param ParsingException $exception
     *
     * @return JsonLintError
     */
    public static function fromParsingException(
      SplFileInfo $file,
      ParsingException $exception
    ) {
        return new JsonLintError(LintError::TYPE_ERROR,
          $exception->getMessage(), $file->getPathname(), 0);
    }

    /**
     * @return string
     */
    public function getSnippet()
    {
        return $this->snippet;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('[%s] %s', strtoupper($this->getType()),
          $this->getError());
    }

}

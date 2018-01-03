<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 4:09 PM
 */

namespace Pnnl\PrettyJSONYAML\Linter\Json;


use GrumPHP\Linter\LintError;
use Pnnl\PrettyJSONYAML\Exception\OrderException;
use Symfony\Component\Finder\SplFileInfo;

class JsonPrettyLintError extends LintError
{

    public static function fromOrderException(SplFileInfo $file, OrderException $exception)
    {
        return new JsonPrettyLintError(
          LintError::TYPE_ERROR,
          $exception->getMessage(),
          $exception->getParsedFile(),
          $exception->getParsedLine(),
          $exception->getSnippet()
        );
    }
}

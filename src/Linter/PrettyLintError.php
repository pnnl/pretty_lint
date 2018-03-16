<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 4:13 PM
 */

namespace Pnnl\PrettyJSONYAML\Linter;

use GrumPHP\Linter\LintError;
use Pnnl\PrettyJSONYAML\Exception\OrderException;

class PrettyLintError extends LintError
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
     * @param OrderException $exception
     *
     * @return static
     */
    public static function fromOrderException(OrderException $exception)
    {
        return new static(
            LintError::TYPE_ERROR,
            $exception->getMessage(),
            $exception->getParsedFile(),
            $exception->getParsedLine(),
            $exception->getSnippet()
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
        return sprintf(
            '[%s] %s',
            strtoupper($this->getType()),
            $this->getError()
        );
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 4:19 PM
 */

namespace Pnnl\PrettyJSONYAML\Exception;

/**
 * Class OrderException
 *
 * @package Pnnl\PrettyJSONYAML\Exception
 */
class OrderException extends \Exception
{

    /**
     * @var string $parsedFile
     */
    private $parsedFile;

    /**
     * @var int $parsedLine
     */
    private $parsedLine;

    /**
     * @var string $snippet
     */
    private $snippet;

    /**
     * @var string $rawMessage
     */
    private $rawMessage;

    /**
     * OrderException constructor.
     *
     * @param string          $message    The error message
     * @param int             $parsedLine The line where the error occurred
     * @param string|null     $snippet    The snippet of code near the problem
     * @param string|null     $parsedFile The file name where the error occurred
     * @param \Exception|null $previous   The previous exception
     */
    public function __construct(
        $message,
        $parsedLine = -1,
        $snippet = null,
        $parsedFile = null,
        \Exception $previous = null
    ) {
        $this->parsedFile = $parsedFile;
        $this->parsedLine = $parsedLine;
        $this->snippet = $snippet;
        $this->rawMessage = $message;

        $this->updateRepr();

        parent::__construct($this->message, 0, $previous);
    }

    /**
     * Gets the filename where the error occurred.
     *
     * This method returns null if a string is parsed.
     *
     * @return string The filename
     */
    public function getParsedFile()
    {
        return $this->parsedFile;
    }

    /**
     * Sets the filename where the error occurred.
     *
     * @param string $filename The filename
     */
    public function setParsedFile($filename)
    {
        $this->parsedFile = $filename;

        $this->updateRepr();
    }

    /**
     * Gests the line where the error occurred.
     *
     * @return int The file line
     */
    public function getParsedLine()
    {
        return $this->parsedLine;
    }

    /**
     * Sets  the line where the error occurred.
     *
     * @param int $lineNumber the file line
     */
    public function setParsedLine($lineNumber)
    {
        $this->parsedLine = $lineNumber;

        $this->updateRepr();
    }

    /**
     * Gets the snippet of code near the error.
     *
     * @return string The code snippet
     */
    public function getSnippet()
    {
        return $this->snippet;
    }

    /**
     * Sets the snippet of code near the error.
     *
     * @param string $snippet The code snippet
     */
    public function setSnippet($snippet)
    {
        $this->snippet = $snippet;

        $this->updateRepr();
    }

    /**
     * Update the exception's message that will be displayed to the user.
     */
    private function updateRepr()
    {
        $this->message = $this->rawMessage;

        $dot = false;
        if ('.' === substr($this->message, -1)) {
            $this->message = substr($this->message, 0, -1);
            $dot = true;
        }

        if (null !== $this->parsedFile) {
            $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
            $json = json_encode($this->parsedFile, $flags);
            $this->message .= sprintf(' in %s', $json);
        }

        if ($this->parsedLine >= 0) {
            $this->message .= sprintf(' at line %d', $this->parsedLine);
        }

        if ($this->snippet) {
            $this->message .= sprintf(' (near "%s")', $this->snippet);
        }

        if ($dot) {
            $this->message .= '.';
        }
    }
}

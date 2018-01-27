<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/9/18
 * Time: 5:35 PM
 */

namespace Pnnl\PrettyJSONYAML\Parser;


use Pnnl\PrettyJSONYAML\Exception\OrderException;
use Pnnl\PrettyJSONYAML\Linter\PrettyLintErrorInterface;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Yaml\Exception\ParseException;

interface ParserInterface
{

    /**
     * ParserInterface constructor.
     *
     * @param int $indent - the size of the indent
     */
    public function __construct($indent);

    /**
     * Parse a string into data
     *
     * @param string $data
     *
     * @return array
     *
     * @throws ParseException
     * @throws ParsingException
     */
    public function parse($data);

    /**
     * Parse the contents of a file into data
     *
     * @param string $fileName
     *
     * @return array
     *
     * @throws ParseException
     * @throws ParsingException
     */
    public function parseFile($fileName);

    /**
     * Dump data into a pretty formatted string
     *
     * @param array $data
     *
     * @return string
     */
    public function dump(array $data);

    /**
     * Dump data into a pretty formatted string and save to file
     *
     * @param array  $data
     * @param string $filename
     */
    public function dumpFile(array $data, $filename);

    /**
     * Set the number of spaces to indent
     *
     * @param int $indent
     */
    public function setIndent($indent);

}

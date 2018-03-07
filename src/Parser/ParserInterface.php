<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/9/18
 * Time: 5:35 PM
 */

namespace Pnnl\PrettyJSONYAML\Parser;

use GrumPHP\Util\Filesystem;
use Seld\JsonLint\ParsingException;
use SplFileInfo;
use Symfony\Component\Yaml\Exception\ParseException;

interface ParserInterface
{

    /**
     * ParserInterface constructor.
     *
     * @param int $indent - the size of the indent
     */
    public function __construct(Filesystem $filesystem);

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
     * @param SplFileInfo $file
     *
     * @return array
     *
     * @throws ParseException
     * @throws ParsingException
     */
    public function parseFile(SplFileInfo $file);

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
     * @param array       $data
     * @param SplFileInfo $file
     */
    public function dumpFile(array $data, SplFileInfo $file);

    /**
     * Set the number of spaces to indent
     *
     * @param int $indent
     */
    public function setIndent($indent);
}

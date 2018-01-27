<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/9/18
 * Time: 5:36 PM
 */

namespace Pnnl\PrettyJSONYAML\Parser;


class JsonParser implements ParserInterface
{

    /** @var int $indent */
    private $indent;

    /**
     * {@inheritdoc}
     */
    public function __construct($indent = 2)
    {
        $this->indent = $indent;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($data)
    {
        // TODO: Implement method
    }

    /**
     * {@inheritdoc}
     */
    public function parseFile($fileName)
    {
        $jsonData = file_get_contents($fileName);
        return $this->parse($jsonData);
    }

    /**
     * {@inheritdoc}
     */
    public function dump(array $data)
    {
        // TODO: Implement method
        // Encode JSON data
        // Set the proper indentation
    }

    /**
     * {@inheritdoc}
     */
    public function dumpFile(array $data, $filename)
    {
        $yaml = $this->dump($data);
        file_put_contents($filename, $yaml);
    }

    /**
     * {@inheritdoc}
     */
    public function setIndent($indent)
    {
        $this->indent = $indent;
    }
}

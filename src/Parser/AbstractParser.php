<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/16/18
 * Time: 7:44 AM
 */

namespace Pnnl\PrettyJSONYAML\Parser;

use GrumPHP\Util\Filesystem;
use SplFileInfo;

/**
 * Class AbstractParser
 *
 * @package Pnnl\PrettyJSONYAML\Parser
 */
abstract class AbstractParser implements ParserInterface
{

    /** @var int $indent - number of spaces to indent each level */
    protected $indent;

    /** @var Filesystem $filesystem */
    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function parse($content);

    /**
     * {@inheritdoc}
     */
    public function parseFile(SplFileInfo $file)
    {
        $content = $this->filesystem->readFromFileInfo($file);
        return $this->parse($content);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function dump(array $data);

    /**
     * {@inheritdoc}
     */
    public function dumpFile(array $data, SplFileInfo $file)
    {
        $content = $this->dump($data);
        $this->filesystem->dumpFile($file->getPathname(), $content);
    }

    /**
     * {@inheritdoc}
     */
    public function setIndent($indent)
    {
        $this->indent = $indent;
    }
}

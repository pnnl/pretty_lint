<?php

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
    abstract public function parse($content): array;

    /**
     * {@inheritdoc}
     */
    public function parseFile(SplFileInfo $file): array
    {
        $content = $this->filesystem->readFromFileInfo($file);
        return $this->parse($content);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function dump(array $data): string;

    /**
     * {@inheritdoc}
     */
    public function dumpFile(array $data, SplFileInfo $file): void
    {
        $content = $this->dump($data);
        $this->filesystem->dumpFile($file->getPathname(), $content);
    }

    /**
     * {@inheritdoc}
     */
    public function setIndent($indent): void
    {
        $this->indent = $indent;
    }
}

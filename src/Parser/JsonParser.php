<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/9/18
 * Time: 5:29 PM
 */

namespace Pnnl\PrettyJSONYAML\Parser;

use GrumPHP\Util\Filesystem;
use SplFileInfo;

class JsonParser implements ParserInterface
{
    /** @var int $indent - number of spaces to indent each level */
    private $indent;

    /** @var Filesystem $filesystem */
    private $filesystem;

    /**
     * {@inheritdoc}
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($content)
    {

    }

    public function parseFile(SplFileInfo $file)
    {
        $json = $this->filesystem->readFromFileInfo($file);
        return $this->parse($json);
    }

    public function dump(array $data)
    {

    }

    public function dumpFile(array $data, SplFileInfo $file)
    {
        $json = $this->dump($data);
        $this->filesystem->dumpFile($file->getPathname(), $json);
    }

    {
    }
}

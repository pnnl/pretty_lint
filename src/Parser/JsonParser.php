<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/9/18
 * Time: 5:29 PM
 */

namespace Pnnl\PrettyJSONYAML\Parser;

use GrumPHP\Util\Filesystem;
use Seld\JsonLint\JsonParser as SJsonParser;

class JsonParser extends AbstractParser
{

    /** @var SJsonParser */
    private $jsonParser;

    /**
     * {@inheritdoc}
     */
    public function __construct(Filesystem $filesystem, SJsonParser $jsonParser)
    {
        parent::__construct($filesystem);
        $this->jsonParser = $jsonParser;
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

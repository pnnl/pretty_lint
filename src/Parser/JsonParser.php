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
        return $this->jsonParser->parse($content, $this->calculateParseFlags());
    }

    public function dump(array $data)
    {
        $content = json_encode($data, $this->calculateDumpFlags());

        // TODO: Update content to use proper indent
        return $content;
    }

    /**
     * @return int
     */
    private function calculateDumpFlags()
    {
        return JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES;
    }

    /**
     * @return int
     */
    private function calculateParseFlags()
    {
        return SJsonParser::DETECT_KEY_CONFLICTS | SJsonParser::PARSE_TO_ASSOC;
    }
}

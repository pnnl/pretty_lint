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
use Seld\JsonLint\ParsingException;

class JsonParser extends AbstractParser
{
    /** @const string REGEX */
    private const REGEX = '/^ +/';

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
    public function parse($content): array
    {
        return $this->jsonParser->parse($content, $this->calculateParseFlags());
    }

    /**
     * {@inheritdoc}
     * @throws ParsingException
     */
    public function dump(array $data): string
    {
        // Convert indentation
        $content = json_encode($data, $this->calculateDumpFlags());
        $split = explode("\n", $content);

        foreach ($split as &$line) {
            $matches = [];
            $result = preg_match(self::REGEX, $line, $matches);
            if (!empty($result)) {
                // Calculate proper indentation
                $count = (int) ((strlen($matches[0]) / 4) * $this->indent);
                $replace = str_repeat(' ', $count);
                // Replace indentation
                $line = preg_replace(self::REGEX, $replace, $line);

                // Throw exception if error detected in preg_replace
                if (null === $line) {
                    throw new ParsingException('Error occurred setting the proper indent on JSON data.');
                }
            }
        }
        unset($line);

        // Recombine lines into single properly indented JSON string
        $content = implode("\n", $split);
        return $content;
    }

    /**
     * @return int
     */
    private function calculateDumpFlags(): int
    {
        return JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES;
    }

    /**
     * @return int
     */
    private function calculateParseFlags(): int
    {
        return SJsonParser::DETECT_KEY_CONFLICTS | SJsonParser::PARSE_TO_ASSOC;
    }
}

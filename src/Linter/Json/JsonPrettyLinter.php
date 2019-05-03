<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/9/18
 * Time: 5:29 PM
 */

namespace Pnnl\PrettyJSONYAML\Linter\Json;

use Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter;
use Pnnl\PrettyJSONYAML\Parser\JsonParser;
use Seld\JsonLint\JsonParser as SJsonParser;

class JsonPrettyLinter extends AbstractPrettyLinter
{

    /** @var JsonParser */
    protected $parser;

    /** @var bool */
    private $detectKeyConflicts = false;

    /**
     * @param int $indent
     */
    public function setIndent($indent): void
    {
        $this->parser->setIndent($indent);
    }

    /**
     * @return bool
     */
    public function isInstalled(): bool
    {
        return class_exists(SJsonParser::class);
    }

    /**
     * @param boolean $detectKeyConflicts
     */
    public function setDetectKeyConflicts($detectKeyConflicts): void
    {
        $this->detectKeyConflicts = $detectKeyConflicts;
    }
}

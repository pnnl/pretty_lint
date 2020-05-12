<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/22/18
 * Time: 10:52 AM
 */

namespace Pnnl\Tests\Linter;

use GrumPHP\Util\Filesystem;
use Pnnl\PrettyJSONYAML\Linter\Json\JsonPrettyLinter;
use Pnnl\PrettyJSONYAML\Parser\JsonParser;
use Seld\JsonLint\JsonParser as SJsonParser;

class JsonLinterTest extends AbstractLinterTest
{

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $filesystem = new Filesystem();
        $parser = new SJsonParser();
        $this->parser = new JsonParser($filesystem, $parser);
        $this->linter = new JsonPrettyLinter($this->parser);
        $this->type = self::JSON;

        parent::setUp();
    }

    /**
     * {@inheritdoc}
     */
    public function dataForCheckIndentation()
    {
        return [
            ['indentValid.json', 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function dataForSortOrder()
    {
        return [
            ['sortValid.json', 0],
            ['sortInvalid.json', 1],
            ['sortTopValid.json', 0, 'topKeys.yml'],
            ['sortTopInvalid.json', 1, 'topKeys.yml'],
        ];
    }
}

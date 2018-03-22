<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/22/18
 * Time: 10:52 AM
 */

namespace Pnnl\Tests\Linter;

use GrumPHP\Util\Filesystem;
use Pnnl\PrettyJSONYAML\Linter\Yaml\YamlPrettyLinter;
use Pnnl\PrettyJSONYAML\Parser\YamlParser;

class YamlLinterTest extends AbstractLinterTest
{

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->parser = new YamlParser(new Filesystem());
        $this->linter = new YamlPrettyLinter($this->parser);
        $this->type = self::YAML;

        parent::setUp();
    }

    /**
     * {@inheritdoc}
     */
    public function dataForCheckIndentation()
    {
        return [
            ['indentValid.yml', 0],
            ['indentInvalid.yml', 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function dataForSortOrder()
    {
        return [
            ['sortValid.yml', 0],
            ['sortInvalid.yml', 1],
            ['sortTopValid.yml', 0, 'topKeys.yml'],
            ['sortTopInvalid.yml', 1, 'topKeys.yml'],
        ];
    }
}

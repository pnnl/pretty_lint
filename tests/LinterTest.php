<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/22/18
 * Time: 7:45 AM
 */

namespace Pnnl\Tests;

use GrumPHP\Collection\LintErrorsCollection;
use GrumPHP\Util\Filesystem;
use PHPUnit\Framework\TestCase;
use Pnnl\PrettyJSONYAML\Linter\PrettyLintError;
use Pnnl\PrettyJSONYAML\Linter\Yaml\YamlPrettyLinter;
use Pnnl\PrettyJSONYAML\Parser\YamlParser;
use RuntimeException;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;

class LinterTest extends TestCase
{

    /** @var YamlPrettyLinter $linter */
    protected $linter;

    /**
     * Test setup method
     */
    protected function setUp()
    {
        $this->linter = new YamlPrettyLinter(
            new YamlParser(
                new Filesystem()
            )
        );

        $config = [
            'auto_fix' => false,
            'indent' => 2,
            'top_keys' => [],
        ];

        $this->updateConfig($config);
    }

    /**
     * Imports test config file
     *
     * @param string $config
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    private function importConfig($config)
    {
        $file = new SplFileInfo(__DIR__ . "/config/" . $config);
        if (!$file->isReadable()) {
            throw new RuntimeException(
                sprintf("The config %s could not be loaded!", $config)
            );
        }

        $filesystem = new Filesystem();
        $configData = Yaml::parseFile($file->getPathname());
        $this->updateConfig($configData);
    }

    /**
     * Updates linter with proper configuration
     *
     * @param array $config
     */
    private function updateConfig(array $config)
    {
        if (isset($config['auto_fix'])) {
            $this->linter->setAutoFix($config['auto_fix']);
        }
        if (isset($config['indent'])) {
            $this->linter->setIndent($config['indent']);
        }
        if (isset($config['top_keys'])) {
            $this->linter->setTopKeys($config['top_keys']);
        }
    }

    /**
     * @param string $fixture
     *
     * @return SplFileInfo
     */
    private function getFixture($fixture)
    {
        $file = new SplFileInfo(__DIR__ . "/fixtures/yaml/" . $fixture);
        if (!$file->isReadable()) {
            throw new RuntimeException(
                sprintf("The fixture %s could not be loaded!", $fixture)
            );
        }

        return $file;
    }

    /**
     * @param string $fixture
     * @param int    $errors
     */
    private function validateFixture($fixture, $errors)
    {
        $result = $this->linter->lint($this->getFixture($fixture));
        $this->assertInstanceOf(LintErrorsCollection::class, $result);
        $this->assertEquals(
            $errors,
            $result->count(),
            "Invalid error-count expected."
        );
        if ($result->count()) {
            foreach ($result as $error) {
                $this->assertInstanceOf(PrettyLintError::class, $error);
            }
        }
    }

    /**
     * @test
     *
     * @param string $fixture
     * @param int    $errors
     *
     * @dataProvider dataForCheckIndentation
     */
    public function testCheckIndentation($fixture, $errors)
    {
        $this->validateFixture($fixture, $errors);
    }

    /**
     * @return array
     */
    public function dataForCheckIndentation()
    {
        return [
            ['indentValid.yml', 0],
            ['indentInvalid.yml', 1],
        ];
    }

    /**
     * @test
     *
     * @param string $fixture
     * @param int    $errors
     * @param string $config
     *
     * @dataProvider dataForSortOrder
     */
    public function testSortOrder($fixture, $errors, $config = '')
    {
        if (!empty($config)) {
            $this->importConfig($config);
        }
        $this->validateFixture($fixture, $errors);
    }

    /**
     * @return array
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

    public function testAutoFix()
    {
    }
}

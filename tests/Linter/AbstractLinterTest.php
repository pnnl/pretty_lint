<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/22/18
 * Time: 7:45 AM
 */

namespace Pnnl\Tests\Linter;

use GrumPHP\Collection\LintErrorsCollection;
use PHPUnit\Framework\TestCase;
use Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter;
use Pnnl\PrettyJSONYAML\Linter\PrettyLintError;
use Pnnl\PrettyJSONYAML\Parser\ParserInterface;
use RuntimeException;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractLinterTest extends TestCase
{

    /** @const string */
    const JSON = 'json';

    /** @const string */
    const YAML = 'yaml';

    /** @var AbstractPrettyLinter $linter */
    protected $linter;

    /** @var ParserInterface */
    protected $parser;

    /** @var string $type */
    protected $type;

    /**
     * Test setup method
     */
    protected function setUp(): void
    {
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
        $file = new SplFileInfo(__DIR__ . "/../config/" . $config);
        if (!$file->isReadable()) {
            throw new RuntimeException(
                sprintf("The config %s could not be loaded!", $config)
            );
        }

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
        $path = __DIR__ . "/../fixtures/" . $this->type . "/" . $fixture;
        $file = new SplFileInfo($path);
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
    abstract public function dataForCheckIndentation();

    /**
     * @test
     *
     * @param string $fixture
     * @param int    $errors
     * @param string $config
     *
     * @dataProvider dataForSortOrder
     *
     * @covers       \Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter::__construct()
     * @covers       \Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter::lint()
     * @covers       \Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter::setAutoFix()
     * @covers       \Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter::setIndent()
     * @covers       \Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter::setTopKeys()
     * @covers       \Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter::sort()
     * @covers       \Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter::sortByTopKeys()
     * @covers       \Pnnl\PrettyJSONYAML\Linter\AbstractPrettyLinter::getCurrentFileKeys()
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
    abstract public function dataForSortOrder();

    // abstract public function testAutoFix();
}

<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 11:42 AM
 */

namespace Pnnl\PrettyJSONYAML\Task;


use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\YamlLint;
use RuntimeException;

/**
 * Class PrettyYaml
 *
 * @property \Pnnl\PrettyJsonYaml\Linter\Yaml\YamlPrettyLinter $linter
 *
 * @package Pnnl\PrettyJSONYAML\Task
 */
class PrettyYaml extends YamlLint
{

    /**
     * @return string
     */
    public function getName()
    {
        return 'prettyyaml';
    }

    public function getConfigurableOptions()
    {
        $options = parent::getConfigurableOptions();
        $options->setDefaults([
          'auto_fix' => true,
          'indent' => 2,
        ]);

        $options->addAllowedTypes('auto_fix', ['bool']);
        $options->addAllowedTypes('indent', ['int']);

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function run(ContextInterface $context)
    {
        $files = $context->getFiles()->name('/\.(yaml|yml)$/i');
        if (0 === count($files)) {
            return TaskResult::createSkipped($this, $context);
        }

        $config = $this->getConfiguration();
        $this->linter->setAutoFix($config['auto_fix']);
        $this->linter->setIndent($config['indent']);
        $this->linter->setObjectSupport($config['object_support']);
        $this->linter->setParseConstants($config['parse_constant']);
        $this->linter->setParseCustomTags($config['parse_custom_tags']);
        $this->linter->setExceptionOnInvalidType($config['exception_on_invalid_type']);

        try {
            $lintErrors = $this->lint($files);
        } catch (RuntimeException $e) {
            return TaskResult::createFailed($this, $context, $e->getMessage());
        }

        if ($lintErrors->count()) {
            return TaskResult::createFailed($this, $context,
              (string)$lintErrors);
        }

        return TaskResult::createPassed($this, $context);
    }
}

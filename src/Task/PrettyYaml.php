<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 11:42 AM
 */

namespace Pnnl\PrettyJSONYAML\Task;

use GrumPHP\Runner\TaskResultInterface;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\YamlLint;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
    public function getName(): string
    {
        return 'prettyyaml';
    }

    /**
     * {@inheritdoc}
     */
    public static function getConfigurableOptions(): OptionsResolver
    {
        $options = parent::getConfigurableOptions();
        $options->setDefaults(
            [
                'auto_fix' => true,
                'indent' => 2,
                'top_keys' => [],
            ]
        );

        $options->addAllowedTypes('auto_fix', ['bool']);
        $options->addAllowedTypes('indent', ['int']);
        $options->addAllowedTypes('top_keys', ['array']);

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function run(ContextInterface $context): TaskResultInterface
    {
        // Set custom config
        $config = $this->getConfig()->getOptions();
        $this->linter->setAutoFix($config['auto_fix']);
        $this->linter->setIndent($config['indent']);
        $this->linter->setTopKeys($config['top_keys']);

        // Run the task
        return parent::run($context);
    }
}

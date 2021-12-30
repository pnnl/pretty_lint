<?php

/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/9/18
 * Time: 5:28 PM
 */

namespace Pnnl\PrettyJSONYAML\Task;

use GrumPHP\Runner\TaskResultInterface;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\JsonLint;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PrettyJson
 *
 * @property \Pnnl\PrettyJSONYAML\Linter\Json\JsonPrettyLinter $linter
 *
 * @package Pnnl\PrettyJSONYAML\Task
 */
class PrettyJson extends JsonLint
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'prettyjson';
    }

    /**
     * Get the available options for the plugin.
     *
     * @return \Symfony\Component\OptionsResolver\OptionsResolver
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

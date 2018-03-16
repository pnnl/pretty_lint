<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 3/9/18
 * Time: 5:28 PM
 */

namespace Pnnl\PrettyJSONYAML\Task;

use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\JsonLint;

/**
 * Class PrettyJson
 *
 * @property \Pnnl\PrettyJSONYAML\Linter\Json\JsonPrettyLinter $linter
 *
 * @package Pnnl\PrettyJSONYAML\Task
 */
class PrettyJson extends JsonLint
{
    // TODO: Join this and the PrettyYaml tasks into an abstract class except for get Name method
    /**
     * @return string
     */
    public function getName()
    {
        return "prettyjson";
    }

    public function getConfigurableOptions()
    {
        $options = parent::getConfigurableOptions();
        $options->setDefaults([
          'auto_fix' => true,
          'indent' => 2,
          'top_keys' => [],
        ]);

        $options->addAllowedTypes('auto_fix', ['bool']);
        $options->addAllowedTypes('indent', ['int']);
        $options->addAllowedTypes('top_keys', ['string[]']);

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function run(ContextInterface $context)
    {
        // Set custom config
        $config = $this->getConfiguration();
        $this->linter->setAutoFix($config['auto_fix']);
        $this->linter->setIndent($config['indent']);
        $this->linter->setTopKeys($config['top_keys']);

        // Run the task
        return parent::run($context);
    }
}

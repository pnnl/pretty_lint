<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 11:39 AM
 */

namespace Pnnl\PrettyJSONYAML\Extension;


use GrumPHP\Extension\ExtensionInterface;
use Pnnl\PrettyJSONYAML\Linter\Json\JsonPrettyLinter;
use Pnnl\PrettyJSONYAML\Linter\Yaml\YamlPrettyLinter;
use Pnnl\PrettyJSONYAML\Parser\JsonParser;
use Pnnl\PrettyJSONYAML\Parser\YamlParser;
use Pnnl\PrettyJSONYAML\Task\PrettyJson;
use Pnnl\PrettyJSONYAML\Task\PrettyYaml;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Loader implements ExtensionInterface
{

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(ContainerBuilder $container)
    {
        // Create appropriate dependency injection
        // Create the YAML parser
        $container->register("parser.yamlparser", YamlParser::class)
          ->addArgument($container->get('grumphp.util.filesystem'));

        // Create the YAML Linter
        $container->register("linter.yamlprettylinter", YamlPrettyLinter::class)
          ->addArgument($container->get("parser.yamlParser"));

        // Create the YAML task
        $container->register('task.prettyyaml', PrettyYaml::class)
          ->addArgument($container->get('config'))
          ->addArgument($container->get("linter.yamlprettylinter"))
          ->addTag('grumphp.task', ['config' => 'prettyyaml']);


        // Create the JSON Parser
        $container->register("parser.jsonparser", JsonParser::class)
          ->addArgument($container->get('grumphp.util.filesystem'));

        // Create the JSON Linter
        $container->register("linter.jsonprettylinter", JsonPrettyLinter::class)
          ->addArgument($container->get("parser.jsonParser"));

        // Create the JSON Task
        $container->register("task.prettyjson", PrettyJson::class)
          ->addArgument($container->get("config"))
          ->addArgument($container->get("linter.jsonprettylinter"))
          ->addTag("grumphp.task", ['config' => 'prettyjson']);
    }
}

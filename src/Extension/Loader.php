<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 11:39 AM
 */

namespace Pnnl\PrettyJSONYAML\Extension;


use GrumPHP\Extension\ExtensionInterface;
use Pnnl\PrettyJSONYAML\Task\PrettyJson;
use Pnnl\PrettyJSONYAML\Task\PrettyJsonFixer;
use Pnnl\PrettyJSONYAML\Task\PrettyYaml;
use Pnnl\PrettyJSONYAML\Task\PrettyYamlFixer;
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
        $container->register('task.pretty_json', PrettyJson::class)
          ->addArgument($container->get('config'))
          ->addArgument($container->get('process_builder'))
          ->addArgument($container->get('formatter.prettyjson'))
          ->addTag('grumphp.task', ['config' => 'pretty_json']);

        // $container->register('task.pretty_yaml', PrettyYaml::class)
        //   ->addArgument($container->get('config'))
        //   ->addArgument($container->get('process_builder'))
        //   ->addArgument($container->get('formatter.prettyyaml'))
        //   ->addTag('grumphp.task', ['config' => 'pretty_yaml']);
        //
        // $container->register('task.pretty_json_fixer', PrettyJsonFixer::class)
        //   ->addArgument($container->get('config'))
        //   ->addArgument($container->get('process_builder'))
        //   ->addArgument($container->get('formatter.prettyjson'))
        //   ->addTag('grumphp.task', ['config' => 'pretty_json_fixer']);
        //
        // $container->register('task.pretty_yaml_fixer', PrettyYamlFixer::class)
        //   ->addArgument($container->get('config'))
        //   ->addArgument($container->get('process_builder'))
        //   ->addArgument($container->get('formatter.prettyyaml'))
        //   ->addTag('grumphp.task', ['config' => 'pretty_yaml_fixer']);
    }
}

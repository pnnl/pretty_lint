<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 11:39 AM
 */

namespace Pnnl\PrettyJSONYAML\Extension;

use GrumPHP\Extension\ExtensionInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Loader implements ExtensionInterface
{

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(ContainerBuilder $container): void
    {
        $location = __DIR__ . '/../../resources/config';
        $locator = new FileLocator($location);
        $loader = new YamlFileLoader($container, $locator);
        $loader->load('parsers.yml');
        $loader->load('linters.yml');
        $loader->load('tasks.yml');
    }
}

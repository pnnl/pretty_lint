<?php
/**
 * Created by PhpStorm.
 * User: will202
 * Date: 1/2/18
 * Time: 11:41 AM
 */

namespace Pnnl\PrettyJSONYAML\Task;


use GrumPHP\Configuration\GrumPHP;
use GrumPHP\Process\AsyncProcessRunner;
use GrumPHP\Process\ProcessBuilder;
use GrumPHP\Runner\TaskResult;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;
use GrumPHP\Task\TaskInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrettyJson implements TaskInterface
{

    /** @var GrumPHP $grumphp */
    protected $grumphp;

    /** @var ProcessBuilder $processBuilder */
    protected $processBuilder;

    /** @var AsyncProcessRunner $processRunner */
    protected $processRunner;

    public function __construct(
      GrumPHP $grumphp,
      ProcessBuilder $processBuilder,
      AsyncProcessRunner $processRunner
    ) {
        $this->grumphp = $grumphp;
        $this->processBuilder = $processBuilder;
        $this->processRunner = $processRunner;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return "pretty_json";
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        $configured = $this->grumphp->getTaskConfiguration($this->getName());

        return $this->getConfigurableOptions()->resolve($configured);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigurableOptions()
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
          'indentSize' => 2,
          'indentCharacter' => '  ',
          'indentSpaces' => true,
          'sort' => true,
        ]);

        $resolver->addAllowedTypes('indentSize', ['null', 'int']);
        $resolver->addAllowedTypes('indentCharacter', ['null', 'string']);
        $resolver->addAllowedTypes('indentSpaces', ['bool']);
        $resolver->addAllowedTypes('sort', ['bool']);

        return $resolver;
    }

    /**
     * {@inheritdoc}
     */
    public function canRunInContext(ContextInterface $context)
    {
        return ($context instanceof GitPreCommitContext || $context instanceof RunContext);
    }

    /**
     * {@inheritdoc}
     */
    public function run(ContextInterface $context)
    {
        print "hello, World!";

        $config = $this->getConfiguration();
        $files = $context->getFiles()->name("*.json");

        if (0 === count($files)) {
            return TaskResult::createSkipped($this, $context);
        }



        return TaskResult::createPassed($this, $context);
    }
}

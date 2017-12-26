<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\ConfigVault;

use SetBased\Abc\Abc;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Shows the value stored under a key in a domain.
 */
class ShowCommand extends Command
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function configure()
  {
    $this->setName('config-vault:show')
         ->setDescription('shows the configuration')
         ->addArgument('domain', InputArgument::REQUIRED, 'The name of the domain')
         ->addArgument('key', InputArgument::OPTIONAL, 'The key')
         ->addOption('var-dump', null, InputOption::VALUE_NONE, 'Use var_dump for showing the value');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $vault = Abc::$abc->getConfigVault();

    $value = $vault->getValue($input->getArgument('domain'), $input->getArgument('key'));
    if ($input->getOption('var-dump'))
    {
      var_dump($value);
    }
    else
    {
      $output->writeln(print_r($value, true));
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------

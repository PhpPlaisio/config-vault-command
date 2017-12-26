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
 * Sets the value stored under a key in a domain.
 */
class SetCommand extends Command
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function configure()
  {
    $this->setName('config-vault:set')
         ->setDescription('sets the value stored under a key in a domain.')
         ->addArgument('domain', InputArgument::REQUIRED, 'The name of the domain')
         ->addArgument('key', InputArgument::REQUIRED, 'The key')
         ->addArgument('value', InputArgument::OPTIONAL, 'The value')
         ->addOption('json', null, InputOption::VALUE_NONE, 'The value is given as a JSON encoded string');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $vault = Abc::$abc->getConfigVault();

    $value =$input->getArgument('value');
    if ($input->getOption('json'))
    {
      $value = \json_decode($input->getArgument('value'), true);
    }

    $vault->putValue($input->getArgument('domain'), $input->getArgument(('key')), $value);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------

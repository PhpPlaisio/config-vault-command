<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\ConfigVault;

use SetBased\Abc\Abc;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Unsets the value stored under a key in a domain.
 */
class UnsetCommand extends Command
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function configure()
  {
    $this->setName('config-vault:unset')
         ->setDescription('Unsets the value stored under a key in a domain')
         ->addArgument('domain', InputArgument::REQUIRED, 'The name of the domain')
         ->addArgument('key', InputArgument::OPTIONAL, 'The key');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $vault = Abc::$abc->getConfigVault();

    $vault->unset($input->getArgument('domain'), $input->getArgument(('key')));
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------

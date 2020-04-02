<?php
declare(strict_types=1);

namespace Plaisio\ConfigVault;

use Plaisio\Kernel\Nub;
use SetBased\Exception\RuntimeException;
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
    $vault  = Nub::$nub->getConfigVault();
    $key    = $input->getArgument('key');
    $domain = $input->getArgument('domain');

    $values = $vault->getDomain($domain);
    if ($key===null)
    {
      $value = $values;
    }
    else
    {
      if (!array_key_exists($key, $values))
      {
        throw new RuntimeException("Key '%s' does not exists in domain '%s'", $key, $domain);
      }

      $value = $values[$key];
    }

    if ($input->getOption('var-dump'))
    {
      var_dump($value);
    }
    else
    {
      $output->writeln(print_r($value, true));
    }

    return 0;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------

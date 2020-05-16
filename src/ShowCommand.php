<?php
declare(strict_types=1);

namespace Plaisio\ConfigVault;

use Plaisio\Kernel\Nub;
use SetBased\Exception\RuntimeException;
use SetBased\Helper\Cast;
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
         ->addOption('var-export', null, InputOption::VALUE_NONE, 'Use var_export for showing the value');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $key    = Cast::toOptString($input->getArgument('key'));
    $domain = Cast::toManString($input->getArgument('domain'));

    $values = Nub::$nub->configVault->getDomain($domain);
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

    if ($input->getOption('var-export'))
    {
      var_export($value);
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

<?php
declare(strict_types=1);

namespace Plaisio\ConfigVault;

use Plaisio\Kernel\Nub;
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
         ->addArgument('type', InputArgument::REQUIRED, 'The type of the value (bool, float, int, or string)')
         ->addArgument('value', InputArgument::OPTIONAL, 'The value')
         ->addOption('json', null, InputOption::VALUE_NONE, 'The value is given as a JSON encoded string');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $value  = $input->getArgument('value');
    $type   = $input->getArgument('type');
    $domain = $input->getArgument('domain');
    $key    = $input->getArgument('key');

    if ($input->getOption('json'))
    {
      $value = \json_decode($value, true);
    }

    switch ($type)
    {
      case 'bool':
        Nub::$nub->configVault->putBool($domain, $key, $value);
        break;

      case 'float':
        Nub::$nub->configVault->putFloat($domain, $key, $value);
        break;

      case 'int':
        Nub::$nub->configVault->putInt($domain, $key, $value);
        break;

      case 'string':
        Nub::$nub->configVault->putString($domain, $key, $value);
        break;

      default:
        $output->writeln(sprintf("Unknown type '%s'", $type));

        return -1;
    }

    return 0;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------

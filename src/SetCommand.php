<?php
declare(strict_types=1);

namespace Plaisio\ConfigVault;

use Plaisio\Console\Command\PlaisioKernelCommand;
use SetBased\Helper\Cast;
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
  use PlaisioKernelCommand;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * {@inheritdoc}
   */
  protected function configure()
  {
    $this->setName('config-vault:set')
         ->setDescription('Sets the value stored under a key in a domain.')
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
    $domain = Cast::toManString($input->getArgument('domain'));
    $key    = Cast::toManString($input->getArgument('key'));
    $type   = Cast::toManString($input->getArgument('type'));
    $value  = $input->getArgument('value');

    if ($input->getOption('json'))
    {
      $value = \json_decode(Cast::toManString($value), true);
    }

    switch ($type)
    {
      case 'bool':
        $this->nub->configVault->putBool($domain, $key, Cast::toOptBool($value));
        break;

      case 'float':
        $this->nub->configVault->putFloat($domain, $key, Cast::toOptFiniteFloat($value));
        break;

      case 'int':
        $this->nub->configVault->putInt($domain, $key, Cast::toOptInt($value));
        break;

      case 'string':
        $this->nub->configVault->putString($domain, $key, Cast::toOptString($value));
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

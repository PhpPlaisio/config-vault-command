<?php
declare(strict_types=1);

namespace Plaisio\ConfigVault;

use Plaisio\Kernel\Nub;
use SetBased\Helper\Cast;
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
    $domain = Cast::toManString($input->getArgument('domain'));
    $key    = Cast::toOptString($input->getArgument('key'));

    if ($key===null)
    {
      Nub::$nub->configVault->unsetDomain($domain);
    }
    else
    {
      Nub::$nub->configVault->unsetKey($domain, $key);
    }

    return 0;
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------

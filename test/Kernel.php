<?php
declare(strict_types=1);

namespace Plaisio\ConfigVault\Test;

use Plaisio\PlaisioKernel;

/**
 * Kernel for testing purposes.
 */
class Kernel extends PlaisioKernel
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns an instance of this kernel.
   *
   * @return static
   */
  public static function create(): static
  {
    return new self();
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------

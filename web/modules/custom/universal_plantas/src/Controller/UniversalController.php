<?php

namespace Drupal\universal_plantas\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class UniversalController.
 */
class UniversalController extends ControllerBase {

  /**
   * Universal.
   *
   * @return string
   *   Return Hello string.
   */
  public function universal() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: universal')
    ];
  }

}

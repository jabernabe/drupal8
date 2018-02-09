<?php

namespace Drupal\hm\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function hello($name) {

      $message = $this->t('Hello <strong>%name</strong>',[
          '%name' =>$name
          ]);

    return ['#markup' => $message];

  }

}

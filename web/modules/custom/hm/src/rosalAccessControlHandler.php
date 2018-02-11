<?php

namespace Drupal\hm;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Rosal entity.
 *
 * @see \Drupal\hm\Entity\rosal.
 */
class rosalAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\hm\Entity\rosalInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished rosal entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published rosal entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit rosal entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete rosal entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add rosal entities');
  }

}

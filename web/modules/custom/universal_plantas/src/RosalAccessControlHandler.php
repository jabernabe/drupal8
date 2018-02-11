<?php

namespace Drupal\universal_plantas;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Rosal entity.
 *
 * @see \Drupal\universal_plantas\Entity\Rosal.
 */
class RosalAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\universal_plantas\Entity\RosalInterface $entity */
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

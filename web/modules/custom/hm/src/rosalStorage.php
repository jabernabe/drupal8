<?php

namespace Drupal\hm;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\hm\Entity\rosalInterface;

/**
 * Defines the storage handler class for Rosal entities.
 *
 * This extends the base storage class, adding required special handling for
 * Rosal entities.
 *
 * @ingroup hm
 */
class rosalStorage extends SqlContentEntityStorage implements rosalStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(rosalInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {rosal_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {rosal_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(rosalInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {rosal_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('rosal_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}

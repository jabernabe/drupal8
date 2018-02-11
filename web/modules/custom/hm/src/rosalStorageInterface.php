<?php

namespace Drupal\hm;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface rosalStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Rosal revision IDs for a specific Rosal.
   *
   * @param \Drupal\hm\Entity\rosalInterface $entity
   *   The Rosal entity.
   *
   * @return int[]
   *   Rosal revision IDs (in ascending order).
   */
  public function revisionIds(rosalInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Rosal author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Rosal revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\hm\Entity\rosalInterface $entity
   *   The Rosal entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(rosalInterface $entity);

  /**
   * Unsets the language for all Rosal with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}

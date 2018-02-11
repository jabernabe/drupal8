<?php

namespace Drupal\hm\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Rosal entities.
 *
 * @ingroup hm
 */
interface rosalInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Rosal name.
   *
   * @return string
   *   Name of the Rosal.
   */
  public function getName();

  /**
   * Sets the Rosal name.
   *
   * @param string $name
   *   The Rosal name.
   *
   * @return \Drupal\hm\Entity\rosalInterface
   *   The called Rosal entity.
   */
  public function setName($name);

  /**
   * Gets the Rosal creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Rosal.
   */
  public function getCreatedTime();

  /**
   * Sets the Rosal creation timestamp.
   *
   * @param int $timestamp
   *   The Rosal creation timestamp.
   *
   * @return \Drupal\hm\Entity\rosalInterface
   *   The called Rosal entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Rosal published status indicator.
   *
   * Unpublished Rosal are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Rosal is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Rosal.
   *
   * @param bool $published
   *   TRUE to set this Rosal to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\hm\Entity\rosalInterface
   *   The called Rosal entity.
   */
  public function setPublished($published);

  /**
   * Gets the Rosal revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Rosal revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\hm\Entity\rosalInterface
   *   The called Rosal entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Rosal revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Rosal revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\hm\Entity\rosalInterface
   *   The called Rosal entity.
   */
  public function setRevisionUserId($uid);

}

<?php

namespace Drupal\hm\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\hm\Entity\rosalInterface;

/**
 * Class rosalController.
 *
 *  Returns responses for Rosal routes.
 */
class rosalController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Rosal  revision.
   *
   * @param int $rosal_revision
   *   The Rosal  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($rosal_revision) {
    $rosal = $this->entityManager()->getStorage('rosal')->loadRevision($rosal_revision);
    $view_builder = $this->entityManager()->getViewBuilder('rosal');

    return $view_builder->view($rosal);
  }

  /**
   * Page title callback for a Rosal  revision.
   *
   * @param int $rosal_revision
   *   The Rosal  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($rosal_revision) {
    $rosal = $this->entityManager()->getStorage('rosal')->loadRevision($rosal_revision);
    return $this->t('Revision of %title from %date', ['%title' => $rosal->label(), '%date' => format_date($rosal->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Rosal .
   *
   * @param \Drupal\hm\Entity\rosalInterface $rosal
   *   A Rosal  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(rosalInterface $rosal) {
    $account = $this->currentUser();
    $langcode = $rosal->language()->getId();
    $langname = $rosal->language()->getName();
    $languages = $rosal->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $rosal_storage = $this->entityManager()->getStorage('rosal');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $rosal->label()]) : $this->t('Revisions for %title', ['%title' => $rosal->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all rosal revisions") || $account->hasPermission('administer rosal entities')));
    $delete_permission = (($account->hasPermission("delete all rosal revisions") || $account->hasPermission('administer rosal entities')));

    $rows = [];

    $vids = $rosal_storage->revisionIds($rosal);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\hm\rosalInterface $revision */
      $revision = $rosal_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $rosal->getRevisionId()) {
          $link = $this->l($date, new Url('entity.rosal.revision', ['rosal' => $rosal->id(), 'rosal_revision' => $vid]));
        }
        else {
          $link = $rosal->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.rosal.translation_revert', ['rosal' => $rosal->id(), 'rosal_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.rosal.revision_revert', ['rosal' => $rosal->id(), 'rosal_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.rosal.revision_delete', ['rosal' => $rosal->id(), 'rosal_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['rosal_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}

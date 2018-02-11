<?php

/**
 * @file
 * Contains rosal.page.inc.
 *
 * Page callback for Rosal entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Rosal templates.
 *
 * Default template: rosal.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_rosal(array &$variables) {
  // Fetch rosal Entity Object.
  $rosal = $variables['elements']['#rosal'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

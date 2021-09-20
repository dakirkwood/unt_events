<?php

namespace Drupal\unt_events\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'UntEventsBlock' block.
 *
 * @Block(
 *  id = "unt_events_block",
 *  admin_label = @Translation("UNT Events block"),
 *  context_definitions = {
 *    "node" = @ContextDefinition ("entity:node", label = @Translation ("Node"), required = FALSE,)
 *   }
 * )
 */
class UntEventsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\unt_events\UntEventsClient
   */
  protected $untEventsClient;

  /**
   * UntEvents constructor
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param $unt_events_client \Drupal\unt_events\UntEventsClient
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, \Drupal\unt_events\UntEventsClient $unt_events_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->untEventsClient = $unt_events_client;
  }

  /**
   * {@inheritdoc }
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('unt_events_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $node = $this->getContextValue('node');
    if($node){
      $dept = $node->get('field_department')->getValue();
      $deptId = $dept[0]['target_id'];
      $dept_events = $this->untEventsClient->filterList($deptId);

      $build = [
        '#theme' => 'unt_events_block',
        '#content' => $dept_events,
      ];

      return $build;
    }
  }
}

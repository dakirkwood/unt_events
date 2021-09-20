<?php

namespace Drupal\unt_events\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\unt_events\UntEventsClient;
use Drupal\user\Plugin\views\filter\Name;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CampusEventsController.
 */
class CampusEventsController extends ControllerBase {

  private $untEventsClient;

  public function __construct(UntEventsClient $untEventsClient){

    $this->untEventsClient = $untEventsClient;
  }

  public static function create(ContainerInterface $container) {
    $untEventsClient = $container->get('unt_events_client');

    return new static($untEventsClient);
  }

  /**
   * Show the details of a single event.
   *
   * @return Response
   *
   */
  public function showEvent($eventId) {
    $api_response = $this->untEventsClient->getEvent($eventId);
    $image = $api_response[0]['eventImage'] != '' ? $api_response[0]['eventImage'] : NULL;
    return [
      '#theme' => 'unt_events_event_detail',
      '#name' => 'Event Detail',
      '#type' => 'markup',
      '#title' => $api_response[0]['eventTitle'],
      '#date' =>  ['#markup' => $api_response[0]['eventDate']],
      '#location' => ['#markup' => $api_response[0]['eventLocation']],
      '#contact_name' => ['#markup' => $api_response[0]['eventContact']],
      '#contact_phone' => ['#markup' => $api_response[0]['eventContactPhone']],
      '#contact_email' => ['#markup' => $api_response[0]['eventContactMail']],
      '#department' => ['#markup' => $api_response[0]['eventDept']],
      '#details' => ['#markup' => $api_response[0]['eventDetails']],
      '#image' => $image,
    ];
  }
}

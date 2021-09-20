<?php

namespace Drupal\unt_events;

use Drupal\Component\Serialization\Json;

class UntEventsClient {
  /**
   * @var \GuzzleHttp\Client
   */

  protected $client;

  /**
   * UntEventsClient constructor
   * @param $http_client_factory \Drupal\Core\Http\ClientFactory
   */

  public function __construct(\Drupal\Core\Http\ClientFactory $http_client_factory){
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => 'http://events.d9.loc'
    ]);
  }

  /**
   * Get the list of events for this department
   *
   * @param int $deptId
   *
   * @return array
   */
  public function filterList($deptId = 28){
    $response = $this->client->get('api/events', [
      'query' => [
        'department' => $deptId,
        '_format' => 'json',
      ],
    ]);
    return Json::decode($response->getBody());
  }

  /**
   * Show details of a single event
   *
   * @param int $eventId
   *
   * @return array
   */
  public function getEvent($eventId){
    $response = $this->client->get('api/event', [
      'query' => [
        'id' => $eventId,
        '_format' => 'json',
      ],
    ]);

    return Json::decode($response->getBody());

  }
}


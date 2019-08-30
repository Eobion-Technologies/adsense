<?php

namespace Drupal\adsense_adstxt\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AdsenseAdsTxtController.
 */
class AdsenseAdsTxtController extends ControllerBase {

  /**
   * Display the ads.txt page.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   Plain text response with the ads.txt content.
   */
  public function display() {
    $config = $this->config('adsense.settings');
    $publisher = $config->get('adsense_basic_id');

    if (!empty($publisher)) {
      $content = "google.com, $publisher, DIRECT, f08c47fec0942fa0\n";
      $response = new Response($content, 200, ['Content-Type' => 'text/plain']);

      return $response;
    }

    throw new NotFoundHttpException();
  }

}

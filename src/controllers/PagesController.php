<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PagesController extends Controller {

  public function home (RequestInterface $request, ResponseInterface $response) {
    $fb = new \Facebook\Facebook([
      'app_id' => '2157232504601426',
      'app_secret' => 'a41e09cd3d8ec4e3adc4154658b8cee6',
      'default_graph_version' => 'v3.0',
    ]);
    try {
      $resNews = $fb->get('1618411431756379?fields=feed.limit(3){message,created_time,full_picture,link}', 'EAAepZCdUie1IBABH4wKNNFrR2TPLZCBZCge5xJTTZBUdbxODMZAAbPecAGVucc3tGZCF5p3gWQsVGcqz4i9tXhBIKMdlU2ZCPGC4CbfVqLHneP4I95RbpX19ZBB3Khasr5EL9Hxq0v8RPaCm1T9KbQA94OANo1WebK02SIG4r7JOUwk0nXrtbzm89xdSQJyiP2EZD');
      $resEventTemp = $fb->get('1618411431756379?fields=events', 'EAAepZCdUie1IBABH4wKNNFrR2TPLZCBZCge5xJTTZBUdbxODMZAAbPecAGVucc3tGZCF5p3gWQsVGcqz4i9tXhBIKMdlU2ZCPGC4CbfVqLHneP4I95RbpX19ZBB3Khasr5EL9Hxq0v8RPaCm1T9KbQA94OANo1WebK02SIG4r7JOUwk0nXrtbzm89xdSQJyiP2EZD');
    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    $resNews = $resNews->getGraphNode();
    $resEventTemp = $resEventTemp->getGraphNode();
    $resNews = json_decode($resNews['feed'], true);
    $resEventTemp = json_decode($resEventTemp['events'], true);
    $resEvent = array();
    foreach ($resEventTemp as $resTemp) {
      date_default_timezone_set('Asia/Bangkok');
      $dateNow = date('Y-m-d H:i:s');
      $dateTemp = substr($resTemp['start_time']['date'], 0, 19);
      if ($dateTemp > $dateNow) {
        array_push($resEvent, $resTemp);
      }
    }
    $this->render($response, 'pages/Home.twig', [
      'resNews' => $resNews,
      'resEvent' => $resEvent,
      'current' => 'home'
    ]);
  }

  public function news (RequestInterface $request, ResponseInterface $response) {
    $fb = new \Facebook\Facebook([
      'app_id' => '2157232504601426',
      'app_secret' => 'a41e09cd3d8ec4e3adc4154658b8cee6',
      'default_graph_version' => 'v3.0',
    ]);
    try {
      $resNews = $fb->get('1618411431756379?fields=feed{message,created_time,full_picture,link}', 'EAAepZCdUie1IBABH4wKNNFrR2TPLZCBZCge5xJTTZBUdbxODMZAAbPecAGVucc3tGZCF5p3gWQsVGcqz4i9tXhBIKMdlU2ZCPGC4CbfVqLHneP4I95RbpX19ZBB3Khasr5EL9Hxq0v8RPaCm1T9KbQA94OANo1WebK02SIG4r7JOUwk0nXrtbzm89xdSQJyiP2EZD');
    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    $resNews = $resNews->getGraphNode();
    $resNews = json_decode($resNews['feed'], true);
    $this->render($response, 'pages/News.twig', [
      'resNews' => $resNews,
      'current' => 'news'
    ]);
  }

  public function event (RequestInterface $request, ResponseInterface $response) {
    $fb = new \Facebook\Facebook([
      'app_id' => '2157232504601426',
      'app_secret' => 'a41e09cd3d8ec4e3adc4154658b8cee6',
      'default_graph_version' => 'v3.0',
    ]);
    try {
      $resEvent = $fb->get('1618411431756379?fields=events', 'EAAepZCdUie1IBABH4wKNNFrR2TPLZCBZCge5xJTTZBUdbxODMZAAbPecAGVucc3tGZCF5p3gWQsVGcqz4i9tXhBIKMdlU2ZCPGC4CbfVqLHneP4I95RbpX19ZBB3Khasr5EL9Hxq0v8RPaCm1T9KbQA94OANo1WebK02SIG4r7JOUwk0nXrtbzm89xdSQJyiP2EZD');
    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    $resEvent = $resEvent->getGraphNode();
    $resEvent = json_decode($resEvent['events'], true);
    $this->render($response, 'pages/Event.twig', [
      'resEvent' => $resEvent,
      'current' => 'event'
    ]);
  }
}
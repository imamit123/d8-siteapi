<?php

namespace Drupal\siteapi\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Database\Database;
use Drupal\Core\Entity\Entity;
use Symfony\Component\HttpFoundation\Response;
use Drupal\node\NodeInterface;
Use \Drupal\Core\Routing;

  class CreateJsonController extends ControllerBase {
    public function GetJsonContent($api, NodeInterface $node) {
      $title = $node->getTitle();
      $type = $node->getType();
      $body =  $node->get('body')->value;  
      $SiteConfig = \Drupal::config('system.site')->get('siteapikey');
      $path = \Drupal::request()->getpathInfo();
      $arg  = explode('/',$path);
      if ($arg[2] != $SiteConfig) { 
        throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
      }
      $response = new Response();
      $response->setContent(json_encode(array('Content Type' => $type, 'title' => $title, 'body' => $body)));
      $response->headers->set('Content-Type', 'application/json');
      return $response;
    }
  }



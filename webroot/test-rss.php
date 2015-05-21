<?php
require __DIR__.'/config_with_app.php';

$di  = new \Anax\DI\CDIFactoryDefault();

$di->setShared('rss', function() {
    $rss = new \Anax\RSS\RSS();
    return $rss;
});

$app->router->add('rss', function() use ($app) {
  $xml = "http://dbwebb.se/forum/feed.php";
  $xmlDoc = new DOMDocument();
  $xmlDoc->load($xml);

  $app->theme->setVariable('title', "RSS Flöde")
         ->setVariable('main', "<h2>Senaste nytt/ändrat från " . $app->rss->setupAndGetTitle($xmlDoc) . " forumet</h2>");


  $app->views->addString($app->rss->getContent($xmlDoc), 'main');

});

$app->router->handle();
$app->theme->render();

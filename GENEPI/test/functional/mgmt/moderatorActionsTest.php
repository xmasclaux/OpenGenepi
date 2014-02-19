<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());

$browser->
  get('/moderator/index')->

  with('request')->begin()->
    isParameter('module', 'moderator')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('body', '!/This is a temporary page/')->
  end()
;

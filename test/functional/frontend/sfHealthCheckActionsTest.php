<?php

require_once dirname(__FILE__).'/../../bootstrap/functional.php';
require_once dirname(__FILE__).'/../../fixtures/FakeHealthCheck.class.php';

class sfHealthCheckActionsTest extends sfPHPUnitBaseFunctionalTestCase
{
  protected function getApplication()
  {
    return 'frontend';
  }

  public function testCheckEmpty()
  {
    $this->getBrowser()->
      get('/health/check.json')->
      with('response')->begin()->
        isStatusCode(200)->
      end()
    ;

    $this->assertEquals('[]', $this->getBrowser()->getResponse()->getContent());
  }

  public function testCheckWithFake()
  {
    $this->getBrowser()->addListener('healthcheck.gather', array('FakeHealthCheck', 'listenToGatherEvent'));
    $this->getBrowser()->getContext(true);

    $this->getBrowser()->
      get('/health/check.json')->
      with('response')->begin()->
        isStatusCode(200)->
      end();

    $json = <<<JSON
{"fake":{"status":200,"message":"Everything is fine."}}
JSON;
    $this->assertEquals($json, $this->getBrowser()->getResponse()->getContent());
  }
}
<?php

require_once dirname(__FILE__) . '/../bootstrap/unit.php';

class sfHealthCheckResultTest extends sfPHPUnitBaseTestCase
{
  public function statusCodeProvider()
  {
    return array(
      array(sfHealthCheckResult::STATUS_OK, true),
      array(sfHealthCheckResult::STATUS_UNKNOWN, true),
      array(sfHealthCheckResult::STATUS_BROKEN, true),

      array("INVALID", false),
      array(false, false),
      array(1338, false),
    );
  }

  /**
   * @dataProvider statusCodeProvider
   */
  public function testStatusCode($status, $isValid)
  {
    $this->assertEquals($isValid, sfHealthCheckResult::isValidStatus($status));
  }

  public function constructProvider()
  {
    return array(
      array('email', sfHealthCheckResult::STATUS_OK, 'Emails are being sent.', true),
      array('email', sfHealthCheckResult::STATUS_OK, '', true),
      array('email', sfHealthCheckResult::STATUS_UNKNOWN, 'Cannot determine status.', true),
      array('email', sfHealthCheckResult::STATUS_BROKEN, 'No emails have been sent for 3 hours.', true),

      array('email', 1338, 'Emails are being sent.', false),
      array('', sfHealthCheckResult::STATUS_OK, 'Emails are being sent.', false),
      array(true, sfHealthCheckResult::STATUS_OK, 'Emails are being sent.', false),
      array('email', sfHealthCheckResult::STATUS_OK, 1338, false),
    );
  }

  /**
   * @dataProvider constructProvider
   */
  public function testConstruct($name, $status, $message, $valid)
  {
    if (!$valid)
    {
      $this->setExpectedException('InvalidArgumentException');
    }

    $result = new sfHealthCheckResult($name, $status, $message);

    $this->assertEquals($name, $result->getName());
    $this->assertEquals($status, $result->getStatus());
    $this->assertEquals($message, $result->getMessage());
  }
}
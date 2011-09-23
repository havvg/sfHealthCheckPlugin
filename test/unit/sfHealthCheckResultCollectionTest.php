<?php

require_once dirname(__FILE__) . '/../bootstrap/unit.php';

class sfHealthCheckResultCollectionTest extends sfPHPUnitBaseTestCase
{
  public function testAddResult()
  {
    $collection = new sfHealthCheckResultCollection();
    $result = new sfHealthCheckResult('email', sfHealthCheckResult::STATUS_OK, '');

    $this->assertEquals($collection, $collection->addResult($result));
    $this->assertEquals(1, count($collection));
  }

  public function addInvalidProdiver()
  {
    return array(
      array(null, 5),
      array(null, true),
      array(null, 'Result'),
      array(0, 'Result'),
      array(7, 'Result'),
      array('email', 'Result'),
    );
  }

  /**
   * @dataProvider addInvalidProdiver
   */
  public function testAddInvalid($offset, $value)
  {
    $collection = new sfHealthCheckResultCollection();

    $this->setExpectedException('InvalidArgumentException');
    $collection[$offset] = $value;
  }

  public function testArrayAccess()
  {
    $collection = new sfHealthCheckResultCollection();

    $email = new sfHealthCheckResult('email', sfHealthCheckResult::STATUS_OK, '');
    $messageQueue = new sfHealthCheckResult('messagequeue', sfHealthCheckResult::STATUS_OK, '');

    $collection
      ->addResult($email)
      ->addResult($messageQueue)
    ;

    $this->assertEquals(2, count($collection));
    $this->assertTrue(isset($collection[0]));
    $this->assertEquals($email, $collection[0]);
    $this->assertTrue(isset($collection[1]));
    $this->assertEquals($messageQueue, $collection[1]);

    unset($collection[1]);
    $this->assertEquals(1, count($collection));
    $this->assertTrue(isset($collection[0]));
    $this->assertFalse(isset($collection[1]));
    $this->assertEquals(null, $collection[1]);

    $collection[1] = $messageQueue;
    $this->assertEquals(2, count($collection));
    $this->assertTrue(isset($collection[1]));
    $this->assertEquals($messageQueue, $collection[1]);
  }

  public function testIterator()
  {
    $collection = new sfHealthCheckResultCollection();

    $email = new sfHealthCheckResult('email', sfHealthCheckResult::STATUS_OK, '');
    $messageQueue = new sfHealthCheckResult('messagequeue', sfHealthCheckResult::STATUS_OK, '');

    $collection
      ->addResult($email)
      ->addResult($messageQueue)
    ;

    $this->assertEquals(2, count($collection));
    foreach ($collection as $eachResult)
    {
      $this->assertInstanceOf('sfHealthCheckResult', $eachResult);
    }
  }

  public function testCannotAddTwice()
  {
    $collection = new sfHealthCheckResultCollection();

    $email = new sfHealthCheckResult('email', sfHealthCheckResult::STATUS_OK, '');
    $email2 = new sfHealthCheckResult('email', sfHealthCheckResult::STATUS_OK, '');

    $collection->addResult($email);

    $this->setExpectedException('RuntimeException');
    $collection->addResult($email2);
  }
}
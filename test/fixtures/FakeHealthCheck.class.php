<?php

class FakeHealthCheck
{
  public static function listenToGatherEvent(sfEvent $event, sfHealthCheckResultCollection $collection)
  {
    $collection[] = new sfHealthCheckResult('fake', sfHealthCheckResult::STATUS_OK, 'Everything is fine.');

    return $collection;
  }
}
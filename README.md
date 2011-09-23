# sfHealthCheckPlugin

## sfHealthCheckResult

The sfHealthCheckResult is a ValueObject on results of checked systems. It consists of three parts:

* The ``name`` of the system checked.
* The ``status`` code of the systems health.
* The ``message`` containing details on the result.

### Status codes

There are three different states available to a health check result.

* ``STATUS_OK`` represents a healthy system.
* ``STATUS_UNKNOWN`` represents a system, which status can not be checked. This should be considered a "warning".
* ``STATUS_BROKEN`` represents a system, which is not operating correctly! This reflects an error in system!

### sfHealthCheckResultCollection

The ``sfHealthCheckResultCollection`` is a list of ``sfHealthCheckResult``.

## healthcheck.gather event

This is event is fired inside the module. It passes an empty ``sfHealthCheckResultCollection`` as the value to be filtered. Every listener is meant to add its ``sfHealthCheckResult`` to the collection.

Add your health check as a listener to the gather event.

```php
<?php // config/ProjectConfiguration.class.php
class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->getEventDispatcher()->connect('healthcheck.gather', array('YourHealthCheckClass', 'listenToGatherEvent'));

    // ..
  }
}
```

A very basic example health check listener can be found in the test fixtures.

## Health checking

How to check the health status of a system or part of your application is completely up to you. You could for example run tasks, putting results into a database and read the content on the ``healthcheck.gather`` event.

## Tests

The tests are written for ``PHPUnit`` and require the ``sfPHPUnit2Plugin`` to be installed.
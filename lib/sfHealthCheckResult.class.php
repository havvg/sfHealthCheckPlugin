<?php

class sfHealthCheckResult
{
  const STATUS_OK = 200;
  const STATUS_UNKNOWN = 500;
  const STATUS_BROKEN = 503;

  protected $name;
  protected $status;
  protected $message;

  public function __construct($name, $status, $message)
  {
    if (!is_string($name))
    {
      throw new InvalidArgumentException('The given name is no valid string.');
    }

    if (empty($name))
    {
      throw new InvalidArgumentException('The name cannot be blank.');
    }

    if (!self::isValidStatus($status))
    {
      throw new InvalidArgumentException('The given status is invalid.');
    }

    if (!is_string($message))
    {
      throw new InvalidArgumentException('The given message is no valid string.');
    }

    $this->name = $name;
    $this->status = $status;
    $this->message = $message;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function getMessage()
  {
    return $this->message;
  }

  public static function isValidStatus($status)
  {
    $available = array(
      self::STATUS_OK,
      self::STATUS_UNKNOWN,
      self::STATUS_BROKEN,
    );

    return in_array($status, $available);
  }
}

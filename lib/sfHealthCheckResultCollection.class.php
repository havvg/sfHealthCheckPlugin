<?php

class sfHealthCheckResultCollection implements Iterator, Countable, ArrayAccess
{
  /**
   * @var array of sfHealthCheckResult
   */
  private $results = array();

  /**
   * A list of already added system names.
   *
   * @var array
   */
  private $names = array();

  /**
   * The index for Iterator interface.
   *
   * @var int
   */
  private $position = 0;

  /**
   * Add a result to the collection.
   *
   * @param sfHealthCheckResult $result
   *
   * @return sfHealthCheckResultCollection $this
   */
  public function addResult(sfHealthCheckResult $result)
  {
    $this->offsetSet(null, $result);

    return $this;
  }

  // Countable

  public function count()
  {
    return count($this->results);
  }

  // ArrayAccess

  public function offsetSet($offset, $value)
  {
    if (!$value instanceof sfHealthCheckResult)
    {
      throw new InvalidArgumentException('The given value is no "sfHealthCheckResult" object.');
    }

    if (in_array($value->getName(), $this->names))
    {
      throw new RuntimeException(sprintf('You cannot add a result for the same system ("%s") twice.', $value->getName()));
    }

    $this->names[$value->getName()] = $value->getName();

    if (is_null($offset))
    {
      $this->results[] = $value;
    }
    else
    {
      $this->results[$offset] = $value;
    }
  }

  public function offsetExists($offset)
  {
    return isset($this->results[$offset]);
  }

  public function offsetUnset($offset)
  {
    unset($this->names[$this->results[$offset]->getName()]);
    unset($this->results[$offset]);
  }

  public function offsetGet($offset)
  {
    return isset($this->results[$offset]) ? $this->results[$offset] : null;
  }

  // Iterator

  public function rewind()
  {
    $this->position = 0;
  }

  public function current()
  {
    return $this->results[$this->position];
  }

  public function key()
  {
    return $this->position;
  }

  public function next()
  {
    ++$this->position;
  }

  public function valid()
  {
    return isset($this->results[$this->position]);
  }
}
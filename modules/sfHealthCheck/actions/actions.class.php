<?php

class sfHealthCheckActions extends sfActions
{
  public function executeCheck(sfWebRequest $request)
  {
    $event = new sfEvent($this, 'healthcheck.gather');
    $this->getContext()->getEventDispatcher()->filter($event, new sfHealthCheckResultCollection());
    $this->results = $event->getReturnValue();

    return sfView::SUCCESS;
  }
}
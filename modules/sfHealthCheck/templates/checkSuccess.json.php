<?php

$data = array();

/* @var $eachResult sfHealthCheckResult */
foreach ($results as $eachResult)
{
  $data[$eachResult->getName()] = array(
    'status' => $eachResult->getStatus(),
    'message' => $eachResult->getMessage(),
  );
}

echo json_encode($data);
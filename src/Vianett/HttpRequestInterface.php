<?php

namespace Vianett;

interface HttpRequestInterface
{
  public function __construct($values = array());

  public function setValues($values = array());

  public function execute();

  public function getCode();

  public function close();
}

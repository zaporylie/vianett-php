<?php

namespace Vianett;

interface HttpRequestInterface
{
  public function __construct($values, $path);

  public function execute();

  public function getCode();

  public function close();
}

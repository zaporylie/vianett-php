<?php

namespace Vianett;

interface HttpRequestInterface
{
  public function __construct($values = []);

  public function setValues($values = []);

  public function execute();

  public function getCode();

  public function close();
}

<?php

namespace Vianett;

class VianettHttpRequest {

  /**
   * @var array
   */
  protected $values;

  /**
   *
   */
  const HOST = 'https://smsc.vianett.no/V3/CPA/MT/MT.ashx';

  public function setValues($values = []) {
    $this->values = $values;
  }

}

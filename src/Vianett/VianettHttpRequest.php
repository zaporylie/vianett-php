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
  const HOST = 'http://smsc.vianett.no/V3/CPA/MT/MT.ashx';

  public function setValues($values = array()) {
    $this->values = $values;
  }

}

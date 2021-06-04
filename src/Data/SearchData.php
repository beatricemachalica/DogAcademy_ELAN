<?php

namespace App\Data;

class SearchData
{

  /**
   * @var string
   */
  public $q = '';

  /**
   * @var Sessions[]
   */
  public $sessions = [];

  /**
   * @var Formations[]
   */
  public $formations = [];

  /**
   * @var \DateTimeInterface
   */
  public $min = [];

  /**
   * @var \DateTimeInterface
   */
  public $max = [];
}

<?php
class irca extends ActiveRecord
{
  protected function initialize()
  {
    $this->belongs_to('tipoensayo');
  }
}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cliente
 *
 * @author Cristhian
 */
class Cliente extends ActiveRecord {
    //put your code here
    protected function initialize()
    {
      $this->belongs_to('tipocliente');
      $this->belongs_to('tipomunicipio');
    }
}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tempformatotipoensayo
 *
 * @author Cristhian
 */
class Tempformatotipoensayo extends ActiveRecord {
    protected function initialize() {
      $this->belongs_to('tipoensayo');
    }
}

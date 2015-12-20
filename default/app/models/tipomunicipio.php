<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tipomunicipio
 *
 * @author Cristhian
 */
class Tipomunicipio extends ActiveRecord
{
    //put your code here
    protected function initialize()
    {
      $this->belongs_to('tipodepartamento');
    }
}

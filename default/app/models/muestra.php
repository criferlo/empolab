<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of muestra
 *
 * @author Cristhian
 */
class Muestra extends ActiveRecord
{
  //put your code here

  public function initialize()
  {
    $this->belongs_to('tipomatrizanalizada');
    $this->belongs_to('tipomuestra');
    $this->belongs_to('lugartomamuestra');
    $this->has_many('muestramemoriacalculo');
  }

  public function CargarMuestrasXFormatoId($formatoId)
  {
    return $this->find("formato_id=$formatoId ORDER BY id");
  }
}

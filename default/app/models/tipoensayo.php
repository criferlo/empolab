<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tipoensayo
 *
 * @author Cristhian
 */
class Tipoensayo extends ActiveRecord
{
    //put your code here
    public function initialize()
    {
        $this->has_many('constantetipoensayo');
        $this->belongs_to('tecnicaanalitica');
        $this->belongs_to('metodo');
        $this->belongs_to('unidad');
    }

    public function CargarAcidez()
    {
        return $this->find_first("id=2");
    }

    public function CargarAlcalinidadRangoBajo()
    {
        return $this->find_first("id=46");
    }

    public function CargarAlcalinidad()
    {
        return $this->find_first("id=3");
    }

    public function CargarDurezaTotal()
    {
        return $this->find_first("id=22");
    }
    public function CargarDurezaCalcica()
    {
        return $this->find_first("id=20");
    }
    public function CargarVarios()
    {
        return $this->find_first("id=49");
    }
    public function CargarCloruros()
    {
        return $this->find_first("id=8");
    }
    public function CargarMicrobiologia()
    {
        return $this->find_first("id=50");
    }
}

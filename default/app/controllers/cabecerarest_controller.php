<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cabecerarest_controller
 *
 * @author Cristhian
 */
Load::model("muestra");

class CabecerarestController extends RestController {

    //put your code here

    public function post() {
        $this->data = $this->param();
        foreach ($this->data as $ms) {
            $muestra = new Muestra();
            $muestra->tomamuestra_fecha = $ms['fechatoma'];
            $muestra->tomamuestra_hora = $ms['horatoma'];
            $muestra->recepcionmuestra_fecha = $ms['fecharecepcion'];
            $muestra->recepcionmuestra_hora = $ms['horarecepcion'];
            $muestra->tipomatrizanalizada_id = $ms['tipomatriz'];
            $muestra->tipomuestra_id = $ms['tipomuestra'];
            $muestra->codigomuestra = $ms['codigomuestra'];
            $muestra->lugartomamuestra_id = $ms['lugarmuestra'];
            $muestra->formato_id = $ms['formato_id'];
            $muestra->save();
        }
    }

}

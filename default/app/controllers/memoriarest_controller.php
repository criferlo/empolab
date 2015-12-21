<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of memoriarest_controller
 *
 * @author Cristhian
 */
Load::model("muestramemoriacalculo");
class MemoriarestController extends RestController {
    //put your code here
    public function post(){
        $this->data = $this->param();
        foreach ($this->data as $ms)
        {
            $mmc = new Muestramemoriacalculo();

            $mmc->muestra_id    = $ms['muestra_id'];
            $mmc->valor1        = $ms['valor1'];
            $mmc->valor2        = $ms['valor2'];
            $mmc->valor3        = $ms['valor3'];
            $mmc->valor4        = $ms['valor4'];
            $mmc->valor5        = $ms['valor5'];
            $mmc->resultado     = $ms['resultado'];
            $mmc->tipoensayo_id = $ms['tipoensayo_id'];

            $mmc->save();
        }
    }

    public function delete($id){
        $this->data = $this->param();
        foreach ($this->data as $ms) {
            $mmc = new Muestramemoriacalculo();
            $mmc->delete("muestra_id=".$ms["muestra_id"]);
        }
    }
}

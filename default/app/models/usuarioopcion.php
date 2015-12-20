<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarioopcion
 *
 * @author Cristhian
 */
class Usuarioopcion extends ActiveRecord{
    //put your code here
    
     public function darOpciones($idusuario){
        return $this->find('columns: opcionmodulo.nombreopcion as nombre, modulo.nombremodulo as nombremodulo, usuarioopcion.id as identificador ',
                           'join: inner join opcionmodulo on usuarioopcion.opcionmodulo_id=opcionmodulo.id inner join modulo on opcionmodulo.modulo_id = modulo.id inner join usuario on usuario.id= usuarioopcion.usuario_id',
                           'conditions: usuarioopcion.usuario_id='.$idusuario);
    }
}

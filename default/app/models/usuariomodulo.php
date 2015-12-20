<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuariomodulo
 *
 * @author Cristhian
 */
class Usuariomodulo extends ActiveRecord{
    //put your code here
    
     public function darModulos($idusuario){
        return $this->find('columns: modulo.nombremodulo as nombre, usuario.nombrecompleto as usuarionombre,usuariomodulo.id as identificador ',
                           'join: inner join modulo on usuariomodulo.modulo_id=modulo.id inner join usuario on usuario.id= usuariomodulo.usuario_id',
                           'conditions: usuariomodulo.usuario_id='.$idusuario);
    }
 
}

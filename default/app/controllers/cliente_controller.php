<?php

/**
 * 
 */
View::template('home');
Load::models("usuario","usuariomodulo","usuarioopcion","cliente");
class ClienteController extends AppController {

    function before_filter() {
        $usr = Session::get("usuario_id");

        $usuarioopcion = Load::model('usuarioopcion')->find_first("opcionmodulo_id=9 AND usuario_id=$usr");

        if (!$usuarioopcion) {
            //Router::redirect('login/index');
        }
    }

    function index() {

        $this->clientes = Load::model('cliente')->find();
    }

    function nuevo() {
        $this->cliente = Load::model('cliente');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cliente = new Cliente(Input::post('cliente'));

            if (!$this->cliente->create()) {
                Flash::error('Se presento un error al crear el objeto');
            } else {
                $usu = new Usuario();
                $usu->nombrecompleto = $this->cliente->nombre;
                $usu->cedula = $this->cliente->nit;
                $usu->clave = $this->cliente->nit;
                $usu->sesionabierta = "0";
                $usu->tipousuario_id = "6"; //externo
                //grabar
                $usu->save();
                //permisos
                $usum = new Usuariomodulo();
                $usum->modulo_id = "3"; //sesion
                $usum->usuario_id = $usu->id;
                $usum->save();
                //
                $usum = new Usuariomodulo();
                $usum->modulo_id = "4"; //invitado
                $usum->usuario_id = $usu->id;
                $usum->save();
                //
                $usuo = new Usuarioopcion();
                $usuo->opcionmodulo_id = "8";
                $usuo->usuario_id = $usu->id;
                $usuo->save();
                //
                $usuo = new Usuarioopcion();
                $usuo->opcionmodulo_id = "11";
                $usuo->usuario_id = $usu->id;
                $usuo->save();

                Router::redirect('/cliente/index');
            }
        }
    }

    function editar($id) {
        $this->cliente = Load::model('cliente')->find_first("id=$id");
        $this->cliente->tipodepartamento_id = $this->cliente->getTipomunicipio()->tipodepartamento_id;
        $this->municipios = Load::model('tipomunicipio')->find('tipodepartamento_id=' . $this->cliente->tipodepartamento_id);

        if (!$this->cliente) {
            Flash::error("No existe un cliente con el código $id");
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->cliente->update(Input::post('cliente'))) {
                Flash::error('Se presento un error al actualizar el registro');
            } else {
                Router::redirect('/cliente/index');
            }
        }
    }

    function eliminar($id) {
        $this->cliente = Load::model('cliente')->find_first("id=$id");

        if (!$this->cliente) {
            Flash::error("No existe un cliente con el código $id");
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cliente->delete();

            Router::redirect('/cliente/index');
        }
    }

    function filtrar_municipios($tipodepartamento_id, $cliente_id = null) {
        $this->municipios = Load::model('tipomunicipio')->find("tipodepartamento_id=$tipodepartamento_id");
        $this->cliente = null;

        if (isset($cliente_id)) {
            $this->cliente = Load::model('cliente')->find_first("id=$cliente_id");
        }

        View::template(null);
    }
    
    function homeinvitado(){
        
    }

}

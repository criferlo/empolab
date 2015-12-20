<?php

View::template("home");
Load::models("tipousuario", "usuario", "modulo", "opcionmodulo", "usuariomodulo", "usuarioopcion");

Class UsuarioController extends AppController {

    function index() {
        $objeto = new Usuario();
        $this->usuarios = array();
        $this->usuarios = $objeto->find();

        if (Input::hasPost("textoBusqueda")) {
            $comboBusqueda = Input::post("comboBusqueda");
            $textoBusqueda = Input::post("textoBusqueda");

            $objeto = new Usuario();
            $this->usuarios = array();

            if ($textoBusqueda != "") {

                //IDENTIFICACION
                if ($comboBusqueda == 0) {
                    $this->usuarios = $objeto->find("cedula=$textoBusqueda");
                }//APELLIDO
                else if ($comboBusqueda == 1) {
                    $this->usuarios = $objeto->find("nombrecompleto=$textoBusqueda");
                }
            } else {
                Flash::success("Escriba texto de bÃºsqueda");
            }
        }
    }

    function nuevo() {

        $objeto = new Usuario();
        $this->usuarios = array();


        $usuario = new Usuario(Input::post("usuario"));
        $usuarioencontrado = $objeto->find("conditions: cedula='$usuario->cedula'");
        $this->usuarios = $objeto->find();


        $this->usuario_id = "0";
        if (Input::hasPost("tipousuario")) {
            //Campos
            if (!$usuarioencontrado) {
                $tipousuario = Input::post("tipousuario");

                $usuario->tipousuario_id = $tipousuario["tipousuario_id"];

                if ($usuario->save()) {
                    $this->usuario_id = $usuario->id;
                    Flash::info("Datos grabados correctamente");
                    Router::redirect("usuario/index");
                } else {
                    Flash::error("Ups!! hay un error, intente nuevamente");
                }
            } else {
                Flash::error("El usuario registrado con esa cedula  ya existe");
            }
        }
    }

    function modificarperfil($idusuario) {
        $this->idusuario = $idusuario;
        $modulo = new Modulo();
        $this->modulos = array();
        $this->modulos = $modulo->find();

        $moduloUsuario = new Usuariomodulo();
        $this->modulosusuario = array();
        $this->modulosusuario = $moduloUsuario->darModulos($idusuario);
        if (Input::hasPost("idusuario")) {

            $bandera = 0;
            $usuariomodulo = new Usuariomodulo();
            $numero2 = count($_POST);
            $valores2 = array_values($_POST); // obtiene los valores de las varibles        

            for ($i = 0; $i < $numero2 - 1; $i++) {

                $auxiliar = new Usuariomodulo();
                $encontrado = $auxiliar->find("conditions: modulo_id=$valores2[$i] and usuario_id=$idusuario");
                if ($encontrado) {
                    $bandera = 1;
                }
            }
             if($bandera==0){

            for ($i = 0; $i < $numero2 - 1; $i++) {

                $temp = new Usuariomodulo();
                $temp->modulo_id = $valores2[$i];
                $temp->usuario_id = $idusuario;
                $temp->save();
            }

            if ($temp->save()) {
                Flash::info("Modulos guardados");
                Router::redirect("usuario/modificarperfil/" . $idusuario);
            } else {
                Flash::info("Ups!! hay un error, intente nuevamente");
            }
            
            }
            
            else{
                Flash::error("Algunos modulos ya estan asignados. Intente de nuevo");
            }

        }
    }

    function eliminarmodulousuario($idmodulo) {
        
        $objeto = new Usuariomodulo();
        $objeto->find_first($idmodulo);
        if ($objeto->delete($objeto->id)) {
            Flash::info("Modulo eliminado");
            Router::redirect("usuario/index");
        } else {
            Flash::error("No se pudo eliminar.");
        }
    }

    function agregaropciones($idusuario) {
        $this->idusuario = $idusuario;
        $opcion = new Opcionmodulo();
        $this->opciones = array();
        $this->opciones = $opcion->find();
        $opcionusuario = new Usuarioopcion();
        $this->opcionesusuario = array();
        $this->opcionesusuario = $opcionusuario->darOpciones($idusuario);

        if (Input::hasPost("idusuario")) {

            $bandera = 0;
            $usuariopcion = new Usuarioopcion();
            $numero2 = count($_POST);
            $valores2 = array_values($_POST); // obtiene los valores de las varibles        

            for ($i = 0; $i < $numero2 - 1; $i++) {

                $auxiliar = new Usuarioopcion();
                $encontrado = $auxiliar->find("conditions: opcionmodulo_id=$valores2[$i] and usuario_id=$idusuario");
                if ($encontrado) {
                    $bandera = 1;
                }
            }

            if ($bandera == 0) {

                for ($i = 0; $i < $numero2 - 1; $i++) {
                    $temp = new Usuarioopcion();
                    $temp->opcionmodulo_id = $valores2[$i];
                    $temp->usuario_id = $idusuario;
                    $temp->save();
                }

                if ($temp->save()) {
                    Flash::info("Opciones Guardadas");
                    Router::redirect("usuario/agregaropciones/" . $idusuario);
                } else {
                    Flash::info("Ups!! hay un error, intente nuevamente");
                }
            } else {
                Flash::error("Algunas opciones ya esta asignadas. Intente de nuevo");
            }
        }
    }

    function eliminaropcionusuario($idopcion) {

        $objeto = new Usuarioopcion();
        $objeto->find_first($idopcion);
        if ($objeto->delete($objeto->id)) {
            Flash::info("Opcion eliminada");
            Router::redirect("usuario/index");
        } else {
            Flash::error("No se pudo eliminar.");
        }
    }

    function editar($idusuario) {

        //aqui se consulta al usuario por el id
        //se envia el id por el link

        $usu = new Usuario();
        $this->usu_consultado = $usu->find_first($idusuario);

        //si decimos this es porque yapodemos usarlo en la vista
        //lo demas es lo mismo porque tomamos los mismos datos y actualizamos al usuario
        if (Input::hasPost("tipousuario")) {
            //Flash::info("hola");
            //Campos           
            $tipousuario = Input::post("tipousuario");
            $usuario = new Usuario(Input::post("usuario"));
            $usuario->tipousuario_id = $tipousuario["tipousuario_id"];
            $usuario->id = Input::post("idusuario");
            if ($usuario->update()) {
                $this->usuario_id = $usuario->id;
                Flash::info("Datos grabados correctamente");
            } else {
                Flash::error("Ups!! hay un error, intente nuevamente");
            }
        }
    }

    function eliminar($idusuario) {


        $objeto = new Usuario();
        $objeto->find_first($idusuario);
        if ($objeto->delete()) {
            Router::redirect("usuario/index");
        } else {
            Flash::error("No se pudo eliminar.");
        }
    }

}

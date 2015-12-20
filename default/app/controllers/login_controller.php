<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login_controller
 *
 * @author Cristhian
 */
View::template("login");
class LoginController extends AppController
{

    //put your code here
  function index()
  {
    if (Input::hasPost("usuario")) {
      $login = Input::post("usuario");
      $clave = Input::post("clave");

      $auth = new Auth(
        "model",
        "class: usuario",
        "cedula: $login",
        "clave: $clave"
      );

      if ($auth->authenticate()) {
        $usu = new Usuario();
        $usu->find_first("cedula='$login' and clave='$clave'");

        //if ($usu->tipousuario_id == 1) {//vendedor
          Session::set("usuario_id", $usu->id);
          Session::set("usuario_nombrecompleto", $usu->nombrecompleto);
          Router::redirect("home/index");
        //}
      } else {
        Flash::error("Login o Clave inválido.");
      }
    }
  }

  function cerrar()
  {
    Auth::destroy_identity();
    Session::delete("usuario_id");
    Session::delete("usuario_nombrecompleto");
    Router::redirect("login/index");
  }
}

<?php

/**
* 
*/
View::template('home');
class IrcaController extends AppController
{
    function before_filter()
    {
      $usr = Session::get("usuario_id");

      $usuarioopcion = Load::model('usuarioopcion')->find_first("opcionmodulo_id=10 AND usuario_id=$usr");

      if (!$usuarioopcion) {
        Router::redirect('login/index');
      }
    }

    function index()
    {

      $this->ircas = Load::model('irca')->find();
    }

    function nuevo()
    {
      $this->irca = Load::model('irca');

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->irca = new Irca(Input::post('irca'));

        if (!$this->irca->create()) {
          Flash::error('Se presento un error al crear el objeto');
        } else {
          Router::redirect('/irca/index');
        }
      }
    }

    function editar($id)
    {
      $this->irca = Load::model('irca')->find_first("id=$id");

      if (!$this->irca) {
          Flash::error("No existe un irca con el código $id");
      } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!$this->irca->update(Input::post('irca'))) {
          Flash::error('Se presento un error al actualizar el registro');
        } else {
          Router::redirect('/irca/index');
        }
      }
    }

    function eliminar($id)
    {
      $this->irca = Load::model('irca')->find_first("id=$id");

      if (!$this->irca) {
          Flash::error("No existe un irca con el código $id");
      } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->irca->delete();

        Router::redirect('/irca/index');
      }
    }
}
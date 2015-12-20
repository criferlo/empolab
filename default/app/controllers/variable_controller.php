<?php

View::template('home');
Load::models(
    'formato',
    'muestra',
    'tipoensayo',
    'tipomuestra',
    'lugartomamuestra',
    'muestramemoriacalculo',
    'tempformatotipoensayo'
);
class VariableController extends AppController
{
    function index()
    {
        $tipoEnsayo = new TipoEnsayo();

        $this->tiposEnsayo = $tipoEnsayo->find();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tags2 = array_keys($_POST); // obtiene los nombres de las varibles
            $valores2 = array_values($_POST); // obtiene los valores de las varibles

            foreach ($tags2 as $index => $constId) {
              $id = explode("_", $constId);
              $id = $id[1];

              $constante = Load::model('constantetipoensayo')->find_first("id=$id");

              if (isset($constante) && $constante->valor != $valores2[$index]) {
                $constante->valor = $valores2[$index];

                $constante->save();
              }
            }
        }
    }

    function constantes($id)
    {
        $tipoEnsayo       = new TipoEnsayo();
        $this->tipoEnsayo = $tipoEnsayo->find_first("id=$id");
        $this->constantes = $tipoEnsayo->getConstantetipoensayo();
    }

    function editar_constante($id)
    {
        $this->constante = Load::model('constantetipoensayo')->find_first("id=$id");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          if (!$this->constante->update(Input::post('constante'))) {
            Flash::error('Se presento un error al actualizar el registro');
          } else {
            Router::redirect('/variable/constantes/'.$this->constante->tipoensayo_id);
          }
        }
    }
}
<?php 

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of home_controller
 *
 * @author Germán David Ruiz Figueroa
 */
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
class MemoriaController extends AppController
{
  public function variables()
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
}
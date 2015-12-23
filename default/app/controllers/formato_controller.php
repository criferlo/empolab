<?php

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of home_controller
 *
 * @author German David Ruiz Figueroa
 */
View::template('home');
Load::models(
    'irca',
    'formato',
    'muestra',
    'tipoensayo',
    'tipomuestra',
    'lugartomamuestra',
    'muestramemoriacalculo',
    'tempformatotipoensayo'
);
Load::lib("PHPExcel/PHPExcel");

class FormatoController extends AppController
{
    public function __construct($module, $controller, $action, $parameters)
    {
        parent::__construct($module, $controller, $action, $parameters);

        $this->columnsConfig = array();

        $this->columnsConfig[] = array('col' => 'A', 'width' => 10);
        $this->columnsConfig[] = array('col' => 'B', 'width' => 6);
        $this->columnsConfig[] = array('col' => 'C', 'width' => 4);
        $this->columnsConfig[] = array('col' => 'D', 'width' => 1);
        $this->columnsConfig[] = array('col' => 'E', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'F', 'width' => 7);
        $this->columnsConfig[] = array('col' => 'G', 'width' => 8);
        $this->columnsConfig[] = array('col' => 'H', 'width' => 8);
        $this->columnsConfig[] = array('col' => 'I', 'width' => 0);
        $this->columnsConfig[] = array('col' => 'J', 'width' => 21);
        $this->columnsConfig[] = array('col' => 'K', 'width' => 12);
        $this->columnsConfig[] = array('col' => 'L', 'width' => 14);
        $this->columnsConfig[] = array('col' => 'M', 'width' => 20);
        $this->columnsConfig[] = array('col' => 'N', 'width' => 19);
        $this->columnsConfig[] = array('col' => 'O', 'width' => 19);
        $this->columnsConfig[] = array('col' => 'P', 'width' => 19);
        $this->columnsConfig[] = array('col' => 'Q', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'R', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'S', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'T', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'U', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'V', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'W', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'X', 'width' => 16);

        $this->columnsConfig[] = array('col' => 'Y', 'width' => 10);
        $this->columnsConfig[] = array('col' => 'Z', 'width' => 6);
        $this->columnsConfig[] = array('col' => 'AA', 'width' => 4);
        $this->columnsConfig[] = array('col' => 'AB', 'width' => 1);
        $this->columnsConfig[] = array('col' => 'AC', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'AD', 'width' => 7);
        $this->columnsConfig[] = array('col' => 'AE', 'width' => 8);
        $this->columnsConfig[] = array('col' => 'AF', 'width' => 8);
        $this->columnsConfig[] = array('col' => 'AG', 'width' => 0);
        $this->columnsConfig[] = array('col' => 'AH', 'width' => 21);
        $this->columnsConfig[] = array('col' => 'AI', 'width' => 12);
        $this->columnsConfig[] = array('col' => 'AJ', 'width' => 14);
        $this->columnsConfig[] = array('col' => 'AK', 'width' => 20);
        $this->columnsConfig[] = array('col' => 'AL', 'width' => 19);
        $this->columnsConfig[] = array('col' => 'AM', 'width' => 18);
        $this->columnsConfig[] = array('col' => 'AN', 'width' => 19);
        $this->columnsConfig[] = array('col' => 'AO', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'AP', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'AQ', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'AR', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'AS', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'AT', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'AU', 'width' => 16);
        $this->columnsConfig[] = array('col' => 'AV', 'width' => 16);
    }

    public function before_filter()
    {
        if (!Auth::is_valid()) {
            Router::redirect('login/index');
        }
    }

    public function index($id)
    {
        $formato      = new Formato();
        $muestra      = new Muestra();
        $tipoEnsayo   = new Tipoensayo();
        $identMuestra = array();

        $this->formato              = $formato->find_first("id=$id");
        $this->muestras             = $muestra->CargarMuestrasXFormatoId($id);
        $this->acidez               = $tipoEnsayo->CargarAcidez();
        $this->alcalinidadRangoBajo = $tipoEnsayo->CargarAlcalinidadRangoBajo();
        $this->alcalinidad          = $tipoEnsayo->CargarAlcalinidad();
        $this->durezaTotal          = $tipoEnsayo->CargarDurezaTotal();
        $this->durezaCalcica        = $tipoEnsayo->CargarDurezaCalcica();
        $this->varios               = $tipoEnsayo->CargarVarios();
        $this->cloruros             = $tipoEnsayo->CargarCloruros();
        $this->microbiologia        = $tipoEnsayo->CargarMicrobiologia();
        $this->identMuestra         = $this->genIndicadores($this->muestras);
    }
    
    //le envian formato id y el carga el formato
    //con los valores de base de datos
    public function modificar($id)
    {
        $formato                    = new Formato();
        $muestra                    = new Muestra();
        $tipoEnsayo                 = new Tipoensayo();
        $identMuestra               = array();

        $this->user                 = Load::model('usuario')->find(Session::get('usuario_id'));
        $this->formato              = $formato->find_first("id=$id");

        if ($this->formato->estado == 0 && $this->user->tipousuario_id == 1) {
            Router::redirect("home/seltipoensayo/$id");
        } else {
            $this->muestras             = $muestra->CargarMuestrasXFormatoId($id);
            $this->acidez               = $tipoEnsayo->CargarAcidez();
            $this->alcalinidadRangoBajo = $tipoEnsayo->CargarAlcalinidadRangoBajo();
            $this->alcalinidad          = $tipoEnsayo->CargarAlcalinidad();
            $this->durezaTotal          = $tipoEnsayo->CargarDurezaTotal();
            $this->durezaCalcica        = $tipoEnsayo->CargarDurezaCalcica();
            $this->varios               = $tipoEnsayo->CargarVarios();
            $this->cloruros             = $tipoEnsayo->CargarCloruros();
            $this->microbiologia        = $tipoEnsayo->CargarMicrobiologia();
            $this->identMuestra         = $this->genIndicadores($this->muestras);
        }


        // $formato      = new Formato();
        // $muestra      = new Muestra();
        // $tipoEnsayo   = new Tipoensayo();
        // $identMuestra = array();

        // $this->formato              = $formato->find_first("id=$id");
        // $this->muestras             = $muestra->CargarMuestrasXFormatoId($id);
        // $this->acidez               = $tipoEnsayo->CargarAcidez();
        // $this->alcalinidadRangoBajo = $tipoEnsayo->CargarAlcalinidadRangoBajo();
        // $this->alcalinidad          = $tipoEnsayo->CargarAlcalinidad();
        // $this->durezaTotal          = $tipoEnsayo->CargarDurezaTotal();
        // $this->durezaCalcica        = $tipoEnsayo->CargarDurezaCalcica();
        // $this->varios               = $tipoEnsayo->CargarVarios();
        // $this->cloruros             = $tipoEnsayo->CargarCloruros();
        // $this->microbiologia        = $tipoEnsayo->CargarMicrobiologia();
        // $this->identMuestra         = $this->genIndicadores($this->muestras);

        set_time_limit(0);
    }

    public function lista()
    {
        $formato = new Formato();

        $this->formatos = $formato->find('estado<4', 'order: id desc');
    }

    public function lista_reporte($cliente_id=0)
    {
        $formato = new Formato();

        if($cliente_id<>0){
            $this->formatos = $formato->find("cliente_id=$cliente_id AND estado=4", 'order: id desc');
        }else{
            $this->formatos = $formato->find('estado=4', 'order: id desc');
        }
    }

    public function genIndicadores($muestras)
    {
        $t      = 1;
        $c      = 1;
        $r      = 1;
        $result = array();

        foreach ($muestras as $ms) {
            $index = 1;

            switch ($ms->getTipomatrizanalizada()->abrv) {
              case 'T':
                  $index = $t;
                  $t++;
                  break;
              case 'C':
                  $index = $c;
                  $c++;
                  break;
              case 'R':
                  $index = $r;
                  $r++;
                  break;
            }

            $result[] = $ms->getTipomatrizanalizada()->abrv.$index;
        }

        return $result;
    }

    public function guardar_memoria()
    {
        if (Input::post('muestra_id')) {
            $mmc = new Muestramemoriacalculo();

            $mmc->muestra_id    = Input::post('muestra_id');
            $mmc->valor1        = Input::post('valor1');
            $mmc->valor2        = Input::post('valor2');
            $mmc->valor3        = Input::post('valor3');
            $mmc->valor4        = Input::post('valor4');
            $mmc->valor5        = Input::post('valor5');
            $mmc->resultado     = Input::post('resultado');
            $mmc->tipoensayo_id = Input::post('tipoensayo_id');

            if ($mmc->create()) {
                View::select(null, null);
                View::render(null, null);
            }
        }
    }

    public function exportarFormato($id)
    {
        $formato = new Formato();
        $formato = $formato->find_first("id=$id");

        if ($formato) {
            $this->formato = $formato;            
        }
    }

    private function generarFormato($sheet, $formato)
    {
        $ircas = Load::model('irca')->find();

        $sheet
            ->setCellValue("G9",   '2015/08/04')
            ->setCellValue("G10",  $formato->getCliente()->nombre)
            ->setCellValue("G11",  'PASTO')
            ->setCellValue("G12",  $formato->getEmpresatomadormuestra()->nombre)
            ->setCellValue("Q9",   $formato->codigo)
            ->setCellValue("Q10",  'NARIÑO')
            ->setCellValue("Q11",  $formato->getLugartomamuestra()->nombre)
            ->setCellValue("Q12",  $formato->getTomadormuestra()->nombre)

            ->setCellValue("AE9",  '2015/08/04')
            ->setCellValue("AE10", $formato->getCliente()->nombre)
            ->setCellValue("AE11", 'PASTO')
            ->setCellValue("AE12", $formato->getEmpresatomadormuestra()->nombre)
            ->setCellValue("AO9",  $formato->codigo)
            ->setCellValue("AO10", 'NARIÑO')
            ->setCellValue("AO11", $formato->getLugartomamuestra()->nombre)
            ->setCellValue("AO12", $formato->getTomadormuestra()->nombre);

        $numfilas1    = 15;
        $numcolumnas1 = 16;
        $numfilas2    = 15;
        $numcolumnas2 = 40;

        foreach ($formato->getMuestra() as $muestra) {
            if ($muestra->tipomatrizanalizada_id == 1) {
                $sheet
                    ->setCellValue("A$numfilas1", $muestra->tomamuestra_hora)
                    ->setCellValue("C$numfilas1", $muestra->tomamuestra_fecha)
                    ->setCellValue("G$numfilas1", $muestra->recepcionmuestra_hora)
                    ->setCellValue("I$numfilas1", $muestra->recepcionmuestra_fecha)
                    ->setCellValue("L$numfilas1", strtoupper($muestra->getTipomatrizanalizada()->nombre))
                    ->setCellValue("O$numfilas1", strtoupper($muestra->getTipomuestra()->nombre))
                    ->setCellValue("P$numfilas1", $muestra->codigomuestra)
                    ->setCellValue("R$numfilas1", strtoupper($muestra->getLugartomamuestra()->nombre))
                    ->setCellValue($this->columnsConfig[$numcolumnas1]["col"]."26", $muestra->codigomuestra)
                    ->setCellValue($this->columnsConfig[$numcolumnas1]["col"]."75", $this->calcularIrca($ircas, $muestra));

                $numfilas1    = $numfilas1 + 1;
                $numcolumnas1 = $numcolumnas1 + 1;
            } else {
                $sheet
                    ->setCellValue("Y$numfilas2", $muestra->tomamuestra_hora)
                    ->setCellValue("AA$numfilas2", $muestra->tomamuestra_fecha)
                    ->setCellValue("AE$numfilas2", $muestra->recepcionmuestra_hora)
                    ->setCellValue("AG$numfilas2", $muestra->recepcionmuestra_fecha)
                    ->setCellValue("AJ$numfilas2", strtoupper($muestra->getTipomatrizanalizada()->nombre))
                    ->setCellValue("AM$numfilas2", strtoupper($muestra->getTipomuestra()->nombre))
                    ->setCellValue("AN$numfilas2", $muestra->codigomuestra)
                    ->setCellValue("AP$numfilas2", strtoupper($muestra->getLugartomamuestra()->nombre))
                    ->setCellValue($this->columnsConfig[$numcolumnas2]["col"]."26", $muestra->codigomuestra);

                $numfilas2    = $numfilas2 + 1;
                $numcolumnas2 = $numcolumnas2 + 1;
            }
        }

        return $sheet;

        $sheet->removeRow(27, 48 - count($formato->getTempformatotipoensayo()));

        $numfilas1 = 27;

        foreach ($formato->getTempformatotipoensayo() as $tmp) {
            $val1 = $tmp->getTipoensayo()->nombre;
            $val2 = $formato->fechaemision;
            $val3 = $tmp->getTipoensayo()->getTecnicaanalitica()->nombre;
            $val4 = $tmp->getTipoensayo()->getMetodo()->nombre;
            $val5 = $tmp->getTipoensayo()->getUnidad()->nombre;
            $val6 = $tmp->getTipoensayo()->limitedeteccion;

            $sheet
                ->setCellValue("A$numfilas1", "$val1")
                ->setCellValue("E$numfilas1", "$val2")
                ->setCellValue("F$numfilas1", "$val3")
                ->setCellValue("J$numfilas1", "$val4")
                ->setCellValue("K$numfilas1", "$val5")
                ->setCellValue("M$numfilas1", "$val6")

                ->setCellValue("Y$numfilas1", "$val1")
                ->setCellValue("AC$numfilas1", "$val2")
                ->setCellValue("AD$numfilas1", "$val3")
                ->setCellValue("AH$numfilas1", "$val4")
                ->setCellValue("AI$numfilas1", "$val5")
                ->setCellValue("AK$numfilas1", "$val6");

            $numcolumnas1 = 16;
            $numcolumnas2 = 40;

            foreach ($formato->getMuestra() as $muestra) {
                $memoria = $this->ubicarMuestraMemoria($muestra->getMuestramemoriacalculo(), $tmp->tipoensayo_id);
                switch ($tmp->tipoensayo_id) {
                    case 5:
                        $valor = $memoria->valor1;
                        break;
                    case 21:
                        $valor = $memoria->valor2;
                        break;
                    case 29:
                        $valor = $memoria->valor3;
                        break;
                    default:
                        $valor = $memoria->resultado;
                        break;
                }

                if ($muestra->tipomatrizanalizada_id == 1) {
                    $sheet
                        ->setCellValue($this->columnsConfig[$numcolumnas1]["col"]."$numfilas1", $valor);
                    $numcolumnas1 = $numcolumnas1 + 1;
                } else {
                    $sheet
                        ->setCellValue($this->columnsConfig[$numcolumnas2]["col"]."$numfilas1", $valor);
                    $numcolumnas2 = $numcolumnas2 + 1;
                }
            }

            $numfilas1 = $numfilas1 + 1;
        }

        return $sheet;
    }

    private function ubicarMuestraMemoria($memorias, $tipoensayo_id)
    {
        $memoria = null;

        foreach ($memorias as $mem) {
            if ($mem->tipoensayo_id == $tipoensayo_id) {
                $memoria = $mem;
                break;
            }
        }

        return $memoria;
    }

    private function calcularIrca($ircas, $muestra)
    {
        $ptoRiesgo   = 0;
        $totalRiesgo = 0;

        foreach ($ircas as $irca) {
            $totalRiesgo = $totalRiesgo + $puntajeriesgo;
            foreach ($muestra->getMuestramemoriacalculo() as $mem) {
                if ($mem->tipoensayo_id == $irca->tipoensayo_id) {
                    if (!($mem->resultado >= $irca->limiteinferior && $mem->resultado <= $irca->limitesuperior)) {
                        $ptoRiesgo = $ptoRiesgo + $irca->puntajeriesgo;
                    }
                }
            }
        }

        return $ptoRiesgo / $totalRiesgo;
    }

    public function actualizar_estado()
    {
        $formato = Load::model('formato')->find($_POST['formato_id']);

        if ($formato) {
            $usuario_id     = $_POST['usuario_id'];
            $tipousuario_id = $_POST['tipousuario_id'];

            if ($formato->estado == 1 && $tipousuario_id == 1) {
                $formato->estado = 2;
            } else if ($formato->estado == 2 && $tipousuario_id == 1) {
                if (!$formato->usuario_id_1) {
                    $formato->usuario_id_1 = $usuario_id;
                } else if ($formato->usuario_id_1 != $usuario_id) {
                    $formato->usuario_id_2 = $usuario_id;
                    $formato->estado = 3;
                }
            } else if ($formato->estado == 3 && $tipousuario_id == 3) {
                $formato->estado = 4;
            }

            $formato->save();
        }

        View::template(null);
    }

    public function reporte_promedio()
    {
        $curYear = date('Y');
        $years   = array();
        $months  = array(
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        );

        for ($i=2010; $i <= $curYear; $i++) {
            $years[] = $i;
        }

        $this->years       = $years;
        $this->months      = $months;
        $this->tipoReporte = 1;
        $this->titulo      = "Reporte promedio mes";
    }

    public function reporte_sui()
    {
        $curYear = date('Y');
        $years   = array();
        $months  = array(
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        );

        for ($i=2010; $i <= $curYear; $i++) {
            $years[] = $i;
        }

        $this->years       = $years;
        $this->months      = $months;
        $this->tipoReporte = 2;
        $this->titulo      = "Reporte SUI Red mes";

        View::select('reporte_promedio');
    }

    public function reporte_gen()
    {
        if ($_POST['tipo-reporte']) {
            View::select($_POST['tipo-reporte'] == 1 ? 'reporte_promedio_gen' : 'reporte_sui_gen');
            $month = $_POST['month'] + 1;
            $year  = $_POST['year'] + 2010;

            $fechaini = "$year-".(strlen("0".$month)   > 2 ? $month   : "0".$month)."-01";
            $fechafin = "$year-".(strlen("0".$month+1) > 2 ? $month+1 : "0".($month+1))."-01";

            $this->formatos = Load::model('formato')->find("tipocliente_id=1 AND estado=4 AND fechaemision>=$fechaini AND fechaemision<$fechafin");
        }
    }
}
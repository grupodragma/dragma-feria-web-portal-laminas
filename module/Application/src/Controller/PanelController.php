<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;

class PanelController extends AbstractActionController {

    protected $serviceManager;
    protected $objDistritosTable;
    protected $objTipoHabitacionTable;
    protected $objNumeroHabitacionTable;
    protected $objRangoPreciosTable;
    protected $objEtapaTable;
    protected $objProductosTable;
    protected $objEmpresasTable;
    protected $objExpositoresTable;
    protected $objPromocionesTable;
    protected $objPlanosTable;
    protected $objPortalCorreosTable;
    protected $objMailSender;
    protected $objBannerTable;
    protected $objBancosTable;

    public function __construct($serviceManager, $objDistritosTable, $objTipoHabitacionTable, $objNumeroHabitacionTable, $objRangoPreciosTable, $objEtapaTable, $objProductosTable, $objEmpresasTable, $objExpositoresTable, $objPromocionesTable, $objPlanosTable, $objPortalCorreosTable, $objMailSender, $objBannerTable, $objBancosTable) {
        $this->serviceManager = $serviceManager;
        $this->objDistritosTable = $objDistritosTable;
        $this->objTipoHabitacionTable = $objTipoHabitacionTable;
        $this->objNumeroHabitacionTable = $objNumeroHabitacionTable;
        $this->objRangoPreciosTable = $objRangoPreciosTable;
        $this->objEtapaTable = $objEtapaTable;
        $this->objProductosTable = $objProductosTable;
        $this->objEmpresasTable = $objEmpresasTable;
        $this->objExpositoresTable = $objExpositoresTable;
        $this->objPromocionesTable = $objPromocionesTable;
        $this->objPlanosTable = $objPlanosTable;
        $this->objPortalCorreosTable = $objPortalCorreosTable;
        $this->objMailSender = $objMailSender;
        $this->objBannerTable = $objBannerTable;
        $this->objBancosTable = $objBancosTable;
    }
    
    public function indexAction() {
        $this->layout()->setTemplate('layout/panel');
        return new ViewModel();
    }
    public function proyectoAction() {
        $this->layout()->setTemplate('layout/panel');
        $hash_url = $this->params()->fromRoute('hash_url', '');
        //Validar si existe proyecto
        $dataProyecto = $this->objProductosTable->obtenerDatoProductos(['hash_url' => $hash_url]);
        if(!$dataProyecto){
            $this->getResponse()->setStatusCode(404);
            return;
        }
        //Datos
        $dataEmpresa = $this->objEmpresasTable->obtenerDatoEmpresas(['idempresas'=> $dataProyecto['idempresas']]);
        $dataExpositor = $this->objExpositoresTable->obtenerDatoExpositores(['idexpositores'=> $dataEmpresa['idexpositores']]);
        $dataPromociones = $this->objPromocionesTable->obtenerDatosPromocionesPorProyecto($dataProyecto['idproductos']);
        $dataProyectosSimilares = $this->objProductosTable->obtenerProyectosSimilares($dataProyecto['iddistritos'], $dataProyecto['idproductos']);
        $dataPlanos = $this->objPlanosTable->obtenerDatosPlanosPorProyecto($dataProyecto['idproductos']);
        $data = [
            'tipoHabitaciones'=> $this->objTipoHabitacionTable->obtenerTipoHabitacion(),
            'distritos'=> $this->objDistritosTable->obtenerDistritos(),
            'numeroHabitaciones'=> $this->objNumeroHabitacionTable->obtenerNumeroHabitacion(),
            'rangoPrecios'=> $this->objRangoPreciosTable->obtenerRangoPrecios(),
            'etapas'=> $this->objEtapaTable->obtenerEtapa(),
            'proyecto'=> $dataProyecto,
            'empresa'=> $dataEmpresa,
            'expositor'=> $dataExpositor,
            'promociones'=> $dataPromociones,
            'proyectosSimilares'=> $dataProyectosSimilares,
            'planos'=> $dataPlanos,
            'filtroOpciones'=> $this->objPlanosTable->filtrarOpcionesPlanos($dataPlanos)
        ];
        //print_r($data['filtroOpciones']);
        //Respuesta
        return new ViewModel($data);
    }
    public function busquedaProyectosAction() {
        $this->layout()->setTemplate('layout/panel');
        $filtrosSeleccionados = $this->params()->fromQuery();
        $data = [
            'tipoHabitaciones'=> $this->objTipoHabitacionTable->obtenerTipoHabitacion(),
            'distritos'=> $this->objDistritosTable->obtenerDistritos(),
            'numeroHabitaciones'=> $this->objNumeroHabitacionTable->obtenerNumeroHabitacion(),
            'rangoPrecios'=> $this->objRangoPreciosTable->obtenerRangoPrecios(),
            'etapas'=> $this->objEtapaTable->obtenerEtapa(),
            'filtrosSeleccionados'=> $filtrosSeleccionados,
            'proyectosFiltrados'=> $this->objProductosTable->obtenerProyectosFiltrados($filtrosSeleccionados),
            'banner'=> $this->objBannerTable->obtenerPosicionBannerGeneralPorPagina('buscador')
        ];
        return new ViewModel($data);
    }
    public function enviarCorreoAction(){
        $accion = $this->params()->fromPost('accion');
        $id = $this->params()->fromPost('id');
        $data = [];
        $pathToFile = null;
        $archivoAdjunto = null;
        $rutaDocumento = null;
        $correoPara = null;
        
        //Obtener plantilla correos
        $dataPlantillaCorreo = $this->objPortalCorreosTable->obtenerDatosPlantillaCorreo(1, $accion);
        if(!$dataPlantillaCorreo){
            return $this->jsonZF(['result'=>'success']);
        }

        switch($accion){
            case 'promocion':
                $data = $this->objPromocionesTable->obtenerDatoPromociones(['idpromociones'=> $id]);
                $rutaDocumento = $this->layout()->url_backend."/promociones/documentos";
                if($data['tipo_enlace'] == 'PDF' && $data['hash_pdf'] != null){
                    $pathToFile = $rutaDocumento."/".$data['hash_pdf'];
                    $archivoAdjunto = $data['nombre_pdf'];
                }
                $correoPara = "freedemou@gmail.com"; //$this->sessionContainer['correo'];
            break;
            default:
            //code
            break;
        }

        if(!empty($data)){
            $mailDatos = [
                'accion'=> $accion,
                'informacion'=> $data,
                'visitante'=> $this->layout()->datosUsuario,
                'contenidoCorreo'=> $dataPlantillaCorreo['contenidoCorreo']
            ];
            $this->objMailSender->sendMail($correoPara,$dataPlantillaCorreo['correoTitulo'],$mailDatos,$accion,$pathToFile,$archivoAdjunto,$dataPlantillaCorreo['correoCopia'],$this->layout()->portal['nombre']);  
        }
        
        return $this->jsonZF(['result'=>'success']);
    }

    private function jsonZF($data){
        return new JsonModel($data);
    }

    public function calculaCreditoAction() {
        $this->layout()->setTemplate('layout/panel');
        $idbancos = $this->params()->fromRoute('idbancos', '0');
        $dataBanco = $this->objBancosTable->obtenerDatoBancos(['idbancos'=>$idbancos]);
        if(!$dataBanco){
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $dataBanco['cuota_inicial_porcentaje'] = explode(",", $dataBanco['cuota_inicial_porcentaje']);
        $dataBanco['plazo_credito_hipotecario'] = explode(",", $dataBanco['plazo_credito_hipotecario']);
        //print_r($dataBanco);

        $data = [
            'banco'=> $dataBanco
        ];
        return new ViewModel($data);
    }

    public function cotizarAhoraAction() {
        $this->layout()->setTemplate('layout/panel');
        $data = [
            
        ];
        return new ViewModel($data);
    }

    public function reservarAction() {
        $this->layout()->setTemplate('layout/panel');
        $data = [
            
        ];
        return new ViewModel($data);
    }

    public function inmobiliariasAction() {
        $this->layout()->setTemplate('layout/panel');
        $pagina = $this->params()->fromRoute('pagina', '1');
        $busqueda = $this->params()->fromQuery('q');
        if(!(int)$pagina){
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $totalPorPagina = 6;
        $offset = ($pagina-1) * $totalPorPagina;
        $totalRegistros = count($this->objEmpresasTable->obtenerEmpresasPaginacion(null, null, false, $busqueda));
        $totalPaginas = ceil($totalRegistros / $totalPorPagina);
        $dataInmobiliarias = $this->objEmpresasTable->obtenerEmpresasPaginacion($offset, $totalPorPagina, true, $busqueda);
        $data = [
            'totalPorPagina'=> $totalPorPagina,
            'totalRegistros'=> $totalRegistros,
            'totalPaginas'=> $totalPaginas,
            'pagina'=> $pagina,
            'inmobiliarias'=> $dataInmobiliarias,
            'banner'=> $this->objBannerTable->obtenerPosicionBannerGeneralPorPagina('inmobiliaria'),
            'busqueda'=> $busqueda
        ];
        //print_r($data['inmobiliarias']);
        return new ViewModel($data);
    }

}

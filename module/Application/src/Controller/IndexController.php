<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    protected $serviceManager;
    protected $objFeriasTable;
    protected $objPaginasFeriasTable;
    protected $objPaginasTable;
    protected $objVisitantesTable;
    protected $sessionContainer;
    protected $objSeoTable;
    protected $secuencia;
    protected $objPortalTable;
    protected $objBannerTable;
    protected $objProductosTable;
    protected $objPortalBannerTable;
    protected $objDistritosTable;
    protected $objTipoHabitacionTable;
    protected $objNumeroHabitacionTable;
    protected $objRangoPreciosTable;
    protected $objEtapaTable;

    public function __construct(
        $serviceManager,
        $objFeriasTable,
        $objPaginasFeriasTable,
        $objPaginasTable,
        $objVisitantesTable,
        $objSeoTable,
        $objPortalTable,
        $objBannerTable,
        $objProductosTable,
        $objPortalBannerTable,
        $objDistritosTable,
        $objTipoHabitacionTable,
        $objNumeroHabitacionTable,
        $objRangoPreciosTable,
        $objEtapaTable
    ) {
        $this->serviceManager = $serviceManager;
        $this->objFeriasTable = $objFeriasTable;
        $this->objPaginasFeriasTable = $objPaginasFeriasTable;
        $this->objPaginasTable = $objPaginasTable;
        $this->objVisitantesTable = $objVisitantesTable;
        $this->sessionContainer = $this->serviceManager->get('DatosSession')->datosUsuario;
        $this->objSeoTable = $objSeoTable;
        $this->secuencia = $this->layout()->menuSecuencia;
        $this->objPortalTable = $objPortalTable;
        $this->objBannerTable = $objBannerTable;
        $this->objProductosTable = $objProductosTable;
        $this->objPortalBannerTable = $objPortalBannerTable;
        $this->objDistritosTable = $objDistritosTable;
        $this->objTipoHabitacionTable = $objTipoHabitacionTable;
        $this->objNumeroHabitacionTable = $objNumeroHabitacionTable;
        $this->objRangoPreciosTable = $objRangoPreciosTable;
        $this->objEtapaTable = $objEtapaTable;
    }

    public function indexAction() {
        $data = [
            'home' => $this->objSeoTable->obtenerSeoFeria($this->layout()->feria['idferias'] ?? null, 19) ?: [],
            'fondoPrincipalProgramada'=> $this->objPortalTable->obtenerFondoPrincipalActualProgramada(),
            'banner'=> $this->objBannerTable->obtenerPosicionBannerGeneralPorPagina('home'),
            'proyectosMasDestacados'=> $this->objProductosTable->obtenerProyectosDestacados(),
            'proyectosMapaGoogle'=> json_encode($this->objProductosTable->obtenerProductosMapaGoogle()),
            'tipoHabitaciones'=> $this->objTipoHabitacionTable->obtenerTipoHabitacion(),
            'distritos'=> $this->objDistritosTable->obtenerDistritos(),
            'numeroHabitaciones'=> $this->objNumeroHabitacionTable->obtenerNumeroHabitacion(),
            'rangoPrecios'=> $this->objRangoPreciosTable->obtenerRangoPrecios(),
            'etapas'=> $this->objEtapaTable->obtenerEtapa()
        ];
        //print_r($data['banner']);
        //die;
        return new ViewModel($data);
    }
}

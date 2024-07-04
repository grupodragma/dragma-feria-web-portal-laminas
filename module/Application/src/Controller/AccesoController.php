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
use Application\Model\AccesoTable;

class AccesoController extends AbstractActionController {

    private $authManager;
    protected $objVisitantesTable;
    protected $objFeriasTable;
    protected $objMailSender;
    protected $objExpositoresTable;
    protected $objFeriasCorreosTable;

    public function __construct( $authManager, $objVisitantesTable, $objFeriasTable, $objMailSender, $objExpositoresTable, $objFeriasCorreosTable) {
        $this->authManager = $authManager;
        $this->objVisitantesTable = $objVisitantesTable;
        $this->objFeriasTable = $objFeriasTable;
        $this->objMailSender = $objMailSender;
        $this->objExpositoresTable = $objExpositoresTable;
        $this->objFeriasCorreosTable = $objFeriasCorreosTable;
    }
    
    public function loginAction() {
        $datosFormulario = $this->params()->fromPost();
        $numeroDocumento = @trim($datosFormulario['dni']);

        if(empty($datosFormulario))return new JsonModel(['result'=>'error']);

        $datosFormulario['idferias'] = $this->layout()->feria['idferias'];
        $datosFormulario['numero_documento'] = $numeroDocumento;
        $datosFormulario['contrasena'] = md5($numeroDocumento);
        $datosFormulario['fecha_registro_web'] = date('Y-m-d H:i:s');
        $datosFormulario['fecha_creacion'] =  date('Y-m-d H:i:s');
        $datosFormulario['fecha_ultima_sesion'] = date('Y-m-d H:i:s');
        
        unset($datosFormulario['dni']);

        $dataUsuario = $this->obtenerDatosUsuario($numeroDocumento);
        $resultStatus = $this->validarExisteUsuario($numeroDocumento);

        if ($resultStatus == 'SUCCESS') {
            unset($datosFormulario['idferias']);
            unset($datosFormulario['fecha_creacion']);
            unset($datosFormulario['numero_documento']);
            unset($datosFormulario['contrasena']);
            if(!isset($datosFormulario['condicion']))unset($datosFormulario['condicion']);
            if($dataUsuario['fecha_registro_web'] != '')unset($datosFormulario['fecha_registro_web']);
            if($dataUsuario['tipo'] === 'V'){
                $datosActualizar = $this->validarCamposActualizar($datosFormulario);
                $this->objVisitantesTable->actualizarDatosVisitantes($datosActualizar, $dataUsuario['idvisitantes']);
            }
            unset($dataUsuario['contrasena']);
            return new JsonModel(['result'=>'success', 'usuario'=> $dataUsuario]);
        } else if ($resultStatus == 'BANNED'){
            return new JsonModel(['result'=>'excess_error']);
        } else if ($resultStatus == 'NOACTIVATE'){
            return new JsonModel(['result'=>'noactivate']);
        } else if ($resultStatus == 'CREDENTIAL_INVALID'){
            /******* ENVIAR CORREO PARA VISITANTES NUEVOS [INICIO] *******/
            $plantillaCorreo = "visitante";
            $dataPlantillaCorreo = $this->objFeriasCorreosTable->obtenerDatosPlantillaCorreo($this->layout()->feria['idferias'], $plantillaCorreo);
            if($dataPlantillaCorreo){
                $mailDatos = [
                    'base_url'=> $this->layout()->base_url,
                    'visitante'=> $datosFormulario,
                    'feria'=> $this->layout()->feria,
                    'contenidoCorreo'=> $dataPlantillaCorreo['contenidoCorreo']
                ];
                $this->objMailSender->sendMail($datosFormulario['correo'],$dataPlantillaCorreo['correoTitulo'],$mailDatos,$plantillaCorreo,null,null,$dataPlantillaCorreo['correoCopia'],$this->layout()->feria['nombre']);
            }
            /******* ENVIAR CORREO PARA VISITANTES NUEVOS [FIN] *******/
            $this->objVisitantesTable->agregarVisitantes($datosFormulario);
            $dataUsuario = $this->objVisitantesTable->obtenerDatoVisitantes(['idferias'=> $this->layout()->feria['idferias'], 'numero_documento'=> $numeroDocumento]);
            $this->validarExisteUsuario($numeroDocumento);
            unset($dataUsuario['contrasena']);
            return new JsonModel(['result'=>'success', 'usuario'=> $dataUsuario]);
        } else {
            return new JsonModel(['result'=>'error']);
        }
    }

    private function validarCamposActualizar($datos){
        $campos = [];
        if(!empty($datos)){
            foreach($datos as $campo => $valor){
                if($valor != ''){
                    $campos[$campo] = $valor;
                }
            }
        }
        return $campos;
    }

    private function obtenerDatosUsuario($numeroDocumento){
        $dataUsuario = $this->objVisitantesTable->obtenerDatoVisitantes(['idferias'=> $this->layout()->feria['idferias'], 'numero_documento'=> $numeroDocumento]);
        if(!$dataUsuario){
            $dataUsuario = $this->objExpositoresTable->obtenerDatoExpositores(['idferias'=> $this->layout()->feria['idferias'], 'numero_documento'=> $numeroDocumento]);
        }
        return $dataUsuario;
    }

    private function validarExisteUsuario($numeroDocumento){
        $result = $this->authManager->login($numeroDocumento, $this->layout()->feria['idferias']);
        $estatus = $result->getMessages();
        return $estatus[0];
    }
    
    public function logoutAction() {
        $this->authManager->logout();
        return $this->redirect()->toUrl('/'.$this->layout()->idiomaSeleccionado);
    }

}
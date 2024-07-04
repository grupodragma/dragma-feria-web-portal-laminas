<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Laminas\Mvc\MvcEvent;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Authentication\Storage\Session as SessionStorage;
use Laminas\Authentication\AuthenticationService;
use Laminas\Session\SessionManager;
use Application\Service\AuthManager;
use Application\Service\Uploader;
use Application\Service\MailSender;
use Application\Services;
use Application\Helper\Tools;

class TranslateClient {

    function translate($text) {
        return ['text'=> $text];
    }

}

class Module implements ConfigProviderInterface
{

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap($e) {
        $application = $e->getParam('application');
        $services = $application->getServiceManager();
        $config = $services->get('Config');
        $viewModel = $application->getMvcEvent()->getViewModel();
        $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_ROUTE,
            function($event) use ($viewModel, $config) {
                $RouteMatch = $event->getRouteMatch();
                $idioma = $RouteMatch->getParam('lang', 'es');
                $viewModel->idiomaSeleccionado = $idioma;
                //Detected Language
                $viewModel->language = new TranslateClient();
            }
        );
        if(isset($_SERVER['HTTP_HOST'])){
            $protocol = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http';
            $viewModel->base_url = $protocol.'://'.$_SERVER['HTTP_HOST'];
            $viewModel->url_backend = $config['url_backend'];
            $viewModel->node_server = $config['node_server'];
        }
        $eventManager = $e->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        $sharedEventManager->attach(AbstractActionController::class, MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100);
        $sharedEventManager->attach('Laminas\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'onDispatchError'], 100);

        $sessionManager = $e->getApplication()->getServiceManager()->get(\Laminas\Session\SessionManager::class);
        $this->forgetInvalidSession($sessionManager);
    }

    private function forgetInvalidSession($sessionManager) {
        try {
            $sessionManager->start();
            return;
        } catch (\RuntimeException $e){}
        session_unset();
    }
    
    public function getServiceConfig() {
        return [
            'factories' => [
                Model\FeriasTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('ferias', $adapter);
                    $table = new Model\FeriasTable($tableGateway,$adapter);
                    return $table;
                },
                Model\PaginasFeriasTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('paginas_ferias', $adapter);
                    $table = new Model\PaginasFeriasTable($tableGateway,$adapter);
                    return $table;
                },
                Model\PaginasTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('paginas', $adapter);
                    $table = new Model\PaginasTable($tableGateway,$adapter);
                    return $table;
                },
                Model\ClientesTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('clientes', $adapter);
                    $table = new Model\ClientesTable($tableGateway,$adapter);
                    return $table;
                },
                Model\VisitantesTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('visitantes', $adapter);
                    $table = new Model\VisitantesTable($tableGateway,$adapter);
                    return $table;
                },
                Model\PlanesTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('planes', $adapter);
                    $table = new Model\PlanesTable($tableGateway,$adapter);
                    return $table;
                },
                Model\MenusTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('menus', $adapter);
                    $table = new Model\MenusTable($tableGateway,$adapter);
                    return $table;
                },
                Model\CronogramasTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('cronogramas', $adapter);
                    $table = new Model\CronogramasTable($tableGateway,$adapter);
                    return $table;
                },
                Model\ZonasTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('zonas', $adapter);
                    $table = new Model\ZonasTable($tableGateway,$adapter);
                    return $table;
                },
                Model\EmpresasTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('empresas', $adapter);
                    $table = new Model\EmpresasTable($tableGateway,$adapter);
                    return $table;
                },
                Model\ProductosTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGatewayProductosImagenes = $container->get(Model\ProductosImagenesTable::class);
                    $tableGateway = new TableGateway('productos', $adapter);
                    $table = new Model\ProductosTable($tableGateway,$tableGatewayProductosImagenes);
                    return $table;
                },
                Model\PaginasStandTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('paginas_stand', $adapter);
                    $table = new Model\PaginasStandTable($tableGateway,$adapter);
                    return $table;
                },
                Model\OfertasTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('ofertas', $adapter);
                    $table = new Model\OfertasTable($tableGateway,$adapter);
                    return $table;
                },
                Model\ExpositoresTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('expositores', $adapter);
                    $table = new Model\ExpositoresTable($tableGateway,$adapter);
                    return $table;
                },
                Model\ExpositoresProductosTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('expositores_productos', $adapter);
                    $table = new Model\ExpositoresProductosTable($tableGateway,$adapter);
                    return $table;
                },
                Model\PaginasZonasTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('paginas_zonas', $adapter);
                    $table = new Model\PaginasZonasTable($tableGateway,$adapter);
                    return $table;
                },
                Model\StandGaleriaTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('stand_galeria', $adapter);
                    $table = new Model\StandGaleriaTable($tableGateway,$adapter);
                    return $table;
                },
                Model\StandTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('stand', $adapter);
                    $table = new Model\StandTable($tableGateway,$adapter);
                    return $table;
                },
                Model\PromocionesTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('promociones', $adapter);
                    $table = new Model\PromocionesTable($tableGateway,$adapter);
                    return $table;
                },
                Model\ExpositoresTarjetasTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('expositores_tarjetas', $adapter);
                    $table = new Model\ExpositoresTarjetasTable($tableGateway,$adapter);
                    return $table;
                },
                Model\ConferenciasTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('conferencias', $adapter);
                    $table = new Model\ConferenciasTable($tableGateway,$adapter);
                    return $table;
                },
                Model\UsuarioEventosTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('usuario_eventos', $adapter);
                    $table = new Model\UsuarioEventosTable($tableGateway,$adapter);
                    return $table;
                },
                Model\BuscadorTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('buscador', $adapter);
                    $table = new Model\BuscadorTable($tableGateway,$adapter);
                    return $table;
                },
                Model\BancosTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('bancos', $adapter);
                    $table = new Model\BancosTable($tableGateway,$adapter);
                    return $table;
                },
                Model\ProductosImagenesTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('productos_imagenes', $adapter);
                    $table = new Model\ProductosImagenesTable($tableGateway,$adapter);
                    return $table;
                },
                Model\PlanosTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('planos', $adapter);
                    $table = new Model\PlanosTable($tableGateway,$adapter);
                    return $table;
                },
                Model\SeoTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('seo', $adapter);
                    return new Model\SeoTable($tableGateway,$adapter);
                },
                Model\PaginasBotonesTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('paginas_botones', $adapter);
                    return new Model\PaginasBotonesTable($tableGateway,$adapter);
                },
                Model\PortalCorreosTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('portal_correos', $adapter);
                    return new Model\PortalCorreosTable($tableGateway,$adapter);
                },
                Model\AgendaVirtualTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('agenda_virtual', $adapter);
                    return new Model\AgendaVirtualTable($tableGateway,$adapter);
                },
                Model\PortalTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('portal', $adapter);
                    return new Model\PortalTable($tableGateway,$adapter);
                },
                Model\BannerTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('banner', $adapter);
                    $productosTable = $container->get(Model\ProductosTable::class);
                    $bancosTable = $container->get(Model\BancosTable::class);
                    $portalBannerTable = $container->get(Model\PortalBannerTable::class);
                    return new Model\BannerTable($tableGateway,$productosTable,$bancosTable,$portalBannerTable);
                },
                Model\PortalBannerTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('portal_banner', $adapter);
                    return new Model\PortalBannerTable($tableGateway,$adapter);
                },
                Model\DistritosTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('distritos', $adapter);
                    $table = new Model\DistritosTable($tableGateway,$adapter);
                    return $table;
                },
                Model\TipoHabitacionTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('tipo_habitacion', $adapter);
                    $table = new Model\TipoHabitacionTable($tableGateway,$adapter);
                    return $table;
                },
                Model\NumeroHabitacionTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('numero_habitacion', $adapter);
                    $table = new Model\NumeroHabitacionTable($tableGateway,$adapter);
                    return $table;
                },
                Model\RangoPreciosTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('rango_precios', $adapter);
                    $table = new Model\RangoPreciosTable($tableGateway,$adapter);
                    return $table;
                },
                Model\EtapaTable::class => function($container){
                    $adapter = $container->get(AdapterInterface::class);
                    $tableGateway = new TableGateway('etapa', $adapter);
                    $table = new Model\EtapaTable($tableGateway,$adapter);
                    return $table;
                },
                \Laminas\Authentication\AuthenticationService::class => function($container) {
                    $sessionManager = $container->get(\Laminas\Session\SessionManager::class);
                    $authStorage = new SessionStorage('Zend_Auth', 'session', $sessionManager);
                    $authAdapter = $container->get(Service\AuthAdapter::class);
                    return new AuthenticationService($authStorage, $authAdapter);
                },
                Service\AuthAdapter::class => function($container) {
                    $sessionContainer = $container->get('DatosSession');
                    return new Service\AuthAdapter(
                        $container->get(Model\VisitantesTable::class),
                        $sessionContainer,
                        $container->get(Model\ExpositoresTable::class),
                        $container->get(Model\UsuarioEventosTable::class)
                    );
                },
                Service\AuthManager::class => function($container) {
                    $authenticationService = $container->get(\Laminas\Authentication\AuthenticationService::class);
                    $sessionManager = $container->get(SessionManager::class);
                    return new AuthManager($authenticationService, $sessionManager);
                },
                Service\MailSender::class => function($container) {
                    return new MailSender($container);
                },
                Helper\Tools::class => function($container) {
                    return new Tools($container);
                }
            ],
        ];
    }

    public function getControllerConfig() {
        return [
            'factories' => [
                Controller\IndexController::class => function($container) {
                    return new Controller\IndexController(
                        $container,
                        $container->get(Model\FeriasTable::class),
                        $container->get(Model\PaginasFeriasTable::class),
                        $container->get(Model\PaginasTable::class),
                        $container->get(Model\VisitantesTable::class),
                        $container->get(Model\SeoTable::class),
                        $container->get(Model\PortalTable::class),
                        $container->get(Model\BannerTable::class),
                        $container->get(Model\ProductosTable::class),
                        $container->get(Model\PortalBannerTable::class),
                        $container->get(Model\DistritosTable::class),
                        $container->get(Model\TipoHabitacionTable::class),
                        $container->get(Model\NumeroHabitacionTable::class),
                        $container->get(Model\RangoPreciosTable::class),
                        $container->get(Model\EtapaTable::class)
                    );
                },
                Controller\AccesoController::class => function($container) {
                    return new Controller\AccesoController(
                        $container->get(Service\AuthManager::class),
                        $container->get(Model\VisitantesTable::class),
                        $container->get(Model\FeriasTable::class),
                        $container->get(Service\MailSender::class),
                        $container->get(Model\ExpositoresTable::class),
                        $container->get(Model\PortalCorreosTable::class)
                    );
                },
                Controller\PanelController::class => function($container) {
                    return new Controller\PanelController(
                        $container,
                        $container->get(Model\DistritosTable::class),
                        $container->get(Model\TipoHabitacionTable::class),
                        $container->get(Model\NumeroHabitacionTable::class),
                        $container->get(Model\RangoPreciosTable::class),
                        $container->get(Model\EtapaTable::class),
                        $container->get(Model\ProductosTable::class),
                        $container->get(Model\EmpresasTable::class),
                        $container->get(Model\ExpositoresTable::class),
                        $container->get(Model\PromocionesTable::class),
                        $container->get(Model\PlanosTable::class),
                        $container->get(Model\PortalCorreosTable::class),
                        $container->get(Service\MailSender::class),
                        $container->get(Model\BannerTable::class),
                        $container->get(Model\BancosTable::class)
                    );
                },
                Controller\ClienteController::class => function($container) {
                    return new Controller\ClienteController(
                        $container,
                        $container->get(Model\VisitantesTable::class),
                        $container->get(Model\FeriasTable::class),
                        $container->get(Model\ExpositoresTable::class),
                        $container->get(Model\AgendaVirtualTable::class),
                        $container->get(Service\MailSender::class),
                        $container->get(Model\PortalCorreosTable::class),
                        $container->get(Model\EmpresasTable::class),
                    );
                }
            ],
        ];
    }

    public function onDispatch(MvcEvent $event) {
        $this->InterfacePanel($event);
    }

    public function onDispatchError(MvcEvent $event){
        $this->InterfacePanel($event);
    }

    private function InterfacePanel($event){
        $application = $event->getParam('application');
        $viewModel = $application->getMvcEvent()->getViewModel();
        $container = $event->getApplication()->getserviceManager();
        $sessionContainer = $container->get('DatosSession');
        $config = $container->get('Config');
        $dataPortal = $container->get(Model\PortalTable::class)->obtenerDatoPortal(['hash_url'=> 'principal']);
        $dataPortal['config_formulario'] = ( $dataPortal['config_formulario'] != '' ) ? json_decode($dataPortal['config_formulario'], true) : [];
        $viewModel->portal = $dataPortal;
        $viewModel->datosUsuario = $sessionContainer->datosUsuario;
        $viewModel->listaIdiomas = [
            'es'=> 'Español',
            'en'=> 'Inglés',
            'pt'=> 'Portugués',
            'zh'=> 'Chino'
        ];
        $viewModel->simboloMoneda = [
            'D'=> '$',
            'S'=> 'S/'
        ];
        $viewModel->google_maps = $config['google']['maps'];
        $viewModel->menus = $container->get(Model\MenusTable::class)->obtenerMenus();
    }

}
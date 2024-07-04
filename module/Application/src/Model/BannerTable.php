<?php

namespace Application\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;

class BannerTable {
    protected $tableGateway;
    protected $objProductosTable;
    protected $objBancosTable;
    protected $objPortalBannerTable;
    public function __construct(TableGatewayInterface $tableGateway, $objProductosTable, $objBancosTable, $objPortalBannerTable) {
        $this->tableGateway = $tableGateway;
        $this->objProductosTable = $objProductosTable;
        $this->objBancosTable = $objBancosTable;
        $this->objPortalBannerTable = $objPortalBannerTable;
    }
    public function obtenerBanner(){
        $condiciones = [];
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT b.*, p.nombre AS producto, s.nombre AS segmento
        FROM banner b
        INNER JOIN productos p ON p.idproductos = b.idproductos
        INNER JOIN empresas e ON e.idempresas = p.idempresas
        LEFT JOIN segmentos s ON s.idsegmentos = e.idsegmentos";
        if( !empty($condiciones) )$sql .= " WHERE ".implode(" AND ", $condiciones);
        $sql .= " ORDER BY b.categoria, b.fecha_programa_inicio, b.fecha_programa_fin ASC";
        return $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
    }
    public function obtenerDatoBanner($where){
        $rowset = $this->tableGateway->select($where);
        return $rowset->current();
    }
    public function obtenerDatosBanner($where){
        $rowset = $this->tableGateway->select($where);
        return $rowset->toArray();
    }
    public function actualizarDatosBanner($data,$idbanner){
        $rowset = $this->tableGateway->update($data,["idbanner" => $idbanner]);
    }
    public function agregarBanner($data){
        $this->tableGateway->insert($data);
        return $this->tableGateway->lastInsertValue;
    }
    public function eliminarBanner($idbanner){
        $this->tableGateway->delete(["idbanner" => $idbanner]);
    }
    public function obtenerFiltroDatosBanner($start,$length,$search=null,$totalregistro=false){
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT * FROM banner";
        $sql .= " ORDER BY idbanner ASC";
        if(!$totalregistro)$sql .= " LIMIT {$start},{$length}";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $data;
    }
    public function validarRangoFechasBanner($fecha_inicio, $fecha_fin, $categoria){
        $condiciones = [];
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT *
        FROM(
            SELECT *
            FROM banner
            WHERE ( '{$fecha_inicio}' BETWEEN fecha_programa_inicio AND fecha_programa_fin) OR ('{$fecha_fin}' BETWEEN fecha_programa_inicio AND fecha_programa_fin)
        ) AS b
        WHERE b.categoria = '{$categoria}'";
        if(!empty($condiciones))$sql .= " WHERE ".implode(" AND ", $condiciones);
        return $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
    }
    public function obtenerFechaInicioFinBanner($categoria){
        $condiciones = [];
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT MIN(fecha_programa_inicio) AS fecha_inicio, MAX(fecha_programa_fin) AS fecha_fin FROM banner WHERE categoria ='{$categoria}'";
        if(!empty($condiciones))$sql .= " WHERE ".implode(" AND ", $condiciones);
        return $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->current();
    }
    public function obtenerBannerProgramaActual($hashbanner){
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT *
        FROM banner b
        INNER JOIN posicion_banner pb ON pb.idposicionbanner = b.idposicionbanner
        WHERE pb.hash_url = '{$hashbanner}' AND DATE(NOW()) BETWEEN fecha_programa_inicio AND fecha_programa_fin";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->current();
        if($data){
            //Obtener los datos para redireccionar el banner al proyecto o banco asociado
            $data['datos'] = $this->obtenerDatosElementoTablaPorCategoria($data['categoria'], $data['idtabla']);
        }
        return $data;
    }
    private function obtenerDatosElementoTablaPorCategoria($categoria, $idtabla){
        switch($categoria){
            case 'PROYECTO':
                return $this->objProductosTable->obtenerDatoProductos(['idproductos'=> $idtabla]);
                break;
            case 'BANCO':
                return $this->objBancosTable->obtenerDatoBancos(['idbancos'=> $idtabla]);
                break;
            default:
                return (object)[];
                break;
        }
    }
    public function obtenerPosicionBannerGeneralPorPagina($hashpagina){
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT pb.*, p.nombre AS pagina, p.hash_url AS pagina_hash_url
        FROM posicion_banner pb
        INNER JOIN paginas p ON p.idpaginas = pb.idpaginas
        WHERE p.hash_url = '{$hashpagina}'";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        $response = [];
        if(!empty($data)){
            foreach($data as $item){
                if($dataBannerActualProgramado = $this->obtenerBannerProgramaActual($item['hash_url'])){
                    $item['banner_programado'] = $dataBannerActualProgramado;
                }
                if($dataPortalBanner = $this->objPortalBannerTable->obtenerDatoPortalBanner(['idposicionbanner'=> $item['idposicionbanner']])){
                    $item['banner_principal'] = $dataPortalBanner;
                }
                $response[$item['hash_url']] = $item;
            }
        }
        //echo $sql;
        //die;
        return $response;
    }
}
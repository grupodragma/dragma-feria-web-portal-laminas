<?php

namespace Application\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;

class ExpositoresTable {
    protected $tableGateway;
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    public function obtenerExpositores(){
        $select = $this->tableGateway->getSql()->select();
        $select->order('idexpositores DESC');
        $rowset = $this->tableGateway->selectWith($select);
        return $rowset->toArray();
    }
    public function obtenerDatoExpositores($where){
        $rowset = $this->tableGateway->select($where);
        return $rowset->current();
    }
    public function actualizarDatosExpositores($data,$idexpositores){
        $rowset = $this->tableGateway->update($data,["idexpositores" => $idexpositores]);
    }
    public function agregarExpositores($data){
        $this->tableGateway->insert($data);
        return $this->tableGateway->lastInsertValue;
    }
    public function eliminarExpositores($idexpositores){
        $this->tableGateway->delete(["idexpositores" => $idexpositores]);
    }
    public function obtenerFiltroDatosExpositores($start,$length,$search=null,$totalregistro=false){
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT * FROM expositores";
        $sql .= " ORDER BY idexpositores ASC";
        if(!$totalregistro)$sql .= " LIMIT {$start},{$length}";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $data;
    }
    public function obtenerExpositoresPorIdFeria($idferias, $busqueda){
        $condiciones = [];
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT e.*, em.nombre AS empresa, em.orden AS empresa_orden, em.hash_url, z.idzonas, z.nombre AS zona, z.orden AS zona_orden
        FROM expositores e
        INNER JOIN empresas em ON em.idexpositores = e.idexpositores
        INNER JOIN zonas z ON z.idzonas = em.idzonas";
        if( $idferias != null ) $condiciones[] = "z.idferias = {$idferias}";
        if( $busqueda != null ) $condiciones[] = "e.nombres LIKE '%{$busqueda}%' OR e.apellido_paterno LIKE '%{$busqueda}%' OR e.apellido_materno LIKE '%{$busqueda}%'";
        if( !empty($condiciones) ) $sql .= " WHERE ".implode(" AND ", $condiciones);
        $sql .= " ORDER BY e.nombres ASC";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $data;
    }
}
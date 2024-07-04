<?php

namespace Application\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;

class PortalTable {
    protected $tableGateway;
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    public function obtenerPortal(){
        $select = $this->tableGateway->getSql()->select();
        $select->order('idportal DESC');
        $rowset = $this->tableGateway->selectWith($select);
        return $rowset->toArray();
    }
    public function obtenerDatoPortal($where){
        $rowset = $this->tableGateway->select($where);
        return $rowset->current();
    }
    public function obtenerDatosPortal($where){
        $rowset = $this->tableGateway->select($where);
        return $rowset->toArray();
    }
    public function actualizarDatosPortal($data,$idportal){
        $this->tableGateway->update($data,["idportal" => $idportal]);
    }
    public function agregarPortal($data){
        $this->tableGateway->insert($data);
        return $this->tableGateway->lastInsertValue;
    }
    public function eliminarPortal($idportal){
        $this->tableGateway->delete(["idportal" => $idportal]);
    }
    public function obtenerFiltroDatosPortal($start,$length,$search=null,$totalregistro=false){
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT * FROM portal";
        $sql .= " ORDER BY idportal ASC";
        if(!$totalregistro)$sql .= " LIMIT {$start},{$length}";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $data;
    }
    public function obtenerFondoPrincipalActualProgramada(){
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT *
        FROM portal
        WHERE DATE(NOW()) BETWEEN fondo_principal_prog_fecha_inicio AND fondo_principal_prog_fecha_fin
        ORDER BY fondo_principal_prog_fecha_inicio ASC
        LIMIT 1";
        return $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->current();
    }
}
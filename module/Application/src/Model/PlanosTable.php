<?php

namespace Application\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;

class PlanosTable {
    protected $tableGateway;
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    public function obtenerPlanos(){
        $select = $this->tableGateway->getSql()->select();
        $select->order('idplanos DESC');
        $rowset = $this->tableGateway->selectWith($select);
        return $rowset->toArray();
    }
    public function obtenerDatoPlanos($where){
        $rowset = $this->tableGateway->select($where);
        return $rowset->current();
    }
    public function obtenerDatosPlanos($where){
        $rowset = $this->tableGateway->select($where);
        return $rowset->toArray();
    }
    public function obtenerDatosPlanosPorProyecto($idproductos){
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT p.*, th.hash_url AS tipo_habitacion_hash_url, th.nombre AS tipo_habitacion, nh.hash_url AS numero_habitacion_hash_url, nh.nombre AS numero_habitacion
        FROM planos p
        LEFT JOIN tipo_habitacion th ON th.idtipohabitacion = p.idtipohabitacion
        LEFT JOIN numero_habitacion nh ON nh.idnumerohabitacion = p.idnumerohabitacion
        WHERE p.idproductos = {$idproductos}
        ORDER BY idplanos DESC";
        return $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
    }
    public function actualizarDatosPlanos($data,$idplanos){
        $rowset = $this->tableGateway->update($data,["idplanos" => $idplanos]);
    }
    public function agregarPlanos($data){
        $this->tableGateway->insert($data);
        return $this->tableGateway->lastInsertValue;
    }
    public function eliminarPlanos($idplanos){
        $this->tableGateway->delete(["idplanos" => $idplanos]);
    }
    public function obtenerFiltroDatosPlanos($start,$length,$search=null,$totalregistro=false){
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT * FROM planos";
        $sql .= " ORDER BY idplanos ASC";
        if(!$totalregistro)$sql .= " LIMIT {$start},{$length}";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $data;
    }
    public function filtrarOpcionesPlanos($data){
        $filtrosPlanos = [];
        if(!empty($data)){
            foreach ($data as $item) {
                if($item['tipo_habitacion_hash_url'] != ''){
                    $filtrosPlanos[] = [
                        'key'=> $item['tipo_habitacion_hash_url'],
                        'value'=> $item['tipo_habitacion']
                    ];
                }
                if($item['numero_habitacion_hash_url'] != ''){
                    $filtrosPlanos[] = [
                        'key'=> $item['numero_habitacion_hash_url'],
                        'value'=> $item['numero_habitacion']
                    ];
                }
            }
        }
        return array_unique($filtrosPlanos, SORT_REGULAR);
    }
}
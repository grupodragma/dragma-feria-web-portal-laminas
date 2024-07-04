<?php

namespace Application\Model;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\Sql\Select;

class ProductosTable {
    protected $tableGateway;
    protected $tableGatewayProductosImagenes;
    public function __construct(TableGatewayInterface $tableGateway, $tableGatewayProductosImagenes) {
        $this->tableGateway = $tableGateway;
        $this->tableGatewayProductosImagenes = $tableGatewayProductosImagenes;
    }
    public function obtenerProductos(){
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT p.*, e.nombre AS empresa FROM productos p
        LEFT JOIN empresas e ON e.idempresas = p.idempresas
        ORDER BY p.idproductos DESC";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $data;
    }
    public function buscarProductosPorFeria($idferias=null, $busqueda=null){
        $condiciones = [];
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT p.*, e.nombre AS empresa, e.orden AS empresa_orden, z.idzonas, z.nombre AS zona, z.orden AS zona_orden 
        FROM productos p
        LEFT JOIN empresas e ON e.idempresas = p.idempresas
        LEFT JOIN zonas z ON z.idzonas = e.idzonas";
        if( $idferias != null ) $condiciones[] = "z.idferias = {$idferias}";
        if( $busqueda != null ) $condiciones[] = "p.descripcion LIKE '%{$busqueda}%'";
        $condiciones[] = "p.buscador = 1";
        if( !empty($condiciones) ) $sql .= " WHERE ".implode(" AND ", $condiciones);
        $sql .= " ORDER BY p.nombre ASC";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $data;
    }
    public function obtenerProductosPorFeria($idferias=null){
        $condiciones = [];
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT p.*, e.nombre AS empresa, e.orden AS empresa_orden, z.idzonas, z.nombre AS zona, z.orden AS zona_orden 
        FROM productos p
        LEFT JOIN empresas e ON e.idempresas = p.idempresas
        LEFT JOIN zonas z ON z.idzonas = e.idzonas";
        if( $idferias != null ) $condiciones[] = "z.idferias = {$idferias}";
        $condiciones[] = "p.buscador = 1";
        if( !empty($condiciones) ) $sql .= " WHERE ".implode(" AND ", $condiciones);
        $sql .= " ORDER BY p.nombre ASC";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $data;
    }
    public function obtenerDatoProductos($where){
        $rowset = $this->tableGateway->select($where);
        $result = $rowset->current();
        if($result){
            $result['imagenes'] = $this->tableGatewayProductosImagenes->obtenerDatosProductosImagenes(['idproductos'=> $result['idproductos']]);
        }
        return $result;
    }
    public function obtenerDatosProductos($where){
        $rowset = $this->tableGateway->select($where);
        return $rowset->toArray();
    }
    public function obtenerDatosProductosImagenes($where){
        $rowset = $this->tableGateway->select($where);
        $data = $rowset->toArray();
        $response = [];
        if(!empty($data)){
            foreach($data as $item){
                $item['imagenes'] = $this->tableGatewayProductosImagenes->obtenerDatosProductosImagenes(['idproductos'=> $item['idproductos']]);
                $response[] = $item;
            }
        }
        return $response;
    }
    public function actualizarDatosProductos($data,$idproductos){
        $rowset = $this->tableGateway->update($data,["idproductos" => $idproductos]);
    }
    public function agregarProductos($data){
        $this->tableGateway->insert($data);
        return $this->tableGateway->lastInsertValue;
    }
    public function eliminarProductos($idproductos){
        $this->tableGateway->delete(["idproductos" => $idproductos]);
    }
    public function obtenerFiltroDatosProductos($start,$length,$search=null,$totalregistro=false){
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT * FROM productos";
        $sql .= " ORDER BY idproductos ASC";
        if(!$totalregistro)$sql .= " LIMIT {$start},{$length}";
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        return $data;
    }
    public function obtenerProyectosDestacados(){
        $condiciones = [];
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT p.*,
        e.nombre AS empresa, e.hash_logo AS empresa_logo,
        s.nombre AS segmento,
        exp.hash_foto AS expositor_foto,
        dist.nombre AS distrito,
        IF(st.hash_url = 'circular-portal', ps.configuracion, NULL) AS stand_configuracion
        FROM productos p
        INNER JOIN empresas e ON e.idempresas = p.idempresas
        LEFT JOIN segmentos s ON s.idsegmentos = e.idsegmentos
        LEFT JOIN expositores exp ON exp.idexpositores = e.idexpositores
        LEFT JOIN distritos dist ON dist.iddistritos = p.iddistritos
        LEFT JOIN paginas_stand ps ON ps.idempresas = e.idempresas
        LEFT JOIN stand_galeria sg ON sg.idstandgaleria = e.idstandgaleria
        LEFT JOIN stand st ON st.idstand = sg.idstand";
        $condiciones[] = "p.destacado = 1";
        if( !empty($condiciones) ) $sql .= " WHERE ".implode(" AND ", $condiciones);
        $sql .= " ORDER BY p.idproductos DESC";
        //echo $sql;
        //die;
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        $response = [];
        if(!empty($data)){
            foreach($data as $item){
                $item['stand_configuracion'] = ( $item['stand_configuracion'] != '') ? json_decode($item['stand_configuracion'], true) : [];
                $response[] = $item;
            }
        }
        return $response;
    }
    public function obtenerProyectos($totalregistro=null, $iddistritos=null){
        $condiciones = [];
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT p.*,
        e.nombre AS empresa, e.hash_logo AS empresa_logo,
        s.nombre AS segmento,
        exp.hash_foto AS expositor_foto,
        dist.nombre AS distrito,
        IF(st.hash_url = 'circular-portal', ps.configuracion, NULL) AS stand_configuracion,
        th.nombre AS tipoHabitacion,
        nh.nombre AS numeroHabitacion,
        et.nombre AS etapa
        FROM productos p
        INNER JOIN empresas e ON e.idempresas = p.idempresas
        LEFT JOIN segmentos s ON s.idsegmentos = e.idsegmentos
        LEFT JOIN expositores exp ON exp.idexpositores = e.idexpositores
        LEFT JOIN distritos dist ON dist.iddistritos = p.iddistritos
        LEFT JOIN paginas_stand ps ON ps.idempresas = e.idempresas
        LEFT JOIN stand_galeria sg ON sg.idstandgaleria = e.idstandgaleria
        LEFT JOIN stand st ON st.idstand = sg.idstand
        LEFT JOIN tipo_habitacion th ON th.idtipohabitacion = p.idtipohabitacion
        LEFT JOIN numero_habitacion nh ON nh.idnumerohabitacion = p.idnumerohabitacion
        LEFT JOIN etapa et ON et.idetapa = p.idetapa";
        if( $iddistritos != null ) $condiciones[] = "dist.iddistritos = {$iddistritos}";
        if( !empty($condiciones) ) $sql .= " WHERE ".implode(" AND ", $condiciones);
        $sql .= " ORDER BY p.idproductos DESC";
        if($totalregistro != null) $sql .= " LIMIT {$totalregistro}";
        //echo $sql;
        //die;
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        $response = [];
        if(!empty($data)){
            foreach($data as $item){
                $item['stand_configuracion'] = ( $item['stand_configuracion'] != '') ? json_decode($item['stand_configuracion'], true) : [];
                $response[] = $item;
            }
        }
        return $response;
    }
    public function obtenerProyectosSimilares($iddistritos, $idproductos){
        $data = $this->obtenerProyectos(null, $iddistritos);
        $response = [];
        if(!empty($data)){
            foreach($data as $item){
                if($item['idproductos'] == $idproductos)continue;
                $response[] = $item;
            }
        }
        return $response;
    }
    public function obtenerProductosMapaGoogle($totalregistro=null){
        $dataProyectos = $this->obtenerProyectos($totalregistro);
        //print_r($dataProyectos);
        $response = [];
        if(!empty($dataProyectos)){
            foreach($dataProyectos as $item){
                //Filtrar todos los proyectos que tienen ubicación en el mapa
                if(!$item['latitud'] || !$item['longitud'])continue;
                //Eliminar campos innecesarios
                if(isset($item['enlace_mapa']))unset($item['enlace_mapa']);
                if(isset($item['enlace_recorrido_virtual']))unset($item['enlace_recorrido_virtual']);
                if(isset($item['informacion']))unset($item['informacion']);
                //Respuesta datos
                $response[] = $item;
            }
        }
        return $response;
    }
    public function obtenerProyectosFiltrados($filtros){
        $condiciones = [];
        $adapter = $this->tableGateway->getAdapter();
        $sql = "SELECT p.*,
        e.nombre AS empresa, e.hash_logo AS empresa_logo,
        s.nombre AS segmento,
        exp.hash_foto AS expositor_foto,
        dist.nombre AS distrito,
        IF(st.hash_url = 'circular-portal', ps.configuracion, NULL) AS stand_configuracion,
        th.nombre AS tipoHabitacion,
        nh.nombre AS numeroHabitacion,
        et.nombre AS etapa
        FROM productos p
        INNER JOIN empresas e ON e.idempresas = p.idempresas
        LEFT JOIN segmentos s ON s.idsegmentos = e.idsegmentos
        LEFT JOIN expositores exp ON exp.idexpositores = e.idexpositores
        LEFT JOIN distritos dist ON dist.iddistritos = p.iddistritos
        LEFT JOIN paginas_stand ps ON ps.idempresas = e.idempresas
        LEFT JOIN stand_galeria sg ON sg.idstandgaleria = e.idstandgaleria
        LEFT JOIN stand st ON st.idstand = sg.idstand
        LEFT JOIN tipo_habitacion th ON th.idtipohabitacion = p.idtipohabitacion
        LEFT JOIN numero_habitacion nh ON nh.idnumerohabitacion = p.idnumerohabitacion
        LEFT JOIN etapa et ON et.idetapa = p.idetapa";
        if(!empty($filtros) && $this->obtenerCondicionFiltros($filtros)){
            $condiciones = $this->obtenerCondicionFiltros($filtros);
        }
        if(!empty($condiciones)){
            $sql .= " WHERE ".implode(" OR ", $condiciones);
            $sql .= " AND p.iddistritos != 0";
        } else {
            $sql .= " WHERE p.iddistritos != 0";
        }
        $sql .= " ORDER BY p.idproductos DESC";
        //echo $sql;
        //die;
        $data = $adapter->query($sql, $adapter::QUERY_MODE_EXECUTE)->toArray();
        $response = [];
        if(!empty($data)){
            foreach($data as $item){
                $item['stand_configuracion'] = ( $item['stand_configuracion'] != '') ? json_decode($item['stand_configuracion'], true) : [];
                $response[] = $item;
            }
        }
        return $response;
    }
    private function obtenerCondicionFiltros($filtros){
        $condiciones = [];
        if(isset($filtros['tipoHabitacion']) && $filtros['tipoHabitacion'] != ""){
            $tipoHabitacion = trim($filtros['tipoHabitacion']);
            $condiciones[] = "th.nombre LIKE '%{$tipoHabitacion}%'";
        }
        if(isset($filtros['distrito']) && $filtros['distrito'] != ""){
            $distrito = trim($filtros['distrito']);
            $condiciones[] = "dist.nombre LIKE '%{$distrito}%'";
        }
        if(isset($filtros['numeroHabitacion']) && $filtros['numeroHabitacion'] != ""){
            $numeroHabitacion = trim($filtros['numeroHabitacion']);
            $condiciones[] = "nh.nombre LIKE '%{$numeroHabitacion}%'";
        }
        if(isset($filtros['rangoPrecios']) && $filtros['rangoPrecios'] != ""){
            $rangoPrecios = trim($filtros['rangoPrecios']);
            list($precioMin, $precioMax) = explode(" a ", $rangoPrecios);
            $condiciones[] = "(p.precio_desde BETWEEN ".(double)$precioMin." AND ".(double)$precioMax.")";
        }
        if(isset($filtros['etapa']) && $filtros['etapa'] != ""){
            $etapa = trim($filtros['etapa']);
            $condiciones[] = "et.nombre LIKE '%{$etapa}%'";
        }
        return $condiciones;
    }
}
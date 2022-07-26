<?php


namespace Model;

use Model\ActiveRecord;

class Crias extends ActiveRecord {
    protected static $tabla = 'crias';
    protected static $columnasDB = ['id', 'nombre','peso','costo', 'identificador', 'proveedor', 'descripcion', 'url', 'propietarioId'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->peso = $args['peso'] ?? '';
        $this->costo = $args['costo'] ?? '';
        $this->identificador = $args['identificador'] ?? '';
        $this->proveedor = $args['proveedor'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? '';
    }

    public function validarProyecto() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre de la cría es Obligatoria';
        }
        if(!$this->peso) {
            self::$alertas['error'][] = 'El peso de la cría es Obligatoria';
        }
        if(!$this->costo) {
            self::$alertas['error'][] = 'El costo de la cría es Obligatoria';
        }
        if(!$this->identificador) {
            self::$alertas['error'][] = 'El identificador de la cría es Obligatoria';
        }
        if(!$this->proveedor) {
            self::$alertas['error'][] = 'El proveedor de la cría es Obligatoria';
        }
        if(!$this->descripcion) {
            self::$alertas['error'][] = 'El descripcion de la cría es Obligatoria';
        }
        return self::$alertas;
    }
}
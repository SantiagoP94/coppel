<?php

namespace Model;

class Datos extends ActiveRecord {
    protected static $tabla = 'datos';
    protected static $columnasDB = ['id', 'frecuenciaC', 'frecuenciaR', 'presionS', 'tempe', 'estado', 'criaId'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->frecuenciaC = $args['frecuenciaC'] ?? '';
        $this->frecuenciaR = $args['frecuenciaR'] ?? '';
        $this->presionS = $args['presionS'] ?? '';
        $this->tempe = $args['tempe'] ?? '';
        $this->estado = $args['estado'] ?? 0;
        $this->criaId = $args['criaId'] ?? '';
    }
}
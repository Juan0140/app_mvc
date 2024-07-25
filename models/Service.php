<?php
namespace Model;

use Model\ActiveRecord;

class Service extends ActiveRecord
{
    protected static $tabla = "services";
    protected static $columnasDB = ['id', 'name', 'price'];

    public $id;
    public $name;
    public $price;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->price = $args['price'] ?? '';
    }

    public function validar(){
        if(!$this->name){
            self::$alertas['error'][]="El nombre del servicio es obligatorio";
        }
        if(!$this->price){
            self::$alertas['error'][]="El precio del servicio es obligatorio";
        }else{
            if(!is_numeric($this->price) || $this->price < 0){
                self::$alertas['error'][]="El precio debe ser numerico y mayor a 0";
            }
        }
        return self::$alertas;
    }
}
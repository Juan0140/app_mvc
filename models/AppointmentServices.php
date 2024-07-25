<?php
namespace Model;

class AppointmentServices extends ActiveRecord{
    protected static $tabla = "appointmentservices";
    protected static $columnasDB = ['id', 'appointmentId', 'serviceId'];

    public $id;
    public $appointmentId;
    public $serviceId;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->appointmentId = $args['appointmentId'] ?? '';
        $this->serviceId = $args['serviceId'] ?? '';
    }
}
<?php
namespace Controllers;
use Model\ActiveRecord;
use Model\AppointmentServices;
use Model\Service;
use Model\Appointment;  

class APIController {

    public static function index() {
        $services = Service::all();
        echo json_encode($services);
    }


    public static function save() {
        //?Almacena la cita
        $appointment = new Appointment($_POST);
        $response=$appointment->guardar();
        $id = $response['id'];

        $idServices = explode(',', $_POST['services']);

        //?Almacena los servicios
        foreach($idServices as $idService){
            $args = [
                'appointmentId' => $id,
                'serviceId' => $idService
            ];
            $appointmentService = new AppointmentServices($args);
            $appointmentService->guardar();
        }
        echo json_encode($response);
    }

    public static function delete() {
        
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $id = $_POST['id'];
            $appointment = Appointment::find($id);
            $appointment->eliminar();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    
}
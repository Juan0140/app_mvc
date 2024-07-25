<?php
namespace Controllers;
use Model\AdminAppointment;
use MVC\Router;

class AdminController{
    public static function index(Router $router){
        session_start();

        isAdmin();

        $date = $_GET['date'] ?? date('Y-m-d');
        $dates = explode('-', $date);
        if(checkdate($dates[1], $dates[0], $dates[2])){
            header('Location /404');
        }

        $consult = "SELECT appointments.id, appointments.hour, CONCAT(users.name, ' ', users.lastName ) as client,";
        $consult .= " users.email, users.phone, services.name as service, services.price ";
        $consult .= " FROM appointments ";
        $consult .= " LEFT OUTER JOIN users ";
        $consult .= " ON appointments.userId = users.id ";
        $consult .= " LEFT OUTER JOIN appointmentservices ";
        $consult .= " ON appointmentservices.appointmentId = appointments.id ";
        $consult .= " LEFT OUTER JOIN services ";
        $consult .= " ON appointmentservices.serviceId = services.id ";
        $consult .= " WHERE date = '{$date}'";

        $appointmets = AdminAppointment::SQL($consult);
        $router->render('admin/index', [
            'name'=> $_SESSION['name'],
            'appointments' => $appointmets,
            'date' => $date
        ]);
    }
}
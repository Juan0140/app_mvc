<?php
namespace Controllers;
use Model\Service;
use MVC\Router;

class ServiceController{

    public static function index(Router $router){
        session_start();
        isAdmin();
        $services = Service::all();

        $router->render('services/index', [
            'name'=> $_SESSION['name'],
            'services' => $services
        ]);
        
    }

    public static function create(Router $router){
        session_start();
        isAdmin();
        $service = new Service();
        $alerts = [];

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $service->sincronizar($_POST);
            $alerts = $service->validar();
            if(empty($alerts)){
                $service->guardar();
                header("Location: /services");
            }
        }


        $router->render('services/create', [
            'name'=> $_SESSION['name'],
            'service' => $service,
            'alerts' => $alerts
        ]);
    }

    public static function update(Router $router){
        session_start();
        isAdmin();
        if(!is_numeric($_GET['id'])) return;
        $id = $_GET['id'];
        $service = Service::find($id);
        $alerts = [];

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $service->sincronizar($_POST);
            $alerts = $service->validar();
            if(empty($alerts)){
                $service->guardar();
                header("Location: /services");
            }
        }


        $router->render('services/update', [
            'name'=> $_SESSION['name'],
            'service' => $service,
            'alerts' => $alerts
        ]);
    }

    public static function delete(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            isAdmin();
            if(!is_numeric($_POST['id']))  return;
            $id = $_POST['id'];
            $service = Service::find($id);
            $service->eliminar();
            header("Location: /services");
        }
    }
}
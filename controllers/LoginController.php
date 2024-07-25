<?php
namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\User;

class LoginController
{

    public static function login(Router $router)
    {
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);
            $alerts = $auth->validateLogin();

            if (empty($alerts)) {
                //? comprobar que existar el usuario
                $user = User::where('email', $auth->email);

                if ($user) {
                    //? Verificar que este confirmado
                    //? Verificar Password
                    if ($user->passwordAndVerification($auth->password)) {
                        session_start();
                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name . " " . $user->lastName;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                        if ($user->admin == 1) {
                            $_SESSION['admin'] = $user->admin ?? null;
                            header("Location: /admin");

                        } else {
                            header("Location: /appointment");
                        }

                    }
                    //
                } else {
                    User::setAlerta('error', 'Usuario no registrado');
                }
            }
        }

        $alerts = User::getAlertas();
        $router->render('auth/login', [
            'alerts' => $alerts
        ]);
    }

    public static function logout()
    {
        session_start();
        $_SESSION= [];
        header("Location: /");
    }


    public static function forget(Router $router)
    {

        $alerts = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = new User($_POST);
            $alerts = $auth->validateEmail();

            if (empty($alerts)) {
                $user = User::where("email", $auth->email);
                if ($user && $user->confirmed == 1) {
                    $user->createToken();
                    $user->guardar();

                    // enviar email
                    $email = new Email($user->email, $user->name, $user->token);
                    $email->sendInstructions();

                    User::setAlerta('exito', 'Revisa tu e-mail');
                } else {
                    User::setAlerta("error", "El usuario no existe o no esta confirmado");
                }
            }
        }
        $alerts = User::getAlertas();
        $router->render('auth/forget-password', [
            'alerts' => $alerts
        ]);

    }

    public static function recover(Router $router)
    {
        $alerts = [];
        $error=false;
        $token = s($_GET['token']);
        $user = User::where('token', $token);
        if(empty($user)) {
            User::setAlerta('error','Token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $password = new User($_POST); 
            $alerts=$password->validatePassword();
            if (empty($alerts)) {
                $user->password = null;
                $user->password = $password->password;
                $user->hashPassword();
                $user->token = null;
                $result=$user->guardar();
                if ($result) {
                    header('Location: /');
                }
                debuguear($user);
            }
        }

        $alerts=User::getAlertas();
        $router->render('auth/recover-password',[
            'alerts'=> $alerts,
            'error'=> $error
        ]);
    }

    public static function create(Router $router)
    {
        //? Instanciamos al usuario
        $user = new User;
        // ? Alertas vacias
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //* Sincronizamos lo que hay en memoria con el objeto
            $user->sincronizar($_POST);
            $alerts = $user->validateNewAccount();
            // debuguear($alerts);

            if (empty($alerts)) {
                // ? Verificar que el usuario no este registrado
                $result = $user->userExists();
                if ($result->num_rows) {
                    $alerts = User::getAlertas();
                } else {
                    //? hashear el password
                    $user->hashPassword();

                    //?Generar Token unico
                    $user->createToken();
                    //? Instanciamos el email ylo enviamos
                    $email = new Email($user->name, $user->email, $user->token);
                    $email->sendConfirmation();

                    $result = $user->guardar();
                    if ($result) {
                        header("Location: /message");
                    }
                }
            }
        }

        $router->render('auth/create-account', [
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function message(Router $router)
    {
        $router->render('auth/message');
    }

    public static function confirm(Router $router)
    {
        $alerts = [];
        $token = s($_GET['token']);
        $user = User::where('token', $token);

        if (empty($user)) {
            User::setAlerta('error', 'Token no valido');
            $alerts = User::getAlertas();

        } else {
            $user->confirmed = "1";
            $user->token = NULL;
            $user->guardar();
            User::setAlerta('exito', 'Su cuenta ha sido confirmada');
        }
        $alerts = User::getAlertas();
        $router->render('auth/confirm-account', [
            'alerts' => $alerts
        ]);
    }

}
<?php 
namespace Model;

class User extends ActiveRecord{
    //* Base de datos
    protected static $tabla = 'users';
    protected static $columnasDB = ['id', 'name', 'lastName', 'email', 'password', 'phone', 'admin', 'confirmed', 'token'];


    // ? Son public para acceder ya sea en la clase misma o en el objeto ya cuando son instanciados
    // ? Y protected cuando solo podemos acceder en la clase a ellos
    public $id;
    public $name;
    public $lastName;
    public $email;
    public $password;
    public $phone;
    public $admin;
    public $confirmed;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->lastName = $args['lastName'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->phone = $args['phone'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmed = $args['confirmed'] ?? 0;
        $this->token = $args['token'] ?? '';

    }


    // ? Mensajes de validacion para la creacion de una cuenta
    //* This hace referencia al objeto que se instancia
    public function validateNewAccount()
    {
        if(!$this->name){
            self::$alertas['error'][]="El nombre es obligatorio";
        }

        if(!$this->lastName){
            self::$alertas['error'][]="El apellido es obligatorio";
        }

        if(!$this->phone){
            self::$alertas['error'][]="El telefono es obligatorio";
        }

        if(!$this->email){
            self::$alertas['error'][]="El email es obligatorio";
        }

        if(!$this->password){
            self::$alertas['error'][]="La contraseña es obligatoria";
        }else if(strlen($this->password) < 6){
            self::$alertas['error'][]="La contraseña debe contener al menos 6 caracteres";
        }

        return self::$alertas;
    }

    public function validateLogin(){
        if(!$this->email){
            self::$alertas['error'][]="El E-mail es obligatorio";
        }
        if(!$this->password){
            self::$alertas['error'][]="El password es obligatorio";
        }

        return self::$alertas;
    }

    public function validateEmail(){
        if(!$this->email){
            self::$alertas["error"][]= "El E-mail es obligatorio";
        }
        return self::$alertas;
    }

    public function validatePassword(){
        if(!$this->password){
            self::$alertas['error'][]="La contraseña es obligatoria";
        }else if(strlen($this->password) < 6){
            self::$alertas['error'][]="La contraseña debe contener al menos 6 caracteres";
        }

        return self::$alertas;
    }

    public function passwordAndVerification($password){
        $result=password_verify($password, $this->password);

        if($result){
            if($this->confirmed){
                return true;
            }else{
                self::$alertas['error'][]="El usuario no esta confirmado";
            }
        }else{
            self::$alertas['error'][]="Password incorrecto";
        }

    }

    // ? Revisa si el usuario ya existe
    public function userExists(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $result = self::$db->query($query);
        if($result->num_rows){
            self::$alertas ['error'][] = "Este correo ya ha sido registrado";
        }
        return $result;
    }


    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT); 
    }

    public function createToken(){
        $this->token = uniqid();
    }
}
<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'El campo es requerido'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este nombre de usuario ya se encuentra registrado.'],
            ['username', 'string', 'min' => 2, 'max' => 255, 'message' => 'El campo no puede exceder los 255 caracteres'],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'El campo es requerido'],
            ['email', 'email', 'message' => 'Correo electronico no válido'],
            ['email', 'string', 'max' => 255, 'message' => 'El campo no puede exceder los 255 caracteres'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Ya existe una cuenta de usuario registrada con este correo.'],

            ['password', 'required', 'message' => 'El campo es requerido'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels(){
        return [
        'username' => 'Nombre de usuario',
        'password' => 'Contraseña',
        'email' => 'Correo electrónico'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        /*if (!$this->validate()) {
            return null;
        }*/
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}

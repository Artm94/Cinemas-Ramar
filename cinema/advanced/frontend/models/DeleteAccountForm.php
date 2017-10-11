<?php 

namespace frontend\models;

use Yii;
use common\models\User;

class DeleteAccountForm extends \yii\base\Model{
	public $username;
	public $password;
	public $confirm;

	public function rules(){
		return [
		[['password', 'confirm'], 'required', 'message' => 'El campo es requerido'],
		['username', 'exist', 'skipOnEmpty' => true, 'targetClass' => '\common\models\User'],
		['password', 'string', 'max' => 16, 'message' => 'La contraseña debe tener maximo 16 caracteres'],
		];
	}

	public function attributeLabels()
	{
		return [
		'username' => 'Nombre de usuario',
		'password' => 'Contraseña actual',
		'confirm' => 'Acepto eliminar mi cuenta',
		];
	}

	public function identifyUser()
	{
		if(!$this->validate() && $this->confirm){
			return null;
		}

		$user = User::findByUsername($this->username);
		if($user->validatePassword($this->password)){
			return $user;
		}
		$this->addError('password', 'La contraseña no es valida');
		return null;
	}
}
 ?>

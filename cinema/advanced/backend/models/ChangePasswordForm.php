<?php 
namespace backend\models;

use common\models\User;

class ChangePasswordForm extends \yii\base\Model{
	public $username;
	public $oldPassword;
	public $newPassword;
	public $confirmPassword;

	public function rules()
	{
		return [
		[['oldPassword', 'newPassword', 'confirmPassword'], 'required', 'message' => 'El campo es requerido'],
		['username', 'exist', 'skipOnEmpty' => true, 'targetClass' => '\common\models\User'],
		[['oldPassword', 'newPassword', 'confirmPassword'], 'string', 'max' => 16, 'message' => 'La contraseña debe tener maximo 16 caracteres'],
		[['confirmPassword'], 'validateConfirmPassword'],
		];
	}

	public function validateConfirmPassword($attribute, $params)
	{
		if($this->confirmPassword !== $this->newPassword){
			$this->addError($attribute, 'La contraseña de confirmacion debe coincidir con la nueva contraseña');
		}
	}

	public function attributeLabels()
	{
		return [
		'username' => 'Nombre de usuario',
		'oldPassword' => 'Contraseña actual',
		'newPassword' => 'Nueva contraseña',
		'confirmPassword' => 'Confirmar contraseña',
		];
	}

	public function changePassword()
	{
		$user = User::findByUsername($this->username);
		if($user->validatePassword($this->oldPassword)){
			$user->setPassword($this->newPassword);
			$user->generateAuthKey();
			return $user->save() ? $user : null;
		}
		$this->addError('oldPassword', 'La contraseña no es correcta');
		return null;
	}
}
 ?>

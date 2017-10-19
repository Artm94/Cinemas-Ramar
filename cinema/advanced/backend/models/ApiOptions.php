<?php 
namespace backend\models;

use Yii;
use yii\base\Model;

class ApiOptions extends Model{

	public $movieId;
	public $movieFlag;
	public $movieInformation;
	public $movieMediaContent;
	public $movieCredits;

	public function rules(){
		return [
			[["movieInformation", "movieMediaContent", "movieCredits"], "required"],
			[["movieId"], "required", "skipOnEmpty" => "true"],
			[["movieFlag", "movieInformation", "movieMediaContent", "movieCredits"], "boolean"],
			[["movieId"], "string"]
		];
	}

	public function attributeLabels(){
		return [
			"movieId" => "ID de pelicula",
			"movieFlag" => "Obtener informacion sobre la pelicula a traves de internet",
			"movieInformation" => "Obtener reseña y descripcion directamente de internet",
			"movieMediaContent" => "Obtener contenido audiovisual directamente de internet",
			"movieCredits" => "Obtener informacion del reparto de la pelicula directamente de internet"
		];
	}
}
?>

<?php 
namespace backend\models;

use Yii;
use yii\base\Model;

class ApiOptions extends Model{

	public $movieId;
	public $movieInformation;
	public $movieMediaContent;
	public $movieCredits;

	public function rules(){
		return [
			[["movieInformation", "movieMediaContent", "movieCredits"], "required"],
			[["movieFlag", "movieInformation", "movieMediaContent", "movieCredits"], "boolean"],
			[["movieId"], "string"]
		];
	}

	public function attributeLabels(){
		return [
			"movieId" => "ID de pelicula",
			"movieInformation" => "Obtener reseña, descripcion y duracion directamente de internet",
			"movieMediaContent" => "Obtener contenido audiovisual directamente de internet",
			"movieCredits" => "Obtener informacion del reparto de la pelicula directamente de internet"
		];
	}
}
?>

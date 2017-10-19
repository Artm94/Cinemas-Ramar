<?php

namespace common\custom;

class MovieFinder{
	public $apiKey;
	public $url;
	public $page;
	/* e01a182bdeed3afc056d41564eba1bdd */
	function __construct($apiKey, $language = 'en-US', $page = '1'){
		$this->apiKey = $apiKey;
		$this->language = $language;
		$this->page = $page;
	}

	public function findMovieByName($movieName){
		$movieName = urlencode($movieName);
		$url = "https://api.themoviedb.org/3/search/movie?api_key=$this->apiKey&language=$this->language&page=$this->page&include_adult=false&query=$movieName";
		$data = file_get_contents($url);
		$movie = json_decode($data)->results[0];
		return $movie;
	}

	public function movieExists($movieNme){
		$movieName = urlencode($movieName);
		$url = "https://api.themoviedb.org/3/search/movie?api_key=$this->apiKey&language=$this->language&page=$this->page&include_adult=false&query=$movieName";
		$data = file_get_contents($url);
		$count = json_decode($data)->total_results;
		return ($count > 0);
	}

	public function getMovieById($id){
		$movieID = urlencode($id);
		$url = "https://api.themoviedb.org/3/movie/$movieID?api_key=$this->apiKey&language=$this->language&append_to_response=images,credits&include_image_language=$this->language,null";
		$data = file_get_contents($url);
		$data = json_decode($data);
		return $data;
	}

	public function getVideosById($movieID, $language = 'en-Us'){
		$movieID = urlencode($movieID);
		$url = "https://api.themoviedb.org/3/movie/$movieID/videos?api_key=$this->apiKey&language=$language";
		$data = file_get_contents($url);
		$data = utf8_encode($data);
		$data = json_decode($data);
		return $data->results;
	}

	public function getImagesById($movieID){
		$movieID = urlencode($movieID);
		$url = "https://api.themoviedb.org/3/movie/$movieID/images?api_key=$this->apiKey&language=$this->language";
		$data = file_get_contents($url);
		$data = json_decode($data);
		return $data->results;
	}

	public function getImage($imageId, $imageSize = 'w500'){
		return "https://image.tmdb.org/t/p/$imageSize" . $imageId;
	}

	public function getPosterById($id, $imageSize = 'w500'){
		$movie = getMovieById($id);
		$image = "https://image.tmdb.org/t/p/$imageSize" . $movie->poster_path;
	}

	public function getBackdropById($id, $imageSize = 'w500'){
		$movie = getMovieById($id);
		$image = "https://image.tmdb.org/t/p/$imageSize" . $movie->backdrop_path;
	}

	public function findPosterByName($movieName, $imageSize = 'w500'){
		$movie = $this->findMovieByName($movieName);
		$image = "https://image.tmdb.org/t/p/$imageSize" . $movie->poster_path;
		return $image;
	}

	public function findBackdropByName($movieName, $imageSize = 'w500'){
		$movie = $this->findMovieByName($movieName);
		$image = "https://image.tmdb.org/t/p/$imageSize" . $movie->backdrop_path;
		return $image;
	}

}
<?php

namespace frontend\custom;

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
		$data = utf8_encode($data);
		$movie = json_decode($data)->results[0];
		return $movie;
	}

	public function movieExists($movieNme){
		$movieName = urlencode($movieName);
		$url = "https://api.themoviedb.org/3/search/movie?api_key=$this->apiKey&language=$this->language&page=$this->page&include_adult=false&query=$movieName";
		$data = file_get_contents($url);
		$data = utf8_encode($data);
		$count = json_decode($data)->total_results;
		return ($count > 1);
	}

	public function getVideosByID($movieID){
		$movieID = urlencode($movieID);
		$url = "https://api.themoviedb.org/3/movie/$movieID/videos?api_key=$this->apiKey&language=$this->language";
		$data = file_get_contents($url);
		$data = utf8_encode($data);
		$count = json_decode($data)->total_results;
	}

	public function getImagesByID($movieID){
		$movieID = urlencode($movieID);
		$url = "https://api.themoviedb.org/3/movie/$movieID/images?api_key=$this->apiKey&language=$this->language";
		$data = file_get_contents($url);
		$data = utf8_encode($data);
		$videos = json_decode($data)->total_results;
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
<?php

namespace App\Repository;

//Models
use App\Models\detail_movie;

class DetailMovieRepositry{
 public function getAll()
 {
    $data = detail_movie::all();
    return $data;
 }
}

<?php

namespace App\Http\Controllers;

use App\Models\detail_movie;
use App\Repository\DetailMovieRepositry;
use Illuminate\Http\Request;

class DetailMovieController extends Controller
{
    private $DetailMovie;

    public function __construct(DetailMovieRepositry $DetailMovieRepository)
    {
        $this->DetailMovie = $DetailMovieRepository;
    }

    public function index()
    {
        $data = $this->DetailMovie->getAll();
        return $data;
    }
}

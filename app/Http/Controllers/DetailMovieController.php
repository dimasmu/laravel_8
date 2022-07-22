<?php

namespace App\Http\Controllers;

use App\Repositories\DetailMovieRepository;
use Illuminate\Http\Request;

class DetailMovieController extends Controller
{
    private $DetailMovieRepository;

    public function __construct(DetailMovieRepository $DetailMovieRepository)
    {
        $this->DetailMovieRepository = $DetailMovieRepository;
    }

    public function index($id)
    {
        $data = $this->DetailMovieRepository->findOne($id);
        return view('movie.detail',compact('data'));
    }
}

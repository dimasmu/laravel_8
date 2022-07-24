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
        $movie_id = $id;
        $data = $this->DetailMovieRepository->findOne($id);
        return view('movie.detail',compact('data','movie_id'));
    }

    public function apiIndex(Request $request,$id)
    {
        $data = $this->DetailMovieRepository->findOneYajra($request,$id);
        return $data;
    }

    public function insert(Request $request)
    {
        $data = $this->DetailMovieRepository->save($request);
        return $data;
    }

}

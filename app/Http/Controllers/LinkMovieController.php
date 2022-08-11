<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Link;
use App\Repositories\LinkMovieRepository;

class LinkMovieController extends Controller
{
    private $LinkMovieRepository;

    public function __construct(LinkMovieRepository $LinkMovieRepository)
    {
        $this->LinkMovieRepository = $LinkMovieRepository;
    }

    public function index(Request $request,$id)
    {
        $data = $this->LinkMovieRepository->index($request,$id);
        return $data;
    }

    public function apiIndex(Request $request, $id)
    {
        $data = $this->LinkMovieRepository->findOneYajra($request, $id);
        return $data;
    }

    public function save(Request $request)
    {
        $data = $this->LinkMovieRepository->save($request);
        return $data;
    }

    public function delete($id)
    {
        $data = $this->LinkMovieRepository->delete($id);
        return $data;
    }

    public function findOne($id)
    {
        $data = $this->LinkMovieRepository->findOne($id);
        return $data;
    }
}

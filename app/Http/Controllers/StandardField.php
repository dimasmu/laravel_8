<?php

namespace App\Http\Controllers;

use App\Repositories\StandardFieldRepository;
use Illuminate\Http\Request;

class StandardField extends Controller
{
    private $StandardFieldRepository;

    public function __construct(StandardFieldRepository $StandardFieldRepository)
    {
        $this->StandardFieldRepository = $StandardFieldRepository;
    }

    public function findOne($id)
    {
        $data = $this->StandardFieldRepository->findOne($id);
        return $data;
    }

    public function findOneAjax(Request $request,$id)
    {
        $data = $this->StandardFieldRepository->findOneAjax($id,$request->input('search'));
        return $data;
    }

    public function findOneResolution($id)
    {
        $data = $this->StandardFieldRepository->findOneResolution($id);
        return $data;
    }
}

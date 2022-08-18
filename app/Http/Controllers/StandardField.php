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

    public function findAll()
    {
        $data = $this->StandardFieldRepository->findAll();
        return $data;
    }

    public function findOne($id)
    {
        $data = $this->StandardFieldRepository->findOne($id);
        return $data;
    }

    public function findOneEdit($id)
    {
        $data = $this->StandardFieldRepository->findOneEdit($id);
        return $data;
    }

    public function findOneAjax(Request $request,$id)
    {
        $data = $this->StandardFieldRepository->findOneAjax($id,$request->input('search'));
        return $data;
    }

    public function findAllYajra(Request $request)
    {
        $data = $this->StandardFieldRepository->findAllYajra($request->input('search'));
        return $data;
    }

    public function findOneResolution($id)
    {
        $data = $this->StandardFieldRepository->findOneResolution($id);
        return $data;
    }

    public function saveStandardField(Request $request)
    {
        $data = $this->StandardFieldRepository->save($request);
        return $data;
    }

    public function deleteStandardField($id)
    {
        $data = $this->StandardFieldRepository->delete($id);
        return $data;
    }
}

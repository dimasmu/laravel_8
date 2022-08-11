<?php

namespace App\Repositories;

//Utility
use Datatables;
//Models
use App\Models\detail_movie;
use App\Models\link_movie;
use App\Models\Standard_field;
use App\Models\Standard_field_detail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class StandardFieldRepository
{
    public function findOne($id)
    {
        try {
            $standardField = Standard_field::find($id)->group()->get();
            return $standardField;
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Data not found'], 404);
        }
    }
    public function findOneAjax($id,$search)
    {
        try {
            $standardField = Standard_field::find($id)->group()
            ->when($search !== '', function($query) use ($search){
                return $query->where("name", "like", "%$search%");
            })
            ->get()
            ;
            $setColumn = $standardField->map(function ($data){
                $getData =  collect($data->toArray());
                return [
                    "id" => $getData['id'],
                    "text" => $getData['name']
                ];
            });
            return $setColumn;
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Data not found'], 404);
        }
    }
    public function findOneResolution($id)
    {
        try {
            $standardField = Standard_field_detail::selectRaw('id,name as text')->where('id',"=", $id)->first();
            return $standardField;
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Data not found'], 404);
        }
    }
}

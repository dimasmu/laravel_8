<?php

namespace App\Repositories;

//Utility

use App\Http\Controllers\StandardField;
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
    public function findAll()
    {
        try {
            $data = Standard_field::all();
            $active = 1;
            return view('system.list',compact('data','active'));
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Data not found'], 404);
        }
    }
    public function findOne($id)
    {
        try {
            $standardField = Standard_field::find($id)->group()->get();
            return $standardField;
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Data not found'], 404);
        }
    }
    public function findOneEdit($id)
    {
        try {
            $standardField = Standard_field::find($id);
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

    public function findAllYajra($search)
    {
        try {
            $data = Standard_field::all()->map(function ($data,$key) {
                $array = [
                    'id' => $data->id,
                    'no' => $key+1,
                    'name' => $data->name,
                    'is_status' => $data->is_status,
                    'created_by' => $data->created_by,
                    'updated_by' => $data->updated_by,
                    'created_at' => $data->created_at ? Carbon::parse($data->created_at)->format('d M Y') : '',
                    'updated_at' => $data->updated_at ? Carbon::parse($data->updated_at)->format('d M Y') : '',
                ];
                return $array;
            });
            return Datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('status', function($row){
                $data = $row['is_status'];
                $btn = '';
                if($data === 1){
                    $btn .= '
                        <i class="fa-solid fa-check" style="text-align: center;width: 100%;"></i>
                    ';
                } else {
                    $btn .= '
                        <i class="fa-solid fa-xmark" style="text-align: center;width: 100%;"></i>
                    ';
                }
                return htmlspecialchars_decode($btn);
            })
            ->addColumn('action', function($row){
                $btn = '
                <td>
                    <a id="editBtn_'.$row['id'].'" onClick="routeEdit('.$row['id'].')"
                        class="btn btn-primary">Edit</a>
                    <a id="deleteBtn_'.$row['id'].'" onClick="routeDelete('.$row['id'].')"
                        class="btn btn-danger">Delete</a>
                </td>
                ';
                return $btn;
            })
            ->make(true);
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

    public function save($request)
    {
        $newDate = date("Y-m-d H:i:s");
        $validatedData = $request->validate([
            'name' => 'required',
            'status' => 'required'
        ]);
        try {
            $id = $request->input('stdId');
            if($id !== null){
                $data = Standard_field::find($id);
                if($data){
                    $data->update([
                        'name' => $request->input('name'),
                        'is_status' => $request->input('status') === "true" ? 1 : 0,
                        'updated_at' => $newDate
                    ]);
                    DB::commit();
                    return response()->json(['title'=>'Success', 'text'=>'Success update standard field data!'], 200);
                } else {
                    return response()->json(['title'=>'Failed', 'text'=>'Data not Found'], 400);
                }
            } else {
                Standard_field::create([
                    'name' => $request->input('name'),
                    'is_status' => $request->input('status') === "true" ? 1 : 0,
                    'created_at' => $newDate
                ]);
                return response()->json(['title'=>'Success', 'text'=>'Success insert standard field!'], 201);
            }
        } catch (\Throwable $th) {
            return response(['title'=>'FAILURE', 'text' => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        $data = Standard_field::find($id);
        $data->delete();
        return response()->json(['title'=>'Success', 'text'=>'Success delete standard field!'], 200);
    }
}

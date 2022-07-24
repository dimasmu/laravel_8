<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\StandardField;

class MovieListController extends Controller
{
    public function index(){
        $data = DB::table('movie as a')
        ->select('a.id','a.title','a.category',DB::raw('DATE_FORMAT(a.release, "%d %M %Y") as "release"'),DB::raw('DATE_FORMAT(a.aired_from, "%d %M %Y") as "aired_from"'),DB::raw('DATE_FORMAT(a.aired_to, "%d %M %Y") as "aired_to"'),'b.name as duration','c.name as status',DB::raw('DATE_FORMAT(a.created_at, "%d %M %Y | %H:%i") as "created_at"'),DB::raw('DATE_FORMAT(a.updated_at, "%d %M %Y | %H:%i") as "updated_at"'))
        ->leftJoin('standard_field as b','a.duration','=','b.id')
        ->leftJoin('standard_field as c','a.status','=','c.id')->get();
        foreach ($data as $key => $value) {
            $value->category = json_decode($value->category);
        }
        return view('movie.list',compact('data'));
    }

    public function openMovie(){
        // Genre
        $dataGenre = StandardField::where([
            ['group', '=', 1],
            ['is_status', '=', 1]
        ])->get();

        // Status
        $dataStatus = StandardField::where([
            ['group', '=', 2],
            ['is_status', '=', 1]
        ])->get();

        // Duration
        $dataDuration = StandardField::where([
            ['group', '=', 3],
            ['is_status', '=', 1]
        ])->get();
        return view('movie.add',compact('dataGenre','dataStatus','dataDuration'));
    }

    public function insertMovie(Request $request){
        $validatedData = $request->validate([
            'title' => 'required',
            'category' => 'required|max:255',
            'release' => 'required',
            'duration' => 'required|max:255',
            'status' => 'required|max:255'
        ]);
        $id = $request->input('id');
        if($id){
            $data = Movie::find($id);
            $data->update($request->all());
            return response()->json(['title'=>'Success', 'text'=>'Success update movie data!'], 200);
        } else {
            Movie::create($request->all());
            return response()->json(['title'=>'Success', 'text'=>'Success insert movie data!'], 201);
        }
    }

    public function updateMovie($id){
        $is_update = true;
        $data = Movie::find($id);
         // Genre
        $dataGenre = StandardField::where([
            ['group', '=', 1],
            ['is_status', '=', 1]
        ])->get();

        // Status
        $dataStatus = StandardField::where([
            ['group', '=', 2],
            ['is_status', '=', 1]
        ])->get();

        // Duration
        $dataDuration = StandardField::where([
            ['group', '=', 3],
            ['is_status', '=', 1]
        ])->get();
        return view('movie.add',compact('data','dataGenre','dataStatus','dataDuration','is_update'));
    }

    public function deleteMovie($id){
        $data = Movie::find($id);
        $data->delete();
        return response()->json(['title'=>'Success', 'text'=>'Success delete movie data!'], 200);
    }
}

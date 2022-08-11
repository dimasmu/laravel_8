<?php

namespace App\Repositories;

//Utility
use Datatables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\link_movie;
use Carbon\Carbon;

class LinkMovieRepository
{
    public function index($request,$id)
    {
        $movieId = $request['movie_id'];
        return view('movie.link',compact('id','movieId'));
    }

    public function findOneYajra($request, $id)
    {
        if($request->ajax()){

        }
        $data = link_movie::with('resolution_join')->where([
            ['detail_movie_id', '=', $id]
        ])
        ->get()
        ->map(function ($data,$key) {
            $array = [
                'id' => $data->id,
                'no' => $key+1,
                'detail_movie_id' => $data->detail_movie_id,
                'embed' => $data->embed,
                'link' => $data->link,
                'resolution' => $data->resolution_join->name,
                'created_at' => $data->created_at ? Carbon::parse($data->created_at)->format('d M Y') : '',
                'updated_at' => $data->updated_at ? Carbon::parse($data->updated_at)->format('d M Y') : '',
            ];
            return $array;
        });
        return datatables()->of($data)
        ->addIndexColumn()
        ->addColumn('link_embed_resolution', function($row){
            $btn = '';
            $btn .='
            <button type="button" class="btn btn-primary" data-mdb-toggle="modal"
                data-mdb-target="#linkModal-'.$row['no'].'">
                Show Video '.$row['no'].'
            </button>
            <div class="modal fade" id="linkModal-'.$row['no'].'" tabindex="-1"
                aria-labelledby="titlemodal-'.$row['no'].'" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 100%;width: auto !important;display: table;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="titlemodal-'.$row['no'].'">Video '.$row['no'].' resolution '.$row['resolution'].'</h5>
                            <button type="button" class="btn-close" data-mdb-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modalbody-'.$row['no'].'">
                            '.$row['embed'].'
                            <br>
                            <a class="btn btn-primary" href="'.$row['link'].'" target="_blank" role="button">Link Download</a>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-mdb-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            ';
            return htmlspecialchars_decode($btn);
        })
        ->addColumn('action', function($row){
            $btn = '
            <td>
                <a id="editBtn_'.$row['id'].'" onClick="routeEditLink('.$row['id'].')"
                    class="btn btn-primary">Edit</a>
                <a id="deleteBtn_'.$row['id'].'" onClick="routeDeleteLink('.$row['id'].')"
                    class="btn btn-danger">Delete</a>
            </td>
            ';
            return $btn;
        })
        ->make(true);
    }

    public function save($request)
    {
        $newDate = date("Y-m-d H:i:s");
        $validatedData = $request->validate([
            'detailId' => 'required',
            'embed' => 'required',
            'link' => 'required',
            'resolution' => 'required'
        ]);
        try {
            $data = $request->all();
            if(isset($data['linkId'])){
                $getLinkMovie = link_movie::find($data['linkId']);
                if($getLinkMovie){
                    $getLinkMovie->update([
                        'embed' => $data['embed'],
                        'link' => $data['link'],
                        'resolution' => $data['resolution'],
                        'updated_at' => $newDate
                    ]);
                    return response()->json(['title'=>'Success', 'text'=>'Success update link movie data!'], 200);
                } else {
                    return response()->json(['title'=>'Failed', 'text'=>'Data not Found'], 400);
                }
            } else {
                link_movie::insert([
                    'detail_movie_id' => $data['detailId'],
                    'embed' => $data['embed'],
                    'link' => $data['link'],
                    'resolution' => $data['resolution'],
                    'created_at' => $newDate
                ]);
                return response()->json(['title'=>'Success', 'text'=>'Success insert link movie data!'], 201);
            }
        } catch (\Throwable $th) {
            return response(['title'=>'FAILURE', 'text' => $th], 500);
        }
    }

    public function delete($id)
    {
        $data = link_movie::find($id);
        $data->delete();
        return response()->json(['title'=>'Success', 'text'=>'Success delete movie link!'], 200);
    }

    public function findOne($id)
    {
        $data = link_movie::find($id);
        return $data;
    }
}

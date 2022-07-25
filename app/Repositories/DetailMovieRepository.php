<?php

namespace App\Repositories;

//Utility
use Datatables;
//Models
use App\Models\detail_movie;
use App\Models\link_movie;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DetailMovieRepository{
    public function findOne($id)
    {
        $data = detail_movie::where([
            ['movie_id', '=', $id]
        ])
        ->get()
        ->map(function ($data) {
            $array = [
                'id' => $data->id,
                'movie_id' => $data->movie_id,
                'episode' => $data->episode,
                'link' => $data->link,
                'view' => $data->view,
                'like' => $data->like,
                'dislike' => $data->dislike,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
                'link' => $data->getLink

            ];
            return $array;
        });
        return $data;
    }

    public function findOneDetail($id)
    {
        $data = detail_movie::with('getLink')->get()->find($id);
        return $data;
    }

    public function findOneYajra($request, $id)
    {
      if($request->ajax()){
        $data = detail_movie::where([
            ['movie_id', '=', $id]
        ])
        ->get()
        ->map(function ($data,$key) {
            $array = [
                'no' => $key+1,
                'id' => $data->id,
                'movie_id' => $data->movie_id,
                'episode' => $data->episode,
                'link' => $data->getLink,
                'view' => $data->view,
                'like' => $data->like,
                'dislike' => $data->dislike,
                'created_at' => Carbon::parse($data->created_at)->format('d M Y'),
                'updated_at' => Carbon::parse($data->updated_at)->format('d M Y'),

            ];
            return $array;
        });

        return Datatables()->of($data)
        ->addIndexColumn()
        ->addColumn('link_html', function($row){
            $data = $row['link']->toArray();
            $btn = '';
            foreach ($data as $key => $value) {
                $getIndex = $key+1;
                $btn .='
                    <button type="button" class="btn btn-primary" data-mdb-toggle="modal"
                        data-mdb-target="#linkModal-'.$value['detail_movie_id'].'-'.$getIndex.'">
                        Show Link '.$getIndex.'
                    </button>
                    <div class="modal fade" id="linkModal-'.$value['detail_movie_id'].'-'.$getIndex.'" tabindex="-1"
                        aria-labelledby="titlemodal-'.$value['detail_movie_id'].'-'.$getIndex.'" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="max-width: 100%;width: auto !important;display: table;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="titlemodal-'.$value['detail_movie_id'].'-'.$getIndex.'">Link '.$getIndex.'</h5>
                                    <button type="button" class="btn-close" data-mdb-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="modalbody-'.$value['detail_movie_id'].'-'.$getIndex.'">
                                    '.$value['link'].'
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-mdb-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
            return htmlspecialchars_decode($btn);
        })
        ->addColumn('action', function($row){
            $btn = '
            <td>
                <a onClick="routeEditDetail('.$row['id'].')"
                    class="btn btn-primary">Edit</a>
                <a onClick="routeDeleteDetail('.$row['id'].')"
                    class="btn btn-danger">Delete</a>
            </td>
            ';
            return $btn;
        })
        ->make(true);
      }
    }

    public function save($request)
    {
        $newDate = date("Y-m-d H:i:s");
        $validatedData = $request->validate([
            'movieId' => 'required',
            'episode' => 'required'
        ]);
        $data = $request->all();
        if($data['lnkId']){
            $getDetailMovie = detail_movie::find($data['lnkId']);
            $getDetailMovie->update([
                'episode' => $request->input('episode'),
                'updated_at' => $newDate
            ]);
            DB::table('link_movie')->where('detail_movie_id',$data['lnkId'])->delete();
            $newArray = [];
            foreach ($data as $key => $value) {
                if(str_starts_with($key,"link")){
                    array_push($newArray,[
                        'detail_movie_id' => $data['lnkId'],
                        'link' => $value,
                        'created_at' => $newDate,
                        'updated_at' => $newDate
                    ]);
                }
            }
            link_movie::insert($newArray);
            return response()->json(['title'=>'Success', 'text'=>'Success update detail movie data!'], 200);
        } else {
            $newId = detail_movie::create([
                'movie_id' => $request->input('movieId'),
                'episode' => $request->input('episode'),
                'created_at' => $newDate
            ]);
            $newArray = [];
            foreach ($data as $key => $value) {
                if(str_starts_with($key,"link")){
                    array_push($newArray,[
                        'detail_movie_id' => $newId->id,
                        'link' => $value,
                        'created_at' => $newDate,
                    ]);
                }
            }
            link_movie::insert($newArray);
            return response()->json(['title'=>'Success', 'text'=>'Success insert detail movie data!'], 201);
        }
    }

    public function delete($id)
    {
        $data = detail_movie::find($id);
        $data->delete();
        return response()->json(['title'=>'Success', 'text'=>'Success delete movie detail!'], 200);
    }
}

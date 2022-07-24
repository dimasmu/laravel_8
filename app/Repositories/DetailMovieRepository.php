<?php

namespace App\Repositories;

//Utility
use Datatables;
//Models
use App\Models\detail_movie;
use App\Models\link_movie;
use Carbon\Carbon;

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
                'link' => html_entity_decode($data->link),
                'view' => $data->view,
                'like' => $data->like,
                'dislike' => $data->dislike,
                'created_at' => Carbon::parse($data->created_at)->format('d M Y'),
                'updated_at' => Carbon::parse($data->updated_at)->format('d M Y'),
                'link' => $data->getLink

            ];
            return $array;
        });

        return Datatables()->of($data)
        ->addIndexColumn()
        ->addColumn('link_aja', function($row){
            $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>';
            return $btn;
        })
        ->make(true);
      }
    }

    public function save($request)
    {
        $newDate = date("Y-m-d H:i:s");
        $validatedData = $request->validate([
            'movieId' => 'required'
        ]);
        $data = $request->all();
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
        return response()->json(['title'=>'Success', 'text'=>'Success insert detail movie!'], 201);
    }
}

<?php

namespace App\Repositories;

//Models
use App\Models\detail_movie;

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
    // dd($data);
    // $dataRelate = detail_movie::find(1)->getLink();
    return $data;
 }
}

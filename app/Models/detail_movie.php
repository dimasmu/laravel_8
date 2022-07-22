<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_movie extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'link' => 'array'
    ];

    protected $table = 'detail_movie';

    public function getLink(){
        return $this->hasMany(link_movie::class, 'detail_movie_id', 'id');
    }
}

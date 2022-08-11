<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class link_movie extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'link_movie';

    public function resolution_join()
    {
        return $this->hasOne(Standard_field_detail::class,'id','resolution');
    }
}

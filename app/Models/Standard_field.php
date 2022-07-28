<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standard_field extends Model
{
    use HasFactory;
    // public function StandardField() {
    //     return $this->belongsTo(Movie:c);
    // }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'standard_field';
    public function group(){
        return $this->hasMany(Standard_field_detail::class, 'group', 'id');
    }
}

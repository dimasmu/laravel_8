<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardField extends Model
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
}

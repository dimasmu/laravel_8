<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a=array(1,2,3,4,5);
        $n=2;
        $pushArray = [];
        $get = array_values(array_intersect_key( $a, array_flip( array_rand( $a, $n ) ) ));
        // var_dump($get);
        DB::table('movie')->insert([
            'title' => Str::random(10),
            'category' => json_encode($get)
        ]);
    }
}

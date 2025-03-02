<?php
namespace App\Classes;

use Faker\Generator as Faker;

class Fake{

    protected $faker;
    public function __construct(Faker $fake) {
        fake() = $fake;
        if (fake() === null) {
            debug_logs("Faker instance is null!");
        }
    }
    public function words($ch=2){
        // return fake()->words($ch,true);
        return fake()->unique()->words($ch,true);
    }

    public function name(){
        debug_logs(fake());
        return fake()->name;
    }

    public function email(){
        debug_logs(fake());
        // return fake()->email();
        return fake()->unique()->safeEmail;
    }

    public function sentence(){
        return fake()->sentence();
    }

    public function paragraphs($sentences=3){
        return fake()->paragraphs($sentences,true);
    }

    public function randomElement($array){
        return fake()->randomElement($array);
    }

    public function randomFloat($v1,$v2,$v3){
        return fake()->randomFloat($v1,$v2,$v3);
    }

    public function dateTimeBetween($v1,$v2='now'){
        return fake()->dateTimeBetween($v1,$v2);
    }
}
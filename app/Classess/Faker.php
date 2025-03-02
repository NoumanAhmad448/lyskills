<?php
namespace App\Classes;

class Faker{

    private $faker;
    public function __construct() {
        $this->faker = fake();
    }
    public function words($ch=2){
        return $this->faker->unique()->words($ch,true);
    }

    public function name(){
        return $this->faker->name;
    }

    public function email(){
        return $this->faker->unique()->safeEmail;
    }

    public function sentence(){
        return $this->faker->sentence();
    }

    public function paragraphs($sentences=3){
        return $this->faker->paragraphs($sentences,true);
    }

    public function randomElement($array){
        return $this->faker->randomElement($array);
    }
}
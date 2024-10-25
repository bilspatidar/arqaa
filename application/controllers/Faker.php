<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Faker-master/src/autoload.php';

//use Faker\Factory as Faker;

class Faker extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Create a new instance of Faker
        //$this->faker = Faker::create();
		 $this->faker = Faker\Factory::create();
    }
    
    public function generate_fake_data() {
     
      echo"name ".$fake_name = $this->faker->name;
      echo"<br>address ".$fake_address = $this->faker->address;
	   echo"<br>city ".$fake_name = $this->faker->city;
	   echo"<br>state ".$fake_name = $this->faker->state;
	   echo"<br>country ".$fake_name = $this->faker->country;
	   echo"<br>email ".$fake_name = $this->faker->email;
	   echo"<br>pincode ".$fake_name = $this->faker->postcode;
	   echo "<br> Description". $this->faker->text($maxNbChars = 50);
	    $minDate = date('Y-m-d', strtotime('-15 years'));

        // Generate a fake date of birth within the specified range
       echo"<br>DOB". $fake_date_of_birth = $this->faker->streetAddress;
	   echo "<br>Phone".$this->faker->phoneNumber;
       
    }
}

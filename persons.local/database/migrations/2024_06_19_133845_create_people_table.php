<?php

use App\Enum\PersonGender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->enum('gender', array_column(PersonGender::cases(), 'value'))->comment('Gender');

            //in the test task it was required to use age, but it is better to specify the date of birth
            //$table->date('birth_date')->comment('Дата народження');
            $table->integer('age');

            //following columns may be nullable since the person not always has such data
            $table->string('mobile_number')->nullable();
            $table->string('car_model')->nullable();
            $table->string('city')->nullable();
            $table->bigInteger('salary')->default(0)->comment('person salary in cent');

            /* In the test task it was necessary to create a column with
               the name of the city, but it would be better
               to create a separate table of cities and connect
               it to a person table using a foreign key
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities');

            In the test task it was necessary to create column with
               the model of the car, but it would be better
               to create 2 separate tables "cars" and "person_cars" and connect
               it to a person table using a foreign keys "car_id" and "person_id"

            ---------- POSSIBLE EXAMPLE of code during creation the "person_cars" table ---------
            $table->bigInteger('person_id')->unsigned();
            $table->foreign('person_id')->references('id')->on('people');
            $table->bigInteger('car_id')->unsigned();
            $table->foreign('car_id')->references('id')->on('cars');
            $table->string('color');
            $table->string('model');
            .... //other car's attributes related to the person's car
            */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};

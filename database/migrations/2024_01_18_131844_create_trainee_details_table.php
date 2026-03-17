<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainee_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('trainee_id')->default(0);
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->date('dob')->nullable();
            $table->integer('age')->default(0);
            $table->string('fitness_goal')->nullable(0);
            $table->integer('membership_plan')->default(0);
            $table->integer('trainer_assign')->default(0);
            $table->date('membership_start_date')->nullable();
            $table->date('membership_expiry_date')->nullable();
            $table->string('gender')->nullable();
            $table->integer('category')->default(0);
            $table->integer('parent_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainee_details');
    }
};

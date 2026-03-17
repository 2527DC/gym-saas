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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('event_type_id')->nullable();
            $table->integer('parent_id');
            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description');
            $table->integer('status')->comment('1 => scheduled, 2 => ongoing, 3 => completed, 4 => cancelled');
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
        Schema::dropIfExists('events');
    }
};

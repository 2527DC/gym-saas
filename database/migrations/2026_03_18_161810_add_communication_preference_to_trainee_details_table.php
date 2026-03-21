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
        Schema::table('trainee_details', function (Blueprint $table) {
            $table->enum('communication_preference', ['sms', 'email', 'both'])->default('email')->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainee_details', function (Blueprint $table) {
            $table->dropColumn('communication_preference');
        });
    }
};

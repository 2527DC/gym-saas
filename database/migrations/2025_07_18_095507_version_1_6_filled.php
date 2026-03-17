<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trainee_details', function (Blueprint $table) {
            $table->string('document')->nullable()->after('age');

        });
        Schema::table('trainer_details', function (Blueprint $table) {
            $table->string('document')->nullable()->after('dob');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->integer('status')->nullable()->after('notes');
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
            $table->dropColumn('document');
        });

        Schema::table('trainer_details', function (Blueprint $table) {
            $table->dropColumn('document');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

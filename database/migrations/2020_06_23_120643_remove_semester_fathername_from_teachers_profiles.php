<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSemesterFathernameFromTeachersProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers_profiles', function (Blueprint $table) {
            $table->dropColumn(['semester', 'fathername']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers_profiles', function (Blueprint $table) {
            $table->string('semester');
            $table->string('fathername');
        });
    }
}

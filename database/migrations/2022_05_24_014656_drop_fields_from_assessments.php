<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFieldsFromAssessments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn('assessment_version');
            $table->dropColumn('resource_url');
            $table->dropColumn('assessment_reason');
            $table->dropColumn('assessment_result');
            $table->dropColumn('fuji_result');
        });
    }

    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->string('assessment_version');
            $table->string('resource_url')->nullable();
            $table->string('assessment_reason');
            $table->json('assessment_result');
            $table->json('fuji_result')->nullable();
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("assessment_id");
            $table->foreign('assessment_id')->references('id')->on('assessments');
            $table->string('assessment_version');
            $table->string('resource_url')->nullable();
            $table->string('assessment_reason')->nullable();
            $table->json('assessment_result');
            $table->json('fuji_result')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}

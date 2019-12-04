<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('professor_acronyme', 3);
            $table->string('course_id', 5);
            $table->string('group_id', 5);
            $table->integer('quadrimester'); // TODO: check between 1 and 6

            $table->foreign('professor_acronyme')->references('acronyme')->on('professeurs')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('group_id')->references('nom')->on('groupes')->onDelete('cascade');

            $table->unique(['professor_acronyme', 'course_id', 'group_id']);
            $table->unique(['course_id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributions');
    }
}

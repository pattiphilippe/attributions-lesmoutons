<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->string('id', 5)->primary();
            $table->string('title',100)->unique();
            $table->integer('credits'); //TODO : max = 30.
            $table->integer('BM1_hours');//todo
            $table->integer('BM2_hours');//todo
        });
        DB::statement("ALTER TABLE courses ADD CONSTRAINT check_max_credits CHECK(credits BETWEEN 0 AND 30)");
        //mysql ignore check option https://stackoverflow.com/questions/38223158/laravel-migration-adding-check-constraints-in-table
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}

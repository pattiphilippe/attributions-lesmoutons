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
            $table->string('title', 50)->unique();
            $table->integer('credits'); 
            $table->integer('bm1_hours');//todo
            $table->integer('bm2_hours');//todo
        });
        DB::statement("ALTER TABLE courses ADD CONSTRAINT check_credits CHECK(credits BETWEEN 1 AND 30)");
        DB::statement("ALTER TABLE courses ADD CONSTRAINT check_bm1Hours CHECK(bm1_hours BETWEEN 1 AND 225)");
        DB::statement("ALTER TABLE courses ADD CONSTRAINT check_bm2Hours CHECK(bm2_hours BETWEEN 1 AND 225)");
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

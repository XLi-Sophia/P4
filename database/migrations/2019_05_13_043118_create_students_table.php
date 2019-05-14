<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate (init)
     * php artisan migrate:fresh (drop all tables, create it)
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('grade');
            $table->decimal('reading_level', 1,1);
            $table->integer('fluency_level');
            $table->string('category');
            $table->string('team');
        });
    }

    /**
     * Reverse the migrations.
     * php artisan migrate:rollback
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}

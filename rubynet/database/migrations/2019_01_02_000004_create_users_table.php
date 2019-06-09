<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('first_name_kana')->nullable();
            $table->string('last_name_kana')->nullable();
            $table->string('nick_name')->nullable();
            $table->string('current_job')->nullable();
            $table->string('former_job')->nullable();
            $table->string('hobbies')->nullable();
            $table->string('location')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('student_circles')->nullable();
            $table->string('one_word')->nullable();
            $table->string('picture')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('entry_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('internal_phone_number')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('verified')->default(User::UNVERIFIED_USER);
            $table->string('verification_token')->nullable();
            $table->string('admin')->default(User::REGULAR_USER);     
            $table->integer('department_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->integer('job_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('job_id')->references('id')->on('jobs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

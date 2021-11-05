<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('relation_id');
            $table->string('title');
            $table->longText('description');
            $table->enum('status',['done','affected','in progress','draft']);
            $table->foreign('relation_id')
                ->references('id')
                ->on('relations')
                ->onDelete('cascade'); //set null if we want to keep the tasks data related to the deleted user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}

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
            $table->string('id', 100)->primary();
            $table->unsignedInteger('relation_id');
            $table->string('title');
            $table->longText('description');
            $table->unsignedInteger('status_id');
            $table->date('deadline')->nullable();
            $table->foreign('relation_id')
                ->references('id')
                ->on('relations');
                //->onDelete('cascade'); //set null if we want to keep the tasks data related to the deleted user
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses');
            $table->timestamps();
            $table->softDeletes();
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

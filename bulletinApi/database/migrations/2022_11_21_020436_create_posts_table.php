<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->text('description');
            $table->integer('status')->default(1);
            $table->integer('created_user_id');
            $table->integer('updated_user_id');
            $table->integer('deleted_user_id')
                ->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->softDeletes('deleted_at')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');          // penerima notif
            $table->string('type');                         // 'new_task', 'update_task', 'finish_task'
            $table->string('title');
            $table->text('message')->nullable();
            $table->unsignedBigInteger('task_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index('user_id');
            $table->index('task_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportChatsTable extends Migration
{
    public function up()
    {
        Schema::create('support_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->string('sender'); // 'user' или 'bot'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('support_chats');
    }
};

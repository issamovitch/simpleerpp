<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailboxMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailbox_messages', function (Blueprint $table) {
            $table->id();
            $table->integer("from");
            $table->integer("to");
            $table->integer("label_id")->nullable();
            $table->string("subject")->nullable();
            $table->text("text")->nullable();
            $table->tinyInteger("read")->default(0);
            $table->tinyInteger("favorite")->default(0);
            $table->tinyInteger("draft")->default(0);
            $table->tinyInteger("trash")->default(0);
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
        Schema::dropIfExists('mailbox_messages');
    }
}

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
        Schema::create('comment_logs', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->text('old_comment')->nullable();
            $table->text('new_comment');
            $table->string('action'); // 'create', 'update', or 'delete'
            $table->timestamps();
            
            $table->foreign('email')
                  ->references('email')
                  ->on('user_profiles')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_logs');
    }
};

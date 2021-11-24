<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streams', function (Blueprint $table) {
            $table->id();
            $table->string('channel_name')->nullable();
            $table->string('stream_title')->nullable();
            $table->integer('viewer_count')->default(0);
            $table->string('start_date')->nullable();
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
        Schema::dropIfExists('streams');
    }
}

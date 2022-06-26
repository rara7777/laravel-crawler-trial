<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_logs', function (Blueprint $table) {
            $table->id();
            $table->string('input_url');
            $table->string('url');
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->longText('raw_body')->nullable();
            $table->longText('parsed_body')->nullable();
            $table->string('screenshot')->default('');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('crawl_logs');
    }
}

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');
            $table->foreignId('category_id');

            $table->string('name');
            $table->double('price');
            $table->text('url_daraz');
            $table->text('url_krave');
            $table->text('url_dvago');
            $table->text('short_desc')->nullable();
            $table->text('specification')->nullable();

            $table->boolean('status')->default(0);

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
        Schema::dropIfExists('products');
    }
};

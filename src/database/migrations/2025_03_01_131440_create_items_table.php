<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('profiles')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('condition_id')->constrained();
            $table->string('image_path');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->unsignedInteger('price');
            $table->text('detail');
            $table->boolean('sold_flag');
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
        Schema::dropIfExists('items');
    }
}

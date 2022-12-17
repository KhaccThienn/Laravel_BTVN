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
            $table->increments('id');
            $table->string('name');
            $table->float('price', 20, 3);
            $table->float('sale_price', 20, 3)->nullable()->default(0);
            $table->text('image');
            $table->integer('category_id')->unsigned();
            $table->tinyInteger('status')->default(1);
            $table->text('description')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->softDeletes();
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropForeign('products_category_id_foreign');
        });;
        Schema::dropIfExists('products');
    }
};

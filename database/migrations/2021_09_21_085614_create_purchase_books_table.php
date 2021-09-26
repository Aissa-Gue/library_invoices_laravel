<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_books', function (Blueprint $table) {
            $table->foreignId('purchase_id')->references('id')->on('purchases');
            $table->foreignId('book_id')->references('id')->on('books');
            $table->integer('quantity');
            $table->integer('purchase_price');
            $table->timestamps();
            $table->softDeletes();
            $table->primary(array('purchase_id','book_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_books');
    }
}

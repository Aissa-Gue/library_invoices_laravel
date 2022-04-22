<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_books', function (Blueprint $table) {
			$table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
			
			$table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books');
            
			$table->integer('quantity');
            $table->integer('purchase_price');
            $table->integer('sale_price');
            $table->timestamps();
            $table->softDeletes();
            $table->primary(array('order_id','book_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_books');
    }
}

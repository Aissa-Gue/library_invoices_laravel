<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books');
			
            $table->integer('quantity');
            $table->integer('sale_price');
			
			$table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
			
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
			
			$table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('person_id')->on('clients');
			
			$table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
			
			$table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
            
			$table->string('type',10);
            $table->decimal('discount_percentage',3,0)->default(0);
            $table->float('paid_amount')->default(0);
            $table->float('required_amount');
            $table->timestamps();
            $table->softDeletes();
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

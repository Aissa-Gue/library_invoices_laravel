<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
			
			$table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('person_id')->on('providers');
			
			$table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
			
			$table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
            
			$table->float('paid_amount')->default(0);
            $table->float('required_amount')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}

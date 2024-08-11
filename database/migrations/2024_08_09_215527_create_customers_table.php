<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('customer_id')->unique(); 
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company');
            $table->string('city');
            $table->string('country');
            $table->string('phone_1');
            $table->string('phone_2')->nullable(); // Allow nulls as some might be missing
            $table->string('email')->unique();
            $table->date('subscription_date');
            $table->string('website');
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
        Schema::dropIfExists('customers');
    }
}

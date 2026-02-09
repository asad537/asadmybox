<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name')->nullable();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone')->nullable();
            
            // Dimensions
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('unit')->nullable(); // e.g. inch, cm
            
            $table->string('stock')->nullable(); // Material/Stock
            $table->string('color')->nullable();
            $table->string('coating')->nullable();
            $table->string('quantity')->nullable();
            
            $table->string('file_url')->nullable();
            $table->text('message')->nullable();
            $table->string('subject')->nullable();
            
            // Spam detection
            $table->boolean('is_spam')->default(false);
            $table->string('spam_reason')->nullable();
            
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
        Schema::dropIfExists('crm_emails');
    }
}

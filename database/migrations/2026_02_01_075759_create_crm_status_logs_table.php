<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmStatusLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_status_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('crm_email_id');
            $table->string('user_name'); // Logging user's name directly for simplicity + history preservation
            $table->string('old_status')->nullable();
            $table->string('new_status');
            $table->timestamps();

            // Foreign key constraint (optional, but good practice)
            $table->foreign('crm_email_id')->references('id')->on('crm_emails')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crm_status_logs');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAndSoftDeletesToCrmEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_emails', function (Blueprint $table) {
            $table->string('status')->default('New')->after('spam_reason');
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
        Schema::table('crm_emails', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropSoftDeletes();
        });
    }
}

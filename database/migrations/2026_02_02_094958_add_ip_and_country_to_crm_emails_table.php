<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIpAndCountryToCrmEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_emails', function (Blueprint $table) {
            $table->string('ip_address')->nullable()->after('subject');
            $table->string('country')->nullable()->after('ip_address');
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
            $table->dropColumn(['ip_address', 'country']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserOAuthAddition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('login', 30)->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('github_id')->nullable()->unique();
            $table->dateTime('github_login_date')->nullable();
            $table->dateTime('github_registration_date')->nullable();
            $table->string('google_id')->nullable()->unique();
            $table->dateTime('google_login_date')->nullable();
            $table->dateTime('google_registration_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('login', 30)->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
            $table->dropColumn(['github_id', 'github_login_date', 'github_registration_date', 'google_id', 'google_login_date', 'google_registration_date']);
        });
    }
}

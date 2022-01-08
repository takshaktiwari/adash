<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('profile_img', 255)->after('name')->nullable()->default(null);
            $table->string('mobile')->after('email')->nullable()->default(null);
            $table->string('google_id')->after('email')->nullable()->default(null);
            $table->string('facebook_id')->after('email')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn([
                'profile_img',
                'mobile',
                'google_id',
                'facebook_id',
            ]);
        });
    }
}

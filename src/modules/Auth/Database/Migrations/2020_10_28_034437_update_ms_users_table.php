<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ms_users', function (Blueprint $table) {
            $table->renameColumn('picture', 'avatar');
            $table->string('phone_number', 10)->nullable();
            $table->string('address', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_users', function (Blueprint $table) {
            $table->renameColumn('avatar', 'picture');
            $table->dropColumn('phone_number');
            $table->dropColumn('address');
        });
    }
};

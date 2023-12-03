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
            $table->dropColumn('avatar');
            $table->dropColumn('gender');
            $table->string('email')->unique(false)->change();
            $table->uuid('created_by')->nullable();
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
            $table->string('avatar')->nullable();
            $table->tinyInteger('gender')->default(0);
            $table->string('email', 50)->unique();
            $table->dropColumn('created_by');
        });
    }
};

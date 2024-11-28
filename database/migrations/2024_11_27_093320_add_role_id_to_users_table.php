<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');  // Foreign key column for roles table
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade'); // Foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);  // Drop the foreign key constraint
            $table->dropColumn('role_id');     // Drop the role_id column
        });
    }
};

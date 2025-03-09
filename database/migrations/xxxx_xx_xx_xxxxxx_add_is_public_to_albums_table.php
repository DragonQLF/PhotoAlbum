<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPublicToAlbumsTable extends Migration
{
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->boolean('is_public')->default(false);
        });
    }

    public function down()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('is_public');
        });
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cups', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->enum("level",["bronze","gold","diamond","silver"]);
            $table->unsignedBigInteger("user_infos");
            $table->foreign('user_infos')->references('id')->on('user_infos')->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cups');
    }
};

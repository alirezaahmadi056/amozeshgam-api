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
        Schema::create('sub_field_videos', function (Blueprint $table) {
            $table->id();
            $table->text("video");
            $table->unsignedBigInteger("sub_fields_id");
            $table->foreign('sub_fields_id')->references('id')->on('sub_fields')->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_field_videos');
    }
};

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
        Schema::create('sub_fields', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("image");
            $table->text("description");
            $table->integer("price");
            $table->integer("time");
            $table->unsignedBigInteger("field_id");
            $table->foreign('field_id')->references('id')->on('fields')->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_fields');
    }
};

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
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('doc_id')->unique();
            $table->string('category')->nullable();
            $table->unsignedInteger('patients')->nullable();
            $table->unsignedInteger('experience')->nullable();
            $table->longText('bio_data')->nullable();
            $table->string('status')->nullable();
            //this is state that this doc_id is refer to id on users table
            $table->foreign('doc_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

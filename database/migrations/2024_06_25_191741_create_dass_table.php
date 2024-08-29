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
        Schema::create('dass', function (Blueprint $table) {
            $table->increments('id'); // Primary Key
            $table->unsignedBigInteger('user_id'); // Foreign Key
            $table->integer('depression_score');
            $table->integer('anxiety_score');
            $table->integer('stress_score');
            $table->integer('category'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dass');
    }
};

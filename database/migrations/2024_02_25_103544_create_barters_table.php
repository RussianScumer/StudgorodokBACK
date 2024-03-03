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
        Schema::create('barters', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('title');
            $table->string('comments');
            $table->string('contacts');
            $table->string("price");
            $table->string('img');
            $table->string('stud_number');
            $table->string('sender_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barters');
    }
};

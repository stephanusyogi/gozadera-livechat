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
        Schema::create('song_requests', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID primary key
            $table->string('id_event');
            $table->foreign('id_event')->references('id')->on('events');
            $table->string('id_table')->nullable(); // String to store the id_table value
            $table->string('sender_name'); // Name of the sender
            $table->string('sender_email'); // Email of the sender
            $table->string('sender_unique_char'); // Unique char or identifier for the sender
            $table->string('ip_address')->nullable(); // Optional IP address, nullable
            $table->string('song_name'); // Name of the requested song
            $table->string('artist_name'); // Artist of the requested song
            $table->boolean('flag_done')->nullable()->default(false); // Flag to mark if the request is completed
            $table->timestamps(); // Laravel created_at and updated_at columns
            $table->softDeletes(); // Soft delete column to mark records as deleted without removing them
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_requests');
    }
};

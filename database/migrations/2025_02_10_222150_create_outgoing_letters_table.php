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
        Schema::create('outgoing_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number')->unique();
            $table->date('letter_date');
            $table->string('subject');
            
            $table->enum('sender_type', ['Internal', 'External']);
            $table->foreignId('external_sender_id')->nullable()->constrained('externals');
            $table->foreignId('internal_sender_id')->nullable()->constrained('users');

            $table->enum('recipient_type', ['Internal', 'External']);
            $table->foreignId('internal_recipient_id')->nullable()->constrained('users');
            $table->foreignId('external_recipient_id')->nullable()->constrained('externals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_letters');
    }
};

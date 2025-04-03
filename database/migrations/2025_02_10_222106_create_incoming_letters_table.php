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
        Schema::create('incoming_letters', function (Blueprint $table) {
            $table->id();
            $table->string('agenda_number')->unique();
            $table->string('letter_number');
            $table->date('letter_date');
            
            $table->enum('sender_type', ['Internal', 'External']);
            $table->foreignId('internal_sender_id')->nullable()->constrained('users');
            $table->foreignId('external_sender_id')->nullable()->constrained('externals');

            $table->enum('status', ['Menunggu Persetujuan', 'Tidak Disetujui', 'Selesai dan Terdistribusi'])->default('Menunggu Persetujuan');

            $table->string('subject');  
            $table->date('received_date');
            $table->time('received_time');
            $table->string('recipient');

            $table->enum('classification_letter', ['Akademik', 'Keuangan', 'Kemahasiswaan', 'Umum']);
            $table->enum('category_letter', ['Rahasia', 'Segera', 'Penting', 'Biasa']);

            $table->string('attachment')->nullable();
            $table->text('resume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_letters');
    }
};

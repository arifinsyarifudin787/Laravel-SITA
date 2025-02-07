<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasAkhirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas_akhirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mhs_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            $table->text('judul');
            $table->enum('status', ['diajukan', 'disetujui', 'selesai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tugas_akhirs');
    }
}

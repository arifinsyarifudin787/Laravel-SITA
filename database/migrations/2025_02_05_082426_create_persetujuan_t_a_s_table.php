<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersetujuanTASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persetujuan_t_a_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tugas_akhir_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('dosen_id')
                  ->constrained('users')
                  ->nullOnDelete();
            $table->enum('status', ['disetujui', 'ditolak']);
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
        Schema::dropIfExists('persetujuan_t_a_s');
    }
}

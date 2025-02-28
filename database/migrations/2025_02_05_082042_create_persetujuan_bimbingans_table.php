<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersetujuanBimbingansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persetujuan_bimbingans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bimbingan_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignUuid('dosen_id')
                  ->constrained('users')
                  ->nullOnDelete();
            $table->enum('status', ['diajukan', 'disetujui', 'ditolak']);
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
        Schema::dropIfExists('persetujuan_bimbingans');
    }
}

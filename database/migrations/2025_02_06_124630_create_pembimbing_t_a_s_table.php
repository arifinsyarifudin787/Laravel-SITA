<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembimbingTASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembimbing_t_a_s', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('dosen_id')
                  ->constrained('users')
                  ->nullOnDelete();
            $table->enum('peran', ['pembimbing_1', 'pembimbing_2']);
            $table->foreignUuid('mhs_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
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
        Schema::dropIfExists('pembimbing_t_a_s');
    }
}

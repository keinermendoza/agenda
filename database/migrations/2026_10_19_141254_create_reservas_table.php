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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->dateTime('começo');
            $table->dateTime('fim')->nullable();
            $table->decimal('preço');
            $table->decimal('valor_pago')->default(0);
            $table->boolean('personalizado')->default(false);

            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->foreignId('reserva_status_id')->nullable()->constrained()->nullOnDelete();
            $table->text('notas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};

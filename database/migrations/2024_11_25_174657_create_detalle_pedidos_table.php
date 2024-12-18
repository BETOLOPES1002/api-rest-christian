<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedidos_id')->constrained('pedidos');
            $table->foreignId('productos_id')->constrained('productos');
            $table->integer('cantidad');
            $table->decimal('precio',8,2);
            $table->timestamps();

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};

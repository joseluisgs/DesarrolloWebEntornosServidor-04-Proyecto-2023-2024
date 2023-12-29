<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->default(Str::uuid());
            $table->string('marca');
            $table->string('modelo');
            $table->string('descripcion');
            $table->string('imagen')->default('https://via.placeholder.com/150');
            $table->decimal('precio', 10, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->enum('categoria', ['COMIDA', 'DEPORTES', 'OCIO', 'BEBIDA', 'OTRO'])->default('OTRO');
            $table->boolean('isDeleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};

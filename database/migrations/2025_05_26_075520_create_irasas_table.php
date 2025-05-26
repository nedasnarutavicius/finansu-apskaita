<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('irasai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategorija_id')->constrained('kategorijos')->onDelete('cascade');
            $table->foreignId('tipas_id')->constrained('tipai')->onDelete('cascade');
            $table->decimal('suma', 10, 2);
            $table->string('aprasymas')->nullable();
            $table->date('data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('irasai');
    }
};

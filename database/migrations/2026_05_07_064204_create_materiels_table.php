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
        Schema::create('materiels', function (Blueprint $table) {
            $table->id();
            $table->string('modele');
            $table->text('description')->nullable();
            $table->string('etat');
            $table->foreignId('categorie_materiel_id')->constrained('categorie_materiels')->onDelete('cascade');
            $table->foreignId('marque_id')->constrained('marques')->onDelete('cascade');
            $table->foreignId('type_materiel_id')->constrained('types_materiels')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiels');
    }
};

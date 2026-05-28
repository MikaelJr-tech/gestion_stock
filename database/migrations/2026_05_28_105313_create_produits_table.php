<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('famille_id')->constrained('familles_produits')->onDelete('cascade');
            $table->foreignId('produit_parent_id')->nullable()->constrained('produits')->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('nom');
            $table->string('unite');
            $table->decimal('prix_achat', 15, 2)->default(0);
            $table->decimal('prix_vente', 15, 2)->default(0);
            $table->integer('stock_actuel')->default(0);
            $table->integer('stock_minimum')->default(0);
            $table->date('date_expiration')->nullable();
            $table->enum('type', ['simple', 'père', 'fils'])->default('simple');
            $table->decimal('facteur_fraction', 10, 4)->default(1);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('produits');
    }
};

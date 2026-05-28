<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('factures_fournisseur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('bon_commande_id')->nullable()->constrained('bons_commande_fournisseur')->onDelete('cascade');
            $table->foreignId('fournisseur_id')->constrained('fournisseurs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('numero')->unique();
            $table->date('date_facture');
            $table->date('date_echeance')->nullable();
            $table->decimal('montant_ht', 15, 2);
            $table->decimal('tva', 5, 2)->default(0);
            $table->decimal('montant_ttc', 15, 2);
            $table->decimal('montant_regle', 15, 2)->default(0);
            $table->enum('statut', ['impayée', 'partielle', 'réglée'])->default('impayée');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('factures_fournisseur');
    }
};

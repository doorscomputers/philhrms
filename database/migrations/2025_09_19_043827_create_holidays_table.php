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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->date('date');
            $table->enum('type', ['Regular', 'Special Non-Working', 'Special Working']);
            $table->enum('scope', ['National', 'Regional', 'Local', 'Company']);
            $table->text('description')->nullable();
            $table->decimal('pay_multiplier', 4, 2)->default(1.00);
            $table->boolean('is_recurring')->default(false);
            $table->json('applicable_branches')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'date']);
            $table->index(['date', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};

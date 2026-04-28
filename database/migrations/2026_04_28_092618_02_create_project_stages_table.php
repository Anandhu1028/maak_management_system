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
        Schema::create('project_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('name');
            $table->decimal('budget', 15, 3);
            $table->decimal('weight_percentage', 5, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('client_payment_amount', 15, 3);
            $table->decimal('completion_percentage', 5, 2)->default(0);
            $table->enum('status', ['Not Started', 'In Progress', 'Completed', 'Locked'])->default('Not Started');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_stages');
    }
};

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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('stage_id')->constrained('project_stages')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('category', ['Material', 'Labour', 'Transport', 'Miscellaneous']);
            $table->decimal('amount', 15, 3);
            $table->date('date');
            $table->text('description')->nullable();
            $table->string('invoice_path')->nullable();
            $table->enum('status', ['Unverified', 'Approved', 'Rejected'])->default('Unverified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};

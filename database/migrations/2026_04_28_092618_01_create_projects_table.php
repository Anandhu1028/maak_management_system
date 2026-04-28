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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Interior Design', 'Civil Construction', 'Maintenance']);
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->text('site_address');
            $table->decimal('project_value', 15, 3);
            $table->decimal('estimated_internal_cost', 15, 3);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Completed', 'On Hold', 'Cancelled'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

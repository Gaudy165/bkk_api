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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->year('graduation_year')->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('resume_path')->nullable();
            $table->enum('status', ['not_processed', 'in_progress', 'accepted', 'rejected'])->default('not_processed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('job_applications', 'job_vacancies');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('job_vacancies', 'job_applications');
    }
};

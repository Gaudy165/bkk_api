<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            if (!Schema::hasColumn('job_vacancies', 'date_posted')) {
                $table->timestamp('date_posted')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->date('date_posted')->nullable()->change();
        });
    }
};

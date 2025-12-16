<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {

            // kolom sisa job_application
            if (Schema::hasColumn('job_vacancies', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('job_vacancies', 'graduation_year')) {
                $table->dropColumn('graduation_year');
            }

            if (Schema::hasColumn('job_vacancies', 'graduation_date')) {
                $table->dropColumn('graduation_date');
            }

            if (Schema::hasColumn('job_vacancies', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('job_vacancies', 'phone')) {
                $table->dropColumn('phone');
            }

            if (Schema::hasColumn('job_vacancies', 'resume_path')) {
                $table->dropColumn('resume_path');
            }

            if (Schema::hasColumn('job_vacancies', 'status')) {
                $table->dropColumn('status');
            }
        });
    }

    public function down(): void
    {
        // kosongkan, ini migration perbaikan
    }
};


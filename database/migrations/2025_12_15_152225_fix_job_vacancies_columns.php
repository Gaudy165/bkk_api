<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {

            if (!Schema::hasColumn('job_vacancies', 'company')) {
                $table->string('company')->nullable()->after('id');
            }

            if (!Schema::hasColumn('job_vacancies', 'position')) {
                $table->string('position')->nullable()->after('company');
            }

            if (!Schema::hasColumn('job_vacancies', 'location')) {
                $table->string('location')->nullable()->after('position');
            }

            if (!Schema::hasColumn('job_vacancies', 'salary')) {
                $table->string('salary')->nullable();
            }

            if (!Schema::hasColumn('job_vacancies', 'start_date')) {
                $table->date('start_date')->nullable();
            }

            if (!Schema::hasColumn('job_vacancies', 'end_date')) {
                $table->date('end_date')->nullable();
            }

            if (!Schema::hasColumn('job_vacancies', 'description')) {
                $table->text('description')->nullable();
            }

            if (!Schema::hasColumn('job_vacancies', 'qualifications')) {
                $table->json('qualifications')->nullable();
            }

            if (!Schema::hasColumn('job_vacancies', 'benefits')) {
                $table->json('benefits')->nullable();
            }
        });
    }

    public function down(): void
    {
        // ❗ kosongkan saja, ini migration perbaikan
    }
};


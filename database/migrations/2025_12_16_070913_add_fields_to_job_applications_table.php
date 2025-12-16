<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('job_applications', function (Blueprint $table) {

        // 1️⃣ RELASI KE JOB VACANCIES (WAJIB DULU)
        $table->foreignId('job_vacancy_id')
            ->constrained('job_vacancies')
            ->cascadeOnDelete();

        // 2️⃣ RELASI KE MAJORS
        $table->foreignId('major_id')
            ->after('job_vacancy_id')
            ->constrained('majors')
            ->restrictOnDelete();

        // 3️⃣ DATA PELAMAR
        $table->string('full_name', 150);
        $table->string('nis_nisn', 30)->nullable();
        $table->date('birth_date')->nullable();
        $table->enum('gender', ['male', 'female'])->nullable();
        $table->text('address')->nullable();
        $table->string('phone', 30)->nullable();
        $table->string('email', 150);
        $table->year('graduation_year')->nullable();
        $table->decimal('gpa', 5, 2)->nullable();
        $table->text('work_experience')->nullable();
        $table->text('apply_reason')->nullable();

        // 4️⃣ FILE
        $table->string('resume_path')->nullable();
        $table->string('certificate_path')->nullable();
        $table->string('photo_path')->nullable();
        $table->string('cover_letter_path')->nullable();

        // 5️⃣ STATUS
        $table->enum('status', ['submitted', 'reviewed', 'accepted', 'rejected'])
              ->default('submitted');

        $table->timestamp('read_at')->nullable();

        // 6️⃣ INDEX
        $table->unique(['job_vacancy_id', 'email']);
        $table->index(['job_vacancy_id', 'status']);
        $table->index('email');
    });
}


    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropUnique(['job_vacancy_id', 'email']);
            $table->dropIndex(['job_vacancy_id', 'status']);
            $table->dropIndex(['email']);
            $table->dropForeign(['job_vacancy_id']);
            $table->dropForeign(['major_id']);
            $table->dropColumn([
                'job_vacancy_id',
                'major_id',
                'full_name',
                'nis_nisn',
                'birth_date',
                'gender',
                'address',
                'phone',
                'email',
                'graduation_year',
                'gpa',
                'work_experience',
                'apply_reason',
                'resume_path',
                'certificate_path',
                'photo_path',
                'cover_letter_path',
                'status',
                'read_at',
            ]);
        });
    }
};

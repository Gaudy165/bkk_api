<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->foreignId('major_id')
                ->after('job_vacancy_id')
                ->constrained('majors')
                ->restrictOnDelete();
            $table->string('full_name', 150)->after('major_id');
            $table->string('nis_nisn', 30)->nullable()->after('full_name');
            $table->date('birth_date')->nullable()->after('nis_nisn');
            $table->enum('gender', ['male', 'female'])->nullable()->after('birth_date');
            $table->text('address')->nullable()->after('gender');
            $table->string('phone', 30)->nullable()->after('address');
            $table->string('email', 150)->after('phone');
            $table->year('graduation_year')->nullable()->after('email');
            $table->decimal('gpa', 5, 2)->nullable()->after('graduation_year');
            $table->text('work_experience')->nullable()->after('gpa');
            $table->text('apply_reason')->nullable()->after('work_experience');
            $table->string('resume_path')->nullable()->after('apply_reason');
            $table->string('certificate_path')->nullable()->after('resume_path');
            $table->string('photo_path')->nullable()->after('certificate_path');
            $table->string('cover_letter_path')->nullable()->after('photo_path');
            $table->enum('status', ['submitted', 'reviewed', 'accepted', 'rejected'])->default('submitted')->after('cover_letter_path');
            $table->timestamp('read_at')->nullable()->after('status');
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
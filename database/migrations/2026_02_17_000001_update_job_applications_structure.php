<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('company')->nullable()->after('id');
            $table->string('image_path')->nullable()->after('company');
            $table->date('date_posted')->nullable()->after('image_path');
            $table->unsignedBigInteger('views')->default(0)->after('date_posted');
            $table->date('date')->nullable()->after('views');
            $table->string('location')->nullable()->after('date');
            $table->string('position')->nullable()->change();
            $table->string('salary')->nullable()->after('position');
            $table->date('start_date')->nullable()->after('salary');
            $table->date('end_date')->nullable()->after('start_date');
            $table->text('description')->nullable()->after('end_date');
            $table->json('qualifications')->nullable()->after('description');
            $table->string('job_type')->nullable()->after('qualifications');
            $table->string('working_hours')->nullable()->after('job_type');
            $table->json('benefits')->nullable()->after('working_hours');
            $table->unsignedInteger('quota')->nullable()->after('benefits');
            $table->json('majors')->nullable()->after('quota');
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'graduation_year',
                'graduation_date',
                'email',
                'phone',
                'resume_path',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('name')->nullable()->after('id');
            $table->year('graduation_year')->nullable()->after('name');
            $table->date('graduation_date')->nullable()->after('graduation_year');
            $table->string('email')->nullable()->after('graduation_date');
            $table->string('phone', 30)->nullable()->after('email');
            $table->string('resume_path')->nullable()->after('phone');
            $table->enum('status', ['not_processed', 'in_progress', 'accepted', 'rejected'])->default('not_processed')->after('resume_path');

            $table->dropColumn([
                'company',
                'image_path',
                'date_posted',
                'views',
                'date',
                'location',
                'salary',
                'start_date',
                'end_date',
                'description',
                'qualifications',
                'job_type',
                'working_hours',
                'benefits',
                'quota',
                'majors',
            ]);
        });
    }
};

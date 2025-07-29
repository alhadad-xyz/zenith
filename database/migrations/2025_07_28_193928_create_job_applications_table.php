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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->string('job_title');
            $table->string('department')->nullable();
            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'internship'])->nullable();
            $table->text('job_url')->nullable();
            $table->string('location')->nullable();
            $table->string('salary_min')->nullable();
            $table->string('salary_max')->nullable();
            $table->longText('job_description')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('cover_letter_path')->nullable();
            $table->longText('application_notes')->nullable();
            $table->enum('status', ['applied', 'interviewing', 'offer', 'rejected', 'withdrawn'])->default('applied');
            $table->date('applied_date')->default(now());
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

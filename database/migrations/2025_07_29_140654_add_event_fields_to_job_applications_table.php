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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->datetime('interview_date')->nullable();
            $table->datetime('application_deadline')->nullable();
            $table->datetime('follow_up_date')->nullable();
            $table->text('interview_notes')->nullable();
            $table->enum('interview_type', ['phone', 'video', 'in-person', 'technical', 'final'])->nullable();
            $table->string('interview_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn([
                'interview_date',
                'application_deadline',
                'follow_up_date',
                'interview_notes',
                'interview_type',
                'interview_location'
            ]);
        });
    }
};

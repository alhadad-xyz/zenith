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
        Schema::create('application_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['application_submitted', 'interview', 'note', 'followup', 'rejected']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_date')->nullable();
            $table->string('event_time')->nullable();
            $table->string('interview_type')->nullable();
            $table->text('content')->nullable();
            $table->text('notes')->nullable();
            $table->string('action')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('priority', ['high', 'normal', 'medium', 'low'])->nullable();
            $table->text('details')->nullable();
            $table->boolean('reminder')->default(false);
            $table->string('reason')->nullable(); // For rejected events
            $table->text('feedback')->nullable(); // For rejected events
            $table->boolean('reapply_future')->default(false); // For rejected events
            $table->json('metadata')->nullable(); // For additional flexible data
            $table->timestamps();

            $table->index(['job_application_id', 'type']);
            $table->index(['job_application_id', 'event_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_events');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('queue_index');
            $table->string('queue_number');
            $table->unsignedBigInteger('counter_id');
            $table->string('code');
            $table->enum('status', ['Waiting', 'Called', 'Completed', 'Skipped'])->default('Waiting');
            $table->timestamp('called_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('skipped_at')->nullable();
            $table->timestamps();

            $table->foreign('counter_id')->references('id')->on('counters')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('queue_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('queue_id')->nullable();
            $table->string('queue_number');
            $table->unsignedBigInteger('counter_id')->nullable();
            $table->string('counter_name');
            $table->timestamps();

            $table->foreign('queue_id')->references('id')->on('queues')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('counter_id')->references('id')->on('counters')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};

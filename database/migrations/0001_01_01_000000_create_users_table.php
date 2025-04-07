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

        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('status', ['Open', 'Closed', 'Break', 'Enabled', 'Disabled'])->default('Disabled');
            $table->timestamps();
        });

        Schema::create('officers', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('name');
            $table->string('position');
            $table->unsignedBigInteger('counter_id')->nullable();
            $table->text('photo')->nullable();
            $table->enum('block', ['Y', 'N'])->defalt('Y');
            $table->timestamps();

            $table->foreign('counter_id')->references('id')->on('counters')->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('officer_id');
            $table->enum('role', ['Administrator', 'Officer'])->defaultValue('Officer');
            $table->enum('block', ['Y', 'N'])->defalt('Y');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('officer_id')->references('id')->on('officers')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('institution')->comment('Lembaga');
            $table->string('eselon')->comment('Badan Peradilan/Eselon');
            $table->string('jurisdiction')->comment('Wilayah Hukum/Pengadilan Tk. Banding');
            $table->string('unit')->comment('Satuan Kerja/Pengadilan Tk. Pertama');
            $table->text('address');
            $table->string('province');
            $table->string('city');
            $table->string('post_code');
            $table->string('email');
            $table->string('website');
            $table->string('contact');
            $table->text('logo');
            $table->text('license');
            $table->timestamps();
        });

        Schema::create('voices', function (Blueprint $table) {
            $table->id();
            $table->text('api_key');
            $table->string('language');
            $table->text('path_sound');
            $table->timestamps();
        });

        Schema::create('versions', function (Blueprint $table) {
            $table->id();
            $table->date('release_date');
            $table->string('category');
            $table->string('patch_version');
            $table->text('note');
            $table->timestamps();
        });

        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->ipAddress();
            $table->text('user_agent');
            $table->text('activity');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('versions');
        Schema::dropIfExists('logs');
    }
};

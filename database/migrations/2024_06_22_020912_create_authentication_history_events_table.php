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
        Schema::create('authentication_history_events', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); // id cu nguoi dung
            $table->ipAddress('ip_address'); // luu ip
            $table->string('event'); // luw LOGIN. FORGET_PASSWORD, UPDATE FORGET PASSWORD
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authentication_history_events');
    }
};

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
        Schema::create('my_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('is_project')->default('0');
            $table->string('self_capture')->default(1);
            $table->string('client_prefix');
            $table->string('client_logo')->default('no-image.jpg');
            $table->text('address')->nullable()->default(null);
            $table->string('phone_number')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_clients');
    }
};

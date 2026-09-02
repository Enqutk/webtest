<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique();
            $table->string('type')->default('individual'); // individual | business
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('role_title')->nullable();
            $table->string('company_name')->nullable();
            $table->string('tagline')->nullable();
            $table->text('bio')->nullable();
            $table->string('card_edition')->default('midnight_navy'); // midnight_navy | brushed_gold | executive_black
            $table->string('quote_amount')->nullable();
            $table->json('theme')->nullable();
            $table->json('highlights')->nullable();
            $table->json('social_links')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('status')->default('pending'); // pending | approved | rejected
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_applications');
    }
};

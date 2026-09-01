<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('owner');
            $table->timestamps();

            $table->unique(['organization_id', 'user_id']);
        });

        // Automatically attach existing users to the first organization
        $firstOrg = DB::table('organizations')->first();
        if ($firstOrg) {
            $users = DB::table('users')->get();
            foreach ($users as $user) {
                DB::table('organization_user')->insertOrIgnore([
                    'organization_id' => $firstOrg->id,
                    'user_id' => $user->id,
                    'role' => 'owner',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_user');
    }
};

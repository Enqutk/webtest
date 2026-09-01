<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
            $table->string('domain')->nullable()->unique()->after('slug');
        });

        // Backfill slug for existing organizations
        $orgs = DB::table('organizations')->get();
        foreach ($orgs as $org) {
            $slug = Str::slug($org->title ?: 'organization');
            $count = DB::table('organizations')->where('slug', $slug)->count();
            if ($count > 0) {
                $slug .= '-' . $org->id;
            }
            DB::table('organizations')->where('id', $org->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn(['slug', 'domain']);
        });
    }
};

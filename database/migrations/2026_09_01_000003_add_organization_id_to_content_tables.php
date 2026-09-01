<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tables = [
        'services',
        'teams',
        'entities',
        'heroes',
        'pages',
        'page_sections',
        'content_blocks',
        'menu_locations',
        'social_refs',
        'organization_contacts',
    ];

    public function up(): void
    {
        $firstOrg = DB::table('organizations')->first();
        $firstOrgId = $firstOrg?->id ?? 1;

        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (!Schema::hasColumn($tableName, 'organization_id')) {
                        $table->foreignId('organization_id')
                            ->nullable()
                            ->after('id')
                            ->constrained('organizations')
                            ->cascadeOnDelete();
                    }
                });

                // Backfill existing records with the first organization ID
                DB::table($tableName)
                    ->whereNull('organization_id')
                    ->update(['organization_id' => $firstOrgId]);
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'organization_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropConstrainedForeignId('organization_id');
                });
            }
        }
    }
};

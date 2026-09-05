<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['teams', 'entities', 'heroes', 'pages'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->unsignedTinyInteger('image_focus_x')->default(50);
                $table->unsignedTinyInteger('image_focus_y')->default(50);
            });
        }

        Schema::table('services', function (Blueprint $table) {
            $table->unsignedTinyInteger('image_focus_x')->default(50);
            $table->unsignedTinyInteger('image_focus_y')->default(50);
            $table->unsignedTinyInteger('secondary_image_focus_x')->default(50);
            $table->unsignedTinyInteger('secondary_image_focus_y')->default(50);
        });
    }

    public function down(): void
    {
        foreach (['teams', 'entities', 'heroes', 'pages'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['image_focus_x', 'image_focus_y']);
            });
        }

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'image_focus_x',
                'image_focus_y',
                'secondary_image_focus_x',
                'secondary_image_focus_y',
            ]);
        });
    }
};

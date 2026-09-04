<?php

namespace App\Support;

class AdminPreviewAttrs
{
    public static function html(string $section, string $field, string $label): string
    {
        if (! request()->boolean('admin_preview')) {
            return '';
        }

        return sprintf(
            'data-admin-section="%s" data-admin-field="%s" data-admin-compact="1" data-admin-label="%s"',
            e($section),
            e($field),
            e($label),
        );
    }
}

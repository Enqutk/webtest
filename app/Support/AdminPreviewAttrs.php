<?php

namespace App\Support;

class AdminPreviewAttrs
{
    public static function html(string $section, string $field, string $label, bool $compact = true): string
    {
        if (! request()->boolean('admin_preview')) {
            return '';
        }

        $compactAttr = $compact ? ' data-admin-compact="1"' : '';

        return sprintf(
            'data-admin-section="%s" data-admin-field="%s"%s data-admin-label="%s"',
            e($section),
            e($field),
            $compactAttr,
            e($label),
        );
    }
}

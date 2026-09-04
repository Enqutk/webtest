<?php

namespace App\Support;

class AdminPreviewAttrs
{
    public static function html(string $section, string $field, string $label, bool $compact = true, ?string $editUrl = null): string
    {
        if (! request()->boolean('admin_preview')) {
            return '';
        }

        $compactAttr = $compact ? ' data-admin-compact="1"' : '';
        $editUrlAttr = $editUrl ? ' data-admin-edit-url="' . e($editUrl) . '"' : '';

        return sprintf(
            'data-admin-section="%s" data-admin-field="%s"%s%s data-admin-label="%s"',
            e($section),
            e($field),
            $compactAttr,
            $editUrlAttr,
            e($label),
        );
    }
}

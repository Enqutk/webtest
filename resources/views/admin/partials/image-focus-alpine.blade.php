@once
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    if (window.__adminImageFocusMixin) return;
    window.__adminImageFocusMixin = true;

    Alpine.mixin({
        imageFocusFromClick(event, xProp, yProp) {
            const rect = event.currentTarget.getBoundingClientRect();
            if (!rect.width || !rect.height) return;
            this[xProp] = Math.max(0, Math.min(100, Math.round(((event.clientX - rect.left) / rect.width) * 100)));
            this[yProp] = Math.max(0, Math.min(100, Math.round(((event.clientY - rect.top) / rect.height) * 100)));
        },

        setImageFocusPreset(x, y, xProp, yProp) {
            this[xProp] = x;
            this[yProp] = y;
        },

        onImagePick(event, previewProp) {
            const file = event.target.files && event.target.files[0];
            if (!file) return;
            this[previewProp] = URL.createObjectURL(file);
        },

        resetImageFocus(xProp, yProp, previewProp) {
            this[xProp] = 50;
            this[yProp] = 50;
            this[previewProp] = '';
        },

        loadImageFocus(record, xProp, yProp, previewProp, url) {
            this[xProp] = Number(record?.image_focus_x ?? 50);
            this[yProp] = Number(record?.image_focus_y ?? 50);
            this[previewProp] = url || record?.image_url || '';
        },

        imageFocusOnObject(event, obj, xKey, yKey) {
            const rect = event.currentTarget.getBoundingClientRect();
            if (!rect.width || !rect.height) return;
            obj[xKey] = Math.max(0, Math.min(100, Math.round(((event.clientX - rect.left) / rect.width) * 100)));
            obj[yKey] = Math.max(0, Math.min(100, Math.round(((event.clientY - rect.top) / rect.height) * 100)));
        },

        setFocusPresetOnObject(obj, x, y, xKey, yKey) {
            obj[xKey] = x;
            obj[yKey] = y;
        },
    });
});
</script>
@endpush
@endonce

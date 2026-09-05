<script>
window.AdminImageUpload = {
    maxWidth: 1920,
    quality: 0.82,
    skipBelowBytes: 2 * 1024 * 1024,

    replaceInputFile(input, file) {
        if (!input || !file) return;
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
    },

    compressFile(file, maxWidth = this.maxWidth, quality = this.quality) {
        if (!file || !String(file.type || '').startsWith('image/')) {
            return Promise.resolve(file);
        }
        if (file.size <= this.skipBelowBytes) {
            return Promise.resolve(file);
        }

        return new Promise((resolve) => {
            const img = new Image();
            const objectUrl = URL.createObjectURL(file);

            img.onload = () => {
                URL.revokeObjectURL(objectUrl);
                let width = img.naturalWidth || img.width;
                let height = img.naturalHeight || img.height;
                if (!width || !height) {
                    resolve(file);
                    return;
                }
                if (width > maxWidth) {
                    height = Math.round(height * (maxWidth / width));
                    width = maxWidth;
                }
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(img, 0, 0, width, height);
                canvas.toBlob((blob) => {
                    if (!blob) {
                        resolve(file);
                        return;
                    }
                    const name = String(file.name || 'photo').replace(/\.[^.]+$/, '') + '.jpg';
                    resolve(new File([blob], name, { type: 'image/jpeg', lastModified: Date.now() }));
                }, 'image/jpeg', quality);
            };

            img.onerror = () => {
                URL.revokeObjectURL(objectUrl);
                resolve(file);
            };

            img.src = objectUrl;
        });
    },

    async compressForm(form) {
        if (!form) return;
        const inputs = form.querySelectorAll('input[type="file"][accept*="image"]');
        for (const input of inputs) {
            const file = input.files && input.files[0];
            if (!file) continue;
            const compressed = await this.compressFile(file);
            this.replaceInputFile(input, compressed);
        }
    },
};

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

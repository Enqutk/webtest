<script>
(function () {
    var commonSections = {
        'site-header': @json(\App\Support\AdminEditUrls::siteSettings('header')),
        'site-brand': @json(\App\Support\AdminEditUrls::siteSettings('header')),
        'site-nav': @json(\App\Support\AdminEditUrls::siteSettings('navigation')),
        'site-header-cta': @json(\App\Support\AdminEditUrls::siteSettings('header')),
        'site-footer': @json(\App\Support\AdminEditUrls::siteSettings('footer')),
        'site-social': @json(\App\Support\AdminEditUrls::siteSettings('footer')),
        'site-contact': @json(\App\Support\AdminEditUrls::siteSettings('footer')),
    };

    window.addEventListener('message', function (event) {
        var data = event.data || {};
        if (data.source !== 'admin-home-preview') return;

        if (data.type === 'navigate-edit' && data.url) {
            window.location.href = data.url;
            return;
        }

        if (data.type === 'section-click' && data.section) {
            var url = data.editUrl || commonSections[data.section];
            if (url) {
                window.location.href = url;
            }
        }
    });
})();
</script>

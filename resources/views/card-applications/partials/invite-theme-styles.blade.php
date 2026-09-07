<style>
    /* Invitation flow — clean white studio theme */
    .invite-flow {
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 45%, #f1f5f9 100%);
        color: #0f172a;
    }
    .invite-flow ::selection {
        background: #c5a059;
        color: #0f172a;
    }
    .invite-flow .glass-card {
        background: #ffffff;
        backdrop-filter: none;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 24px -12px rgba(15, 23, 42, 0.12);
    }
    .invite-flow .invite-step-active {
        box-shadow: 0 0 0 1px rgba(197, 160, 89, 0.45), 0 12px 40px -16px rgba(197, 160, 89, 0.35);
    }
    .invite-flow .invite-header {
        background: rgba(255, 255, 255, 0.92);
        border-color: #e2e8f0;
    }
    .invite-flow .invite-preview-shell {
        background: #ffffff;
        border-color: #e2e8f0;
        box-shadow: 0 8px 30px -12px rgba(15, 23, 42, 0.15);
    }
    .invite-flow .invite-stepper {
        background: #f8fafc;
        border-color: #e2e8f0;
    }
    .invite-flow .invite-progress-track { background: #e2e8f0; }
    .invite-flow .invite-bottom-bar {
        background: rgba(255, 255, 255, 0.96);
        border-color: #e2e8f0;
        box-shadow: 0 -4px 24px -8px rgba(15, 23, 42, 0.1);
    }
    .invite-flow .invite-field,
    .invite-flow input[type="text"],
    .invite-flow input[type="email"],
    .invite-flow textarea,
    .invite-flow select {
        background: #f8fafc !important;
        border-color: #e2e8f0 !important;
        color: #0f172a !important;
    }
    .invite-flow input::placeholder,
    .invite-flow textarea::placeholder { color: #94a3b8; }
    .invite-flow .invite-modal-panel {
        background: #ffffff;
        border-color: #e2e8f0;
    }
    .invite-flow .phone-frame {
        box-shadow: 0 20px 50px -15px rgba(15, 23, 42, 0.2), 0 0 0 6px #e2e8f0, 0 0 0 8px #f1f5f9;
    }
    .invite-flow .example-phone-light {
        box-shadow: 0 16px 40px -12px rgba(15, 23, 42, 0.18), 0 0 0 5px #f1f5f9, 0 0 0 7px #e2e8f0;
        border-color: #e4ded6 !important;
    }
    .invite-hero-glow-light {
        background:
            radial-gradient(ellipse 70% 55% at 0% 0%, rgba(197, 160, 89, 0.12), transparent 50%),
            radial-gradient(ellipse 50% 40% at 100% 100%, rgba(148, 163, 184, 0.15), transparent 45%),
            linear-gradient(135deg, #ffffff, #f8fafc);
    }
    .invite-hero-grid-light {
        background-image:
            linear-gradient(rgba(197, 160, 89, 0.08) 1px, transparent 1px),
            linear-gradient(90deg, rgba(197, 160, 89, 0.08) 1px, transparent 1px);
        background-size: 20px 20px;
    }
    /* Light overrides for dark Tailwind utilities inside invite flow */
    .invite-flow .text-white { color: #0f172a !important; }
    .invite-flow .text-slate-100 { color: #1e293b !important; }
    .invite-flow .text-slate-200 { color: #334155 !important; }
    .invite-flow .text-slate-300 { color: #475569 !important; }
    .invite-flow .text-slate-400 { color: #64748b !important; }
    .invite-flow .text-slate-500 { color: #64748b !important; }
    .invite-flow .border-slate-800,
    .invite-flow .border-slate-800\/80 { border-color: #e2e8f0 !important; }
    .invite-flow .bg-slate-900,
    .invite-flow .bg-slate-900\/50,
    .invite-flow .bg-slate-900\/60,
    .invite-flow .bg-slate-900\/70,
    .invite-flow .bg-slate-900\/80,
    .invite-flow .bg-slate-900\/90 { background-color: #f8fafc !important; }
    .invite-flow .bg-slate-950,
    .invite-flow .bg-slate-950\/50,
    .invite-flow .bg-slate-950\/60,
    .invite-flow .bg-slate-950\/70,
    .invite-flow .bg-slate-950\/80,
    .invite-flow .bg-slate-950\/95 { background-color: #ffffff !important; }
    .invite-flow .hover\:bg-slate-900:hover { background-color: #f1f5f9 !important; }
    .invite-flow .bg-slate-800 { background-color: #e2e8f0 !important; }
    .invite-flow .bg-slate-700 { background-color: #cbd5e1 !important; }
    /* Keep gold CTA buttons dark text */
    .invite-flow .bg-gold-500.text-slate-950,
    .invite-flow button.bg-gold-500 { color: #0f172a !important; }
    .invite-flow .invite-bottom-bar .bg-slate-900 { background: #f8fafc !important; color: #475569 !important; }
    .invite-flow .invite-bottom-bar .text-white { color: #475569 !important; }
    .invite-flow .invite-bottom-bar .text-slate-300 { color: #64748b !important; }
</style>

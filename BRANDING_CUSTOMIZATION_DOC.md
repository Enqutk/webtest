# Branding Customization (Header / Logo / Footer)

This doc explains how to control what your users see in the **website header and footer** from the admin UI, and how the underlying **`theme` config** keys work.

## 1) Header: text over logo / logo over text

### Where to edit (UI)
Go to:
**`/admin/organizations/{id}/edit`**

Then:
1. **Tab: Brand & Identity**
   - **Show Brand Name Text in Header** (`theme[show_brand_text]`)
   - **Show Tagline in Header** (`theme[show_tagline]`)
   - **Header CTA Button**:
     - Show/Hide (`theme[show_header_cta]`)
     - Text (`theme[header_cta_text]`)
     - URL (`theme[header_cta_url]`)

2. **Tab: Logo & Favicon**
   - Upload the **Brand Logo** (`name="logo"`)
   - Upload the **Favicon** (`name="favicon"`)
   - Use the checkboxes:
     - **Show logo on the whole site** (`theme[show_logo]`)
     - **Show logo specifically in header** (`theme[show_header_logo]`)

### “Text over logo” vs “logo over text”
The header rendering is done by `resources/views/components/site-brand.blade.php` and the header component uses:
- **Logo first**, then **brand text**.

So in the default implementation:
- You can **show/hide** logo and brand text independently.
- If you want a true **overlap / layering** effect (text stacked on top of logo), you’ll need a CSS change (the admin UI only controls visibility, not the stacking order).

## 2) Footer: tagline / nav / social / contact

### Where to edit (UI)
Go to:
**`/admin/organizations/{id}/edit`**

Then:
1. **Brand tagline**:
   - **Tagline field** in **Tab: Brand & Identity**
   - Footer tagline comes from this field (unless hidden by toggle).

2. **Tab: Contact & Location**
   - Footer visibility toggles:
     - Show footer tagline (`theme[show_footer_tagline]`)
     - Show footer Explore/Connect nav (`theme[show_footer_nav]`)
     - Show footer social icons (`theme[show_footer_social]`)
     - Enable social links (`theme[show_social_links]`)
     - Show footer contact block (`theme[show_footer_contact]`)
     - Show footer “Developed by” credit (`theme[show_footer_credit]`)

3. **Nav links (footer + header nav items)**
Footer nav links and header nav links are derived from the menu system:
- `/admin/menus` (Navigation Menus)
  - This controls `$navItems` used by the header/footer components.

4. **Social icons**
Footer social icons come from:
- `/admin/socials` (Social Media Links)

## 3) Underlying `theme` config keys (example)

Your organization stores branding controls in `organizations.theme` (JSON/array).

You can use this example theme snippet:

```json
{
  "show_brand_text": true,
  "show_tagline": true,
  "show_logo": true,
  "show_header_logo": true,

  "show_header_cta": true,
  "header_cta_text": "Book Consultation",
  "header_cta_url": "/contact",

  "show_footer_tagline": true,
  "show_footer_nav": true,
  "show_footer_social": true,
  "show_social_links": true,
  "show_footer_contact": true,
  "show_footer_credit": true
}
```

## 4) What images upload do

- **Brand Logo** upload field: `logo`
- **Favicon** upload field: `favicon`

These are stored via Media Library and are referenced by the header/footer components.


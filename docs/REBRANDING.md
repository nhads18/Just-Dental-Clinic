# Rebranding Guide — make it *your* clinic

Everything clinic-specific lives in **one place**: your `.env` file. Nothing about
the clinic (name, contact, hours, branding, booking rules) is hard-coded anywhere in
the app. Change a value here, save, and it updates across the whole site — the landing
page, the patient portal, emails, invoices, the AI assistant, and page titles.

> After changing `.env` on a **live** site, your developer runs one command
> (`php artisan config:clear`) for changes to take effect. On a fresh setup they take
> effect immediately.

---

## 1. Clinic identity

| Setting | What it controls | Example |
|---------|------------------|---------|
| `APP_NAME` | App name (browser tab, emails) | `"Bright Smile Dental"` |
| `CLINIC_NAME` | Full clinic name shown everywhere | `"Bright Smile Dental Clinic"` |
| `CLINIC_SHORT_NAME` | Short name (logo text, menus) | `"Bright Smile"` |
| `CLINIC_LEGAL_NAME` | Legal/business name (invoices) | `"Bright Smile Dental Inc."` |
| `CLINIC_TAGLINE` | One-line slogan on the homepage hero | `"Gentle care for every smile."` |

## 2. Logo, favicon & photos

| Setting | What it controls |
|---------|------------------|
| `CLINIC_LOGO` | Path to your logo, e.g. `img/logo.svg` (replace `public/img/logo.svg`) |
| `CLINIC_FAVICON` | Browser-tab icon (replace `public/favicon.ico`) |

Also replace these image files with your own (keep the same filenames, or point the
settings above at new ones):
- `public/img/logo.svg` — your logo
- `public/img/doc.jpg` — the clinic/team photo on the homepage
- `public/favicon.ico` — the tab icon

## 3. Contact & location

| Setting | Example |
|---------|---------|
| `CLINIC_EMAIL` | `hello@brightsmile.ph` |
| `CLINIC_PHONE` | `+63 917 123 4567` |
| `CLINIC_ADDRESS_LINE1` | `2F Sunrise Bldg, 123 Main St` |
| `CLINIC_ADDRESS_LINE2` | `Barangay Poblacion` |
| `CLINIC_ADDRESS_CITY` | `Cebu City` |
| `CLINIC_ADDRESS_PROVINCE` | `Cebu` |
| `CLINIC_ADDRESS_COUNTRY` | `Philippines` |
| `CLINIC_ADDRESS_POSTAL` | `6000` |
| `CLINIC_MAP_EMBED_URL` | Google Maps “embed” link for the map on the homepage |
| `CLINIC_WEBSITE` | `https://brightsmile.ph` |
| `CLINIC_FACEBOOK` | Your Facebook page URL |
| `CLINIC_INSTAGRAM` | Your Instagram URL |

*Tip for the map:* in Google Maps → Share → **Embed a map** → copy the `src="..."` link.

## 4. Operating hours

Shown on the homepage and used by the AI assistant. Free-text per day:

```
CLINIC_HOURS_MON="9:00 AM – 6:00 PM"
CLINIC_HOURS_TUE="9:00 AM – 6:00 PM"
CLINIC_HOURS_WED="9:00 AM – 6:00 PM"
CLINIC_HOURS_THU="9:00 AM – 6:00 PM"
CLINIC_HOURS_FRI="9:00 AM – 6:00 PM"
CLINIC_HOURS_SAT="9:00 AM – 3:00 PM"
CLINIC_HOURS_SUN="Closed"
```

## 5. Booking rules

Control how online booking behaves:

| Setting | Meaning | Example |
|---------|---------|---------|
| `CLINIC_APPT_DAY_START` | Earliest bookable time (24h) | `09:00` |
| `CLINIC_APPT_DAY_END` | Latest bookable time (24h) | `18:00` |
| `CLINIC_APPT_SLOT_INTERVAL` | Minutes between time slots | `15` |
| `CLINIC_APPT_DURATION` | Default visit length (minutes) | `30` |
| `CLINIC_APPT_MIN_LEAD` | Minimum hours’ notice before a slot | `2` |
| `CLINIC_APPT_REQUIRE_DP` | Require a down payment? | `false` |
| `CLINIC_APPT_DP_PERCENT` | Down-payment percentage | `20` |

The booking time dropdown and the “only between X and Y” rule are generated from these
values automatically.

## 6. Money & payments

| Setting | Meaning |
|---------|---------|
| `CLINIC_CURRENCY_SYMBOL` | Currency symbol shown on prices (default `₱`) |
| `CLINIC_CURRENCY_CODE` | Currency code (default `PHP`) |
| `CLINIC_PAYMENTS_ENABLED` | Turn online payments on/off |
| `CLINIC_PAY_GCASH` / `CLINIC_PAY_PAYMAYA` / `CLINIC_PAY_CARD` | Which payment methods to offer |

Service prices themselves are **not** in `.env` — you manage those in the admin panel
(see the Admin Guide).

## 7. AI assistant name

| Setting | Meaning | Example |
|---------|---------|---------|
| `CLINIC_ASSISTANT_NAME` | Name of the chat assistant | `"Aether AI"` |

## 8. Search-engine text (SEO)

| Setting | Meaning |
|---------|---------|
| `CLINIC_SEO_TITLE` | Title shown in Google / browser tab |
| `CLINIC_SEO_DESCRIPTION` | The short description under your Google result |
| `CLINIC_SEO_KEYWORDS` | Keywords for search |

---

## Quick start: rebrand in 5 minutes

1. Open `.env`.
2. Set `APP_NAME`, `CLINIC_NAME`, `CLINIC_SHORT_NAME`, `CLINIC_TAGLINE`.
3. Set `CLINIC_EMAIL`, `CLINIC_PHONE`, and the `CLINIC_ADDRESS_*` lines.
4. Set the `CLINIC_HOURS_*` for each day.
5. Replace `public/img/logo.svg`, `public/img/doc.jpg`, and `public/favicon.ico`.
6. Save. (Live site: ask your developer to run `php artisan config:clear`.)

That’s it — the whole site now shows your clinic. No code changes needed.

# Configuration

All clinic‑specific values are centralized in **`config/clinic.php`** and driven by
`CLINIC_*` environment variables. Never hardcode clinic details in Blade or controllers —
read them via `config('clinic.*')` or the helpers below.

## Helpers (`app/Support/helpers.php`)

| Helper | Returns |
|--------|---------|
| `clinic()` | clinic name |
| `clinic('email')`, `clinic('hours.monday')` | any `config('clinic.*')` value |
| `clinic_address()` | single‑line address from the configured parts (skips empties) |
| `peso($amount)` | amount formatted with the clinic currency symbol (₱) |

## Clinic identity (`CLINIC_*`)

| Env var | Purpose |
|---------|---------|
| `CLINIC_NAME`, `CLINIC_SHORT_NAME`, `CLINIC_LEGAL_NAME` | display / brand / legal names |
| `CLINIC_TAGLINE` | hero tagline |
| `CLINIC_LOGO`, `CLINIC_FAVICON` | brand assets under `/public` |
| `CLINIC_EMAIL`, `CLINIC_PHONE` | contact **(TODO: supply real values)** |
| `CLINIC_ADDRESS_*` | address parts **(TODO)** |
| `CLINIC_MAP_EMBED_URL` | Google Maps embed URL for the location section |
| `CLINIC_WEBSITE`, `CLINIC_FACEBOOK`, `CLINIC_INSTAGRAM` | web & social |
| `CLINIC_HOURS_MON … SUN` | operating hours **(TODO: confirm)** |
| `CLINIC_TIMEZONE`, `CLINIC_CURRENCY_CODE`, `CLINIC_CURRENCY_SYMBOL` | regional |
| `CLINIC_SEO_*` | title / description / keywords / OG image |

Appointment rules (`clinic.appointments.*`) and payment toggles
(`clinic.payments.*`) are also configurable — see `config/clinic.php`.

## Branding assets

- **Logo:** `public/img/logo.svg` is a placeholder wordmark — replace with the real
  Just Dental Clinic logo (or point `CLINIC_LOGO` elsewhere).
- **Favicon:** `public/favicon.ico`.
- **About/clinic photo:** `public/img/doc.jpg` is a leftover placeholder — replace it.

## Integrations (env)

| Integration | Keys | Notes |
|-------------|------|-------|
| MySQL | `DB_*` | primary database (`justdental`) |
| MongoDB | `MONGO_DSN`, `MONGO_DATABASE` | chat messages only |
| Mail | `MAIL_*`, `MAIL_FROM_ADDRESS/NAME` | `from` centralized; used by all mailables/notifications |
| PayMongo | `PAYMONGO_PUBLIC_KEY`, `PAYMONGO_SECRET_KEY` | use **TEST** keys off‑prod; never commit LIVE keys |
| Pusher | `PUSHER_*` | real‑time appointments & chat |
| OAuth | `GOOGLE_*`, `FB_*` | Socialite |
| Groq AI | `GROQ_API_KEY`, `GROQ_MODEL` | optional AI assistant; empty = feature disabled gracefully |
| Firebase | `FIREBASE_CREDENTIALS` | path to a service‑account JSON kept **outside** the repo |
| reCAPTCHA | `RECAPTCHA_SITE_KEY`, `RECAPTCHA_SECRET_KEY` | captcha |

## Social login (Google / Facebook OAuth)

The Google and Facebook login buttons on `/login` and `/register` **only appear
when that provider is configured** (its `client_id` is set). Wire them up as follows.

### Google
1. Google Cloud Console → **APIs & Services → Credentials → Create OAuth client ID**
   (Application type: *Web application*).
2. Add an **Authorized redirect URI**: `https://YOUR_DOMAIN/auth/google/callback`
   (locally `http://localhost:8000/auth/google/callback`).
3. Put the credentials in `.env`:
   ```env
   GOOGLE_CLIENT_ID=xxxxxxxx.apps.googleusercontent.com
   GOOGLE_CLIENT_SECRET=xxxxxxxx
   GOOGLE_CLIENT_REDIRECT="${APP_URL}/auth/google/callback"
   ```

### Facebook
1. Facebook for Developers → create an app → add **Facebook Login**.
2. Add an **OAuth redirect URI**: `https://YOUR_DOMAIN/auth/facebook/callback`.
3. Put the credentials in `.env`:
   ```env
   FB_CLIENT_ID=xxxxxxxx
   FB_CLIENT_SECRET=xxxxxxxx
   FB_CALLBACK_REDIRECTS="${APP_URL}/auth/facebook/callback"
   ```

After setting these, run `php artisan config:clear` (or `config:cache` in prod). The
matching button then appears and works. Never commit real client secrets.

## AI assistant name

The chatbot’s display name comes from `config('clinic.assistant.name')`
(`CLINIC_ASSISTANT_NAME`, default **Aether AI**) — used in the chat header, welcome
message, “is typing…” indicator, page title, and nav link.

## Applying config changes

Config is read from env at runtime. In production, run `php artisan config:cache`
after changing `.env`. Locally with the Docker dev server, run
`php artisan config:clear` and restart the server.

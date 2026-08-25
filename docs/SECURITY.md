# Security

## Model

- **Authentication:** Laravel Breeze (session), email verification, captcha, optional
  Google/Facebook OAuth.
- **Authorization:** role via `users.usertype` (`admin` / `user`) enforced by
  middleware (`AdminMiddleware`, `UserMiddleware`, `CheckAdmin`, `CheckUser`).
- **CSRF:** enabled globally; only the public AI endpoint `/ask-gemini-public` is
  exempt and is rate‑limited (`throttle:10,1`).

## Fixes applied in the security-hardening pass

- **Account-takeover fix:** Google OAuth users were created with the hardcoded
  password `password123`. They now get a random password (like the Facebook flow), so
  the OAuth account can’t be logged into with a guessable password.
- **Privilege-escalation hardening:** `usertype` is no longer mass-assignable (removed
  from `User::$fillable`; set server-side only). The `Appointment` model now uses an
  explicit `$fillable` allow-list instead of `$guarded = []`, and the unused
  `AdminController@bookAppointment` (which did `create($request->all())`) was removed.
- **Broken access control:** removed the broken `/admin/upcoming_appointments` route
  that sat in the *user* middleware group (it referenced a non-existent method); trimmed
  `/admin/details` to expose only the clinic name (no admin email).
- **Security headers:** added `App\Http\Middleware\SecurityHeaders` (on the web group)
  setting `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`,
  `Permissions-Policy`, a Content-Security-Policy (verified not to break the app), and
  `Strict-Transport-Security` over HTTPS. `expose_php = Off` removes the `X-Powered-By`
  version header. CSP can be toggled with `SECURITY_CSP_ENABLED`.
- **Less PII in logs:** removed name/email logging in `GoogleController` and patient
  emails in `AdminAppointment` (now log IDs / booleans only).
- **Config:** `SESSION_SECURE_COOKIE` documented in `.env.example` (set `true` in prod).

### Dependency status (as of this pass)

- **npm:** reduced from 13 vulnerabilities to 3 via `npm audit fix`; `axios` updated to
  a patched release. The remaining items are **build-time dev tooling** (`vite`,
  `esbuild`) that require a breaking major upgrade and are **not shipped to users**.
- **Composer:** an update is currently **blocked by Composer’s security policy** —
  several `laravel/framework` advisories affect *every* released version (11.x and
  12.x), i.e. **no fixed release exists upstream yet**. We did **not** disable the
  policy or force-ignore advisories. Re-run `docker compose exec app composer update -W`
  once patched releases ship (watch the Laravel security releases). Upgrading to Laravel
  12 is a separate, test-backed migration and would not clear the not-yet-fixed
  advisories today.

## Fixes applied during the Prime Smiles transformation

- **Removed exposed public scripts** that bypassed the framework:
  `public/clear-cache.php`, `test-images.php`, `check-image.php`,
  `fix-ratings-table.php`, and `image.php` (the last served government IDs with no auth).
- **Closed IDOR / PII exposure on file routes:**
  - `/valid-id/{filename}` (government IDs) is now **auth‑only** and restricted to the
    owning patient or an admin (`SecureMediaController@validId`).
  - `/dental-record/{filename}` (medical attachments) is now **auth‑only** and
    ownership‑checked (`PatientDentalRecordController@downloadAttachment`).
  - All wildcard file routes are hardened against **path traversal** via `basename()`.
- **Fixed maintenance‑driver misconfiguration** in `config/app.php` (was bound to
  `SESSION_DRIVER`, which broke boot under database sessions).
- **Restored `storage/framework/sessions/.gitignore`** so session files aren’t committed.
- **Added `.env.example`** (previously missing) so secrets aren’t improvised into `.env`.
- **Centralized secrets**: mail `from` and clinic details read from config/env, not hardcoded.

## Existing good controls (verified)

- Patient dental‑record views are scoped to `Auth::id()`; `getTeethChart` returns 403
  on a patient‑id mismatch — no IDOR.
- File uploads are validated (`mimes:jpg,jpeg,png,pdf`, size limits) in
  `DentalRecordController`.

## Hardening checklist (before/at production)

- [ ] `APP_DEBUG=false`, `APP_ENV=production`
- [ ] Rotate/replace **all** inherited secrets (PayMongo, Pusher, Groq, OAuth, mail)
- [ ] Remove/disable demo accounts (`*@justdental.example`)
- [ ] Store `valid_ids` and dental attachments on **private** storage; serve only via
      the authenticated routes above (or signed URLs)
- [ ] Enforce HTTPS + HSTS; secure/session cookies
- [ ] Review `DB::raw`/`whereRaw` usages for injection
- [ ] Ensure DB backups are written to a **non‑web‑accessible** location
- [ ] Confirm the Groq API key is env‑only (never in JS/committed)
- [ ] Consider expanding roles to ADMIN / DENTIST / STAFF / PATIENT with Policies
      (currently admin/user) — see the audit’s roadmap.

## Reporting

Report security issues privately to the clinic’s maintainer — do not open public issues.

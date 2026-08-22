# Security

## Model

- **Authentication:** Laravel Breeze (session), email verification, captcha, optional
  Google/Facebook OAuth.
- **Authorization:** role via `users.usertype` (`admin` / `user`) enforced by
  middleware (`AdminMiddleware`, `UserMiddleware`, `CheckAdmin`, `CheckUser`).
- **CSRF:** enabled globally; only the public AI endpoint `/ask-gemini-public` is
  exempt and is rate‑limited (`throttle:10,1`).

## Fixes applied during the Just Dental transformation

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

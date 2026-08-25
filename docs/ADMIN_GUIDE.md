# Admin Guide

This guide covers day‑to‑day administration of the Prime Smiles Dental Clinic system.

## Signing in

Admins sign in at `/login` with an account whose `usertype` is `admin`. The admin
area is under `/admin/*`.

## Dashboard

The admin dashboard summarizes clinic activity (appointments, patients, charts). Open
it from the sidebar after signing in.

## Appointments

- **Pending:** `/admin/pending-appointments` — review and **Accept** or **Decline**
  (with a reason). The patient is notified by email/notification.
- **Upcoming / Completed:** dedicated lists in the sidebar.
- **Cancellations & reschedules** are recorded and visible per appointment.

Appointment statuses in use include *pending, accepted/confirmed, completed,
cancelled, declined*. (Expanding to an explicit enum incl. `no_show` /
`reschedule_requested` is a documented enhancement.)

## Patients & records

- **Patient management:** `/admin/patient-management`.
- **Dental records:** create/view/edit per patient under
  `/admin/patients/{patient}/dental-records`. Attachments (x‑rays, documents) are
  served only to the patient and admins.
- **Tooth chart / tooth records:** per‑tooth condition, notes, and images.

> Attachments and valid‑ID images are access‑controlled. Never share the raw storage
> paths; always use the in‑app links.

## Services & pricing

Service catalog and pricing live in the `procedure_prices` table (seeded with demo
data). Prices display with the clinic currency symbol (₱). Update pricing via the
admin procedure/price screens. **Replace demo pricing with the clinic’s real prices.**

## Inventory

Manage stock under the inventory admin screens: items, categories, suppliers,
quantities, units, reorder thresholds, cost, and expiration. Low‑stock items are
surfaced for reordering.

## Reviews

Patient reviews can be moderated and **featured** (featured reviews appear publicly on
the landing page). No fake reviews are seeded.

## Messaging

Real‑time patient↔clinic messaging is available from the admin messages screen.

## AI assistant (optional)

If `GROQ_API_KEY` is set, the public “Ask Our Dental Assistant” chatbot answers general
dental questions using the clinic details from `config/clinic.php`. With no key, the
feature is disabled gracefully.

## Backups

An admin database‑backup action produces a SQL dump (filename prefixed with the clinic
short name). Store backups in a **private**, non‑web‑accessible location.

## Configuration changes

Clinic name, contact, hours, branding, and SEO are set via `CLINIC_*` env vars — see
[CONFIGURATION.md](CONFIGURATION.md). After changing them in production, run
`php artisan config:cache`.

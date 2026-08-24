# Just Dental Clinic — Client Guide

A plain-English guide to your clinic management system: what it does, how patients use
it, and how you run the clinic day to day. No technical knowledge needed.

---

## What this system does

It’s your clinic’s website **and** back-office in one:

- 🌐 **Public website** — homepage, services, hours, location, contact, and an
  AI assistant that answers common dental questions.
- 📅 **Online booking** — patients pick a service, date and time and request an
  appointment; you approve or decline it.
- 👩‍⚕️ **Patient records** — profiles, dental records, an interactive tooth chart,
  treatment history, and uploaded documents.
- 💳 **Payments & invoices** — optional online payment (GCash / Maya / card) and
  downloadable invoices.
- 📦 **Inventory** — track supplies, suppliers, quantities, and low-stock alerts.
- 💬 **Messaging & notifications** — chat with patients; automatic email reminders.
- ⭐ **Reviews** — collect patient feedback and feature the best on your homepage.

---

## Who uses it

| Role | Can do |
|------|--------|
| **Patient** | Register/log in, book & manage their own appointments, view their own records & invoices, message the clinic, leave reviews. |
| **Admin (you/your staff)** | Everything in the admin panel: appointments, patients, records, services, pricing, inventory, reviews, messages. |

Patients can **only** see their own information — never another patient’s records.

---

## Logging in

- Patients and admins sign in at **`/login`**.
- The admin panel is at **`/admin`** (you’ll be taken there after signing in with an
  admin account).
- Patients can also sign in with **Google or Facebook** if those are set up (see the
  Configuration guide).

> Your developer creates your first admin account. Keep that password safe and never
> share admin logins.

---

## Running the clinic (admin panel)

### Appointments
1. New booking requests appear under **Pending appointments**.
2. Open one to see the patient, service, date/time, and any uploaded ID.
3. Click **Accept** or **Decline** (with a reason). The patient is notified by email
   automatically.
4. Accepted appointments move to your upcoming list; completed ones are archived.
5. Patients can request to **cancel** or **reschedule** — you’ll see these too.

The system **prevents double-booking** — two appointments can’t overlap in the same
slot.

### Patients & records
- **Patient Management** lists your patients.
- For each patient you can create and view **dental records** (exam notes, diagnosis,
  treatment, follow-ups) and an **interactive tooth chart** with per-tooth notes and
  images.
- Uploaded documents (like a valid ID) are **private** — only you and that patient can
  open them.

### Services & pricing
- Manage your **service list and prices** in the admin panel (name, description,
  category, price, duration, image, active/inactive).
- Prices show with your currency symbol (₱ by default).
- **You set your own real prices here** — the system ships with placeholder demo
  prices you should replace.

### Inventory
- Track items with quantity, unit, supplier, cost, reorder threshold, and expiry.
- **Low-stock items** are flagged so you know what to reorder.

### Reviews
- Approve patient reviews and mark the best as **featured** — featured reviews appear
  on your public homepage.

### Messaging
- Chat with patients in real time from the **Messages** screen.

---

## Changing your clinic details

Your clinic name, logo, contact info, hours, and booking rules are all controlled from
**one settings file** (`.env`) — **not** buried in the code. See
**[REBRANDING.md](REBRANDING.md)** for the simple step-by-step. In short: change the
value, save, and it updates everywhere.

Service **prices** and **inventory** are managed in the admin panel (above), not in the
settings file.

---

## The AI assistant

The homepage chat assistant (named **Aether AI** by default, changeable in settings)
answers general dental questions and shares your clinic’s info and hours. It only
discusses dental topics. It needs an “AI key” to work — your developer sets this up; if
it’s not set, the chat simply shows a friendly “not available” message.

---

## Good habits (please read)

- 🔒 **Remove the demo accounts** before going live (your developer handles this).
- 🔑 Use a **strong, unique** admin password; don’t reuse it elsewhere.
- 🖼️ Replace the placeholder **logo and clinic photo** with your own.
- 💵 Replace the demo **service prices** with your real prices.
- 🕘 Double-check your **operating hours** and **booking times** in settings.
- 📧 Emails send from your clinic address — your developer configures this so they
  don’t land in spam.

---

## When to call your developer

Do it yourself (settings/admin panel): clinic details, hours, prices, services,
inventory, reviews, appointments.

Ask your developer for: first-time setup, connecting Google/Facebook login or online
payments, domain & email setup, going live, backups, and software updates.

More detail lives in the other guides: **REBRANDING.md**, **CONFIGURATION.md**,
**ADMIN_GUIDE.md**, **INSTALLATION.md**, **DEPLOYMENT.md**, and **SECURITY.md**.

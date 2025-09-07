# 🛡️ Safe Import Plan for Square → WooCommerce

### Step 0: Backups

- Export a **fresh Square catalog CSV** (keep as backup).
- Make a full **WordPress database backup** (so you can roll back if needed).

---

### Step 1: Wipe WooCommerce products/images

In WP Bulk Delete:

1. **Delete Posts → Post Type = product_variation** → Permanent.
2. **Delete Posts → Post Type = product** → Permanent.
3. **Delete Attachments → Filter by post type = product** → Permanent.

Then in Woo → Status → Tools:

- Clear transients
- Recount terms
- Regenerate product lookup tables

👉 End result: Woo → Products = **empty**, Media Library = no product images.

---

### Step 2: Tune the server (to prevent timeouts/restarts)

Ask your host or edit `php.ini` / `.htaccess`:

- `max_execution_time = 300` (5 min per PHP process)
- `memory_limit = 512M` (or higher if available)
- `max_input_vars = 5000`
- `upload_max_filesize = 256M`
- Use **PHP 8.0+** if possible (faster, less memory hungry).

👉 These settings stop sync from choking and retrying (the source of duplicates).

---

### Step 3: Configure the Square plugin

Woo → Settings → Square:

- **System of Record = Square**
- **Match by SKU = ON**
- **Update existing products** = Enabled
- **Sync direction = Square → Woo only** (at least for this first full import)
- If your version has it: **Batch size / Throttle = 50--100 items per request**

👉 Smaller batches = slower but stable. No "SKU already exists" errors.

---

### Step 4: Pilot import

- Run a manual sync for a **small batch** (e.g. 500 items).
- Check Woo → Products → make sure:
- Only one copy per SKU.
- Images imported.
- Stock values match Square.
- Check Woo → Status → Logs → `square-...log`:
- Should be **1 log file only** for the run.
- Should **not** show `SKU already exists`.

👉 If this works cleanly, you're ready for the full catalog.

---

### Step 5: Full import

- Run sync on the full 40k catalog.
- Ideally do it **overnight** or during low-traffic hours.
- Monitor logs --- you should see a single continuous `square-...` log growing large, not 10--15 new ones starting every few minutes.

---

### Step 6: Post-import checks

- Spot check 10--20 random items: SKU, stock, price, and image all match Square.
- Confirm no duplicates in Woo.
- Keep an eye on logs for a few days --- you want to see one log per scheduled sync, not dozens.

---

### 🚨 Red flags to watch

- If you see "SKU already exists" in logs → it's retrying batches again. Pause, check server limits and batch size.
- If logs spawn **many files per day** again → that means sync is splitting/restarting. Don't let it run to completion; fix limits first.

---

💡 The big shift is: **this isn't about cleaning 40k SKUs, it's about stabilizing the sync job.**

Your catalog is fine. The problem is **Woo → Square** sync breaking into multiple overlapping imports.


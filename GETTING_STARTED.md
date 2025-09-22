# 🚀 Getting Started with Laravel HRMS

## You are here: Setting up your first HRMS tables and basic functionality

Since you're new to Laravel and the TALL stack, I'll guide you step-by-step to get your HRMS system running.

---

## 📋 **STEP 1: Check Your Environment**

First, let's make sure everything is working:

```bash
# Check if you're in the right directory
pwd

# Check Laravel version (should be 12.x)
~/.config/herd/bin/php.bat artisan --version

# Check database connection
~/.config/herd/bin/php.bat artisan migrate:status
```

---

## 📋 **STEP 2: Set Up Your Database**

### **Option A: SQLite (Recommended for beginners)**
Your `.env` file should have:
```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

Create the database file:
```bash
touch database/database.sqlite
```

### **Option B: MySQL (if you prefer)**
Update your `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ph_hrms
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

---

## 📋 **STEP 3: Run Existing Migrations**

```bash
# Run the existing Laravel migrations
~/.config/herd/bin/php.bat artisan migrate
```

This will create the basic Laravel tables (users, cache, jobs, permissions).

---

## 📋 **STEP 4: What I'm Creating for You Next**

I'm creating these essential migrations in order:

1. **companies** - Multi-tenant company data
2. **company_branches** - Branch/location management
3. **departments** - Department hierarchy
4. **positions** - Job positions and grades
5. **employees** - Core employee data
6. **work_schedules** - Working time patterns
7. **time_logs** - Daily attendance records
8. **leave_types** - Leave policies
9. **leave_applications** - Leave requests

---

## 📋 **STEP 5: After Migrations Are Created**

Once I create all the migration files, you'll run:

```bash
# This will create all the HRMS tables
~/.config/herd/bin/php.bat artisan migrate
```

---

## 📋 **STEP 6: Seed Initial Data**

```bash
# This will populate tables with Philippine data (holidays, rates, etc.)
~/.config/herd/bin/php.bat artisan db:seed
```

---

## 📋 **STEP 7: Create Your First Company & User**

```bash
# This will create an admin user and sample company
~/.config/herd/bin/php.bat artisan make:user-admin
```

---

## 📋 **STEP 8: Start the Development Server**

```bash
# Start all development services (as per your CLAUDE.md)
composer dev
```

This runs:
- PHP development server (localhost:8000)
- Queue worker for background jobs
- Application logs viewer
- Vite for frontend assets

---

## 🎯 **What You'll Have After This Setup**

- ✅ Multi-tenant HRMS with complete Philippine compliance
- ✅ Companies, branches, departments, positions
- ✅ Employee management with full data tracking
- ✅ Time and attendance system
- ✅ Leave management with Philippine leave types
- ✅ Government rate tables (SSS, PhilHealth, Pag-IBIG, BIR)
- ✅ Philippine holiday calendar
- ✅ Basic admin interface to start adding data

---

## 🛠️ **Next Steps After Basic Setup**

Once the basic system is running, we'll add:

1. **Livewire Components** - Interactive UI for managing data
2. **User Authentication** - Login/logout with roles
3. **Employee Dashboard** - Employee self-service portal
4. **Payroll Processing** - Salary calculations and pay slips
5. **Reports** - 50+ built-in reports for compliance
6. **Navigation & Menus** - Complete admin interface

---

## 🆘 **If You Get Stuck**

**Common Issues:**

1. **Permission errors:** Run `chmod -R 755 storage bootstrap/cache`
2. **Database connection:** Check your `.env` file settings
3. **Missing PHP:** Use `~/.config/herd/bin/php.bat` instead of `php`
4. **Migration errors:** Run `php artisan migrate:fresh` to start over

**Need Help?**
- Check Laravel logs: `tail -f storage/logs/laravel.log`
- Run diagnostics: `php artisan about`
- Clear caches: `php artisan config:clear && php artisan cache:clear`

---

## 📚 **Learning Resources**

Since you're new to Laravel:

- **Laravel Documentation:** https://laravel.com/docs/12.x
- **Livewire Documentation:** https://livewire.laravel.com/docs/quickstart
- **TALL Stack Tutorial:** Search for "Laravel Livewire Alpine Tailwind tutorial"

---

**Ready to continue? Let me know when you've completed Steps 1-3, and I'll create all the migration files for you!**
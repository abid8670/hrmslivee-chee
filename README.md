# HRMS — Human Resource Management System

An **HR management system** built on **Laravel 12 + Filament 3.3**, covering the employee record,
attendance, shift scheduling, biometric device management and attendance-correction approvals —
with a multilingual admin panel.

> **Note on this repository:** it is a work in progress. The `.gitignore` is currently empty, so
> `vendor/`, `project.tar.gz` and `.env` are committed. See **Repository hygiene** below.

---

## Modules

### 👤 Employee records
| Resource | Purpose |
|----------|---------|
| `EmployeeResource` / `EmployeesResource` | Employee master record — personal details, department, designation, title, work location, shift |
| `DepartmentResource` | Departments, with an inline **Employees relation manager** |
| `DesignationResource` | Job designations |
| `EmployeeTitleResource` | Employee titles / grades |
| `WorkLocationResource` | Duty stations and work locations |

### ⏰ Attendance & shifts
| Resource | Purpose |
|----------|---------|
| `AttendanceResource` | Daily attendance records — check-in, check-out, worked hours |
| `EmployeeShiftResource` | Shift definitions and per-employee shift assignment |
| `TimeChangeRequestResource` | **Attendance correction workflow** — an employee raises a request to amend a punch, which is approved or rejected |

### 🖨️ Biometric devices
| Resource | Purpose |
|----------|---------|
| `MachineResource` | Biometric/time-attendance machines — device registry with registration and connection details |

### 💰 Payroll components
| Model | Purpose |
|-------|---------|
| `Allowance` | Recurring and one-off allowances |
| `Deduction` | Deductions applied against employees |

### 🔐 Administration
| Resource | Purpose |
|----------|---------|
| `UserResource` | Panel users and access, with a custom `UserOverview` widget |
| `Lead` | Lead capture records |

### 🌍 Localisation
The panel uses the **Filament Spatie Laravel Translatable plugin**, so translatable fields can be
maintained in multiple languages from the admin UI.

---

## Tech stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 12 (PHP 8.2+) |
| Admin panel | Filament 3.2 |
| Translations | filament/spatie-laravel-translatable-plugin 3.3 |
| Database | SQLite (default) / MySQL |
| Frontend | Blade + Vite |
| Testing | PHPUnit 11 |
| Tooling | Laravel Pint, Laravel Pail, Laravel Sail |

---

## Getting started

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan filament:make-user     # or use the bundled helper commands
php artisan serve
```

The panel is served at `/admin`.

### Helper commands

Two Artisan commands ship with the project for account administration:

```bash
php artisan ...:create-filament-user    # app/Console/Commands/CreateFilamentUser.php
php artisan ...:reset-user-password     # app/Console/Commands/ResetUserPassword.php
```

### Development

```bash
composer dev
```

Runs the server, queue listener, Pail log tail and Vite concurrently.

### Tests

```bash
composer test
```

---

## Project structure

```
app/
├── Console/Commands/       # CreateFilamentUser, ResetUserPassword
├── Filament/Resources/     # Attendance, Employee(s), Shift, Machine,
│                           # TimeChangeRequest, Department, Designation,
│                           # EmployeeTitle, WorkLocation, User
└── Models/                 # Attendance, Employee/Employees, Allowance,
                            # Deduction, EmployeeShift, TimeChangeRequest,
                            # Department, Designation, EmployeeTitle,
                            # WorkLocation, Lead, User
database/migrations/        # 25 migrations
routes/
├── console.php
└── web.php
```

---

## Repository hygiene

This repo needs a cleanup pass before it is production-ready:

- `.gitignore` is **empty** — it should exclude `.env`, `/vendor`, `/node_modules`,
  `project.tar.gz`, `.idx` and `.vscode`.
- `vendor/` is committed (thousands of files) and `project.tar.gz` adds ~59 MB.
  Run `composer install` instead of shipping `vendor/`.
- `.env` is tracked. **Remove it and rotate `APP_KEY`.**
- `MachineResource.php` and `EmployeeResource.php` are referenced by their `Pages/` classes but the
  resource classes themselves are not in the tree — the project appears mid-refactor.
- `Employee` / `Employees` models and `EmployeeResource` / `EmployeesResource` resources are
  duplicated; one pair should be retired.

---

## Roadmap

- [ ] Add `.gitignore` and untrack `vendor/`, `.env`, `project.tar.gz`
- [ ] Consolidate the duplicate Employee / Employees models and resources
- [ ] Restore the missing `MachineResource` and `EmployeeResource` classes
- [ ] Leave management and holiday calendar
- [ ] Overtime rules and roster generation
- [ ] Payroll processing on top of allowances and deductions
- [ ] Employee self-service portal
- [ ] Biometric punch sync job from `MachineResource` devices
- [ ] Reporting and exports

---

## License

Proprietary — not licensed for redistribution.

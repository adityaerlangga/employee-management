# Design: Employee Salary Calculation Module

## Context
The employee management application needs a salary calculation feature that allows users to:
- Track employee information (name, ID, email)
- Record daily work hours (start time, end time)
- Calculate daily salary based on hourly rate
- Organize calculations by month and year
- Dynamically manage work entry rows

## Goals / Non-Goals

### Goals
- Provide a user-friendly form interface for salary calculation
- Automatically calculate daily salary from hourly rate and work duration
- Auto-populate work entry rows for all days in selected month/year
- Allow adding and removing work entry rows dynamically
- Store employee and work entry data in database
- Use Tailwind CSS for styling consistent with project conventions

### Non-Goals
- Overtime calculation (future enhancement)
- Multiple hourly rates per employee (future enhancement)
- Export functionality (future enhancement)
- Payment processing (future enhancement)

## Decisions

### Decision: Separate Employee and WorkEntry Models
**What**: Create two separate models - `Employee` for employee information and `WorkEntry` for daily work records.

**Why**: 
- Separation of concerns: employee data is relatively static, work entries are transactional
- Allows one employee to have multiple work entries across different months/years
- Easier to query and maintain

**Alternatives considered**:
- Single model with JSON column for work entries → Rejected: harder to query, less normalized
- Embed work entries in Employee model → Rejected: violates normalization principles

### Decision: Auto-populate Work Entries on Month/Year Selection
**What**: When user selects a month and year, automatically create work entry rows for all days in that month.

**Why**:
- Reduces manual data entry
- Ensures all days are accounted for
- Better user experience

**Alternatives considered**:
- Manual row addition only → Rejected: too tedious for users
- Pre-populate only weekdays → Rejected: may miss weekend work

### Decision: Calculate Daily Salary Client-Side
**What**: Calculate daily salary (hourly rate × hours worked) in JavaScript on the frontend.

**Why**:
- Immediate feedback to user
- No server round-trip needed
- Better user experience

**Alternatives considered**:
- Server-side calculation only → Rejected: slower, requires form submission
- Hybrid approach → Considered but unnecessary for MVP

### Decision: Use Laravel Blade with Tailwind CSS
**What**: Implement views using Blade templates styled with Tailwind CSS utility classes.

**Why**:
- Consistent with existing project setup (Tailwind CSS v4 already configured)
- Follows project conventions from README.md
- Fast development with utility-first approach

**Alternatives considered**:
- Vue.js/React component → Rejected: adds unnecessary complexity for this feature
- Plain HTML/CSS → Rejected: doesn't leverage existing Tailwind setup

### Decision: Time Input with 10-Minute Intervals in 24-Hour Format
**What**: Implement time inputs that allow selection in 10-minute intervals using 24-hour format (HH:MM).

**Why**:
- Standardizes time entry and prevents invalid time values
- 10-minute intervals provide sufficient granularity for work tracking
- 24-hour format avoids AM/PM confusion and is more precise
- Ensures consistent data format for calculations

**Implementation approach**:
- Evaluate existing JavaScript time picker libraries (e.g., Flatpickr, Timepicker.js, or similar)
- If suitable library exists, integrate it with custom 10-minute interval configuration
- If no suitable library, create custom dropdown/select input with 10-minute interval options
- Generate time options programmatically: 00:00, 00:10, 00:20, ..., 23:50 (144 options total)

**Alternatives considered**:
- Free-form time input → Rejected: allows invalid times, harder to validate
- 15-minute intervals → Rejected: less precise, may not meet requirements
- 5-minute intervals → Considered but 10 minutes is sufficient for salary calculation
- 12-hour format with AM/PM → Rejected: 24-hour format is clearer and more standard

## Database Schema

### Migration: Create Employees Table
**File**: `database/migrations/YYYY_MM_DD_HHMMSS_create_employees_table.php`

```php
Schema::create('employees', function (Blueprint $table) {
    $table->id();
    $table->string('employee_id')->unique()->comment('User-entered employee identifier');
    $table->string('name');
    $table->string('email');
    $table->timestamps();
    
    $table->index('employee_id');
    $table->index('email');
});
```

**Fields**:
- `id` (bigint, primary key, auto-increment) - Internal database ID
- `employee_id` (string, unique, indexed) - User-entered employee identifier (e.g., "EMP001")
- `name` (string) - Employee full name
- `email` (string, indexed) - Employee email address
- `created_at` (timestamp) - Record creation timestamp
- `updated_at` (timestamp) - Record last update timestamp

**Constraints**:
- `employee_id` must be unique across all employees
- All fields except timestamps are required (non-nullable)

### Migration: Create Work Entries Table
**File**: `database/migrations/YYYY_MM_DD_HHMMSS_create_work_entries_table.php`

```php
Schema::create('work_entries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
    $table->date('date')->comment('Work date (YYYY-MM-DD)');
    $table->time('start_time')->comment('Start time in 24-hour format (HH:MM)');
    $table->time('end_time')->comment('End time in 24-hour format (HH:MM)');
    $table->decimal('hourly_rate', 10, 2)->comment('Hourly rate at time of entry');
    $table->decimal('daily_salary', 10, 2)->comment('Calculated daily salary');
    $table->tinyInteger('month')->comment('Month (1-12) for quick filtering');
    $table->year('year')->comment('Year (2020-2030) for quick filtering');
    $table->timestamps();
    
    $table->index(['employee_id', 'month', 'year']);
    $table->index(['date']);
    $table->index(['month', 'year']);
});
```

**Fields**:
- `id` (bigint, primary key, auto-increment) - Internal database ID
- `employee_id` (bigint, foreign key) - Reference to employees table, cascade delete
- `date` (date, indexed) - Work date in YYYY-MM-DD format
- `start_time` (time) - Start time in 24-hour format (HH:MM:SS, stored as time)
- `end_time` (time) - End time in 24-hour format (HH:MM:SS, stored as time)
- `hourly_rate` (decimal 10,2) - Hourly rate used for this entry (allows rate changes over time)
- `daily_salary` (decimal 10,2) - Calculated daily salary (hourly_rate × hours worked)
- `month` (tinyInteger, indexed) - Month number (1-12) for efficient filtering
- `year` (year, indexed) - Year (2020-2030) for efficient filtering
- `created_at` (timestamp) - Record creation timestamp
- `updated_at` (timestamp) - Record last update timestamp

**Constraints**:
- `employee_id` foreign key constraint with cascade delete
- `end_time` must be after `start_time` (enforced via validation, not DB constraint)
- `daily_salary` must be >= 0 (enforced via validation)
- `month` must be between 1-12
- `year` must be between 2020-2030
- Composite index on `(employee_id, month, year)` for efficient queries

**Indexes**:
- Primary index on `id`
- Index on `employee_id` (via foreign key)
- Composite index on `(employee_id, month, year)` for filtering by employee and period
- Index on `date` for date-based queries
- Index on `(month, year)` for period-based queries

**Data Types Rationale**:
- `hourly_rate` and `daily_salary` use `decimal(10,2)` to ensure precise currency calculations (supports up to 99,999,999.99)
- `start_time` and `end_time` use `time` type for proper time handling and validation
- `date` uses `date` type for proper date handling
- `month` uses `tinyInteger` (1 byte) as it only needs values 1-12
- `year` uses `year` type for proper year handling and validation

**Sample Data**:
```
employees:
  id: 1
  employee_id: "EMP001"
  name: "John Doe"
  email: "john.doe@example.com"
  created_at: 2024-01-15 10:00:00
  updated_at: 2024-01-15 10:00:00

work_entries:
  id: 1
  employee_id: 1
  date: 2024-01-15
  start_time: 09:00:00
  end_time: 17:30:00
  hourly_rate: 25.00
  daily_salary: 212.50
  month: 1
  year: 2024
  created_at: 2024-01-15 18:00:00
  updated_at: 2024-01-15 18:00:00
```

## Risks / Trade-offs

### Risk: Date/Time Handling Complexity
**Mitigation**: Use Laravel's Carbon for date handling, implement time picker with 10-minute intervals (library or custom), validate on server-side

### Risk: Dynamic Row Management JavaScript Complexity
**Mitigation**: Use vanilla JavaScript (no framework), keep logic simple and well-commented, test thoroughly

### Risk: Data Validation
**Mitigation**: Implement both client-side (UX) and server-side (security) validation, use Laravel Form Requests

### Trade-off: Auto-populate All Days vs. Manual Entry
**Decision**: Auto-populate all days, allow deletion of unnecessary rows
**Rationale**: Better UX, users can remove rows they don't need

## Migration Plan

1. Create Employee migration and model
2. Create WorkEntry migration and model
3. Run migrations
4. Create controller and routes
5. Create views
6. Test functionality
7. No rollback needed (new feature, no breaking changes)

## Open Questions
- Should we validate that end time is after start time? → **Yes, implement validation**
- Should we allow negative hours or zero hours? → **No, validate minimum 10 minutes**
- Should employee ID be auto-generated or user-entered? → **User-entered for flexibility**
- Should we support timezone handling? → **No, use server timezone for MVP**


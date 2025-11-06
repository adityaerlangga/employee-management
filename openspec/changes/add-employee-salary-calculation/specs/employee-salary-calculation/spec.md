## ADDED Requirements

### Requirement: Employee Management
The system SHALL allow users to create and manage employee records with basic information including name, unique employee ID, and email address.

#### Scenario: Create new employee
- **WHEN** user submits employee information (name, employee ID, email)
- **THEN** system creates a new employee record in the database
- **AND** employee ID is validated as unique

#### Scenario: Retrieve existing employee
- **WHEN** user submits form with existing employee ID
- **THEN** system retrieves existing employee record
- **AND** pre-fills employee name and email from database

### Requirement: Salary Calculation Form Header
The system SHALL provide a form header section with fields for employee identification and calculation parameters.

#### Scenario: Display form header fields
- **WHEN** user navigates to salary calculation create page
- **THEN** form displays header fields: employee name (text input), employee ID (text input), employee email (email input), month selection (dropdown: Jan-Dec), year selection (dropdown: 2020-2030), hourly rate (number input)

#### Scenario: Month and year selection
- **WHEN** user selects a month and year from dropdowns
- **THEN** system automatically populates work entry rows for all days in that month
- **AND** rows are created with date fields pre-filled for each day

### Requirement: Dynamic Work Entry Rows
The system SHALL provide dynamic row fields that can be added or removed, with each row containing work entry information.

#### Scenario: Add work entry row
- **WHEN** user clicks "Add Row" button
- **THEN** system adds a new row with fields: date (YYYY-MM-DD input), start time (time input with 10-minute intervals, 24-hour format), end time (time input with 10-minute intervals, 24-hour format), daily salary (read-only display)

#### Scenario: Remove work entry row
- **WHEN** user clicks "Remove Row" button on a row
- **THEN** system removes that row from the form
- **AND** at least one row remains visible

#### Scenario: Auto-populate rows on month/year selection
- **WHEN** user selects month and year in header
- **THEN** system automatically creates work entry rows for all days in that month
- **AND** each row has date field pre-filled with corresponding date (YYYY-MM-DD format)
- **AND** start time, end time, and daily salary fields are empty
- **AND** time inputs support 10-minute interval selection in 24-hour format

### Requirement: Time Input Format
The system SHALL provide time inputs that allow selection in 10-minute intervals using 24-hour format (HH:MM).

#### Scenario: Time input with 10-minute intervals
- **WHEN** user interacts with start time or end time input
- **THEN** system displays time picker or dropdown with options in 10-minute intervals (00:00, 00:10, 00:20, ..., 23:50)
- **AND** time is displayed and stored in 24-hour format (HH:MM)
- **AND** user can only select valid 10-minute interval values

### Requirement: Daily Salary Calculation
The system SHALL automatically calculate daily salary based on hourly rate and work duration.

#### Scenario: Calculate daily salary
- **WHEN** user enters hourly rate in header and start time/end time in a row
- **THEN** system calculates daily salary as: hourly rate × (end time - start time in hours)
- **AND** displays calculated value in daily salary field (read-only)
- **AND** calculation updates automatically when any input changes

#### Scenario: Handle invalid time range
- **WHEN** user enters end time that is before or equal to start time
- **THEN** system displays validation error
- **AND** daily salary field shows error or zero

#### Scenario: Minimum work duration validation
- **WHEN** user enters start time and end time with less than 10 minutes difference
- **THEN** system displays validation error
- **AND** daily salary field shows error or zero
- **AND** system enforces minimum 10-minute work duration

### Requirement: Work Entry Data Persistence
The system SHALL save work entry data to the database when form is submitted.

#### Scenario: Save salary calculation
- **WHEN** user submits form with valid data
- **THEN** system creates or retrieves employee record
- **AND** saves all work entries with date, start time, end time, hourly rate, calculated daily salary, month, and year
- **AND** redirects to index page with success message

#### Scenario: Validate required fields
- **WHEN** user submits form with missing required fields
- **THEN** system displays validation errors
- **AND** does not save data to database

### Requirement: Salary Calculation Display
The system SHALL provide an index page listing existing salary calculations.

#### Scenario: View salary calculations list
- **WHEN** user navigates to salary calculation index page
- **THEN** system displays list of existing salary calculations
- **AND** shows employee name, month, year, total days worked, total salary
- **AND** provides link to create new calculation


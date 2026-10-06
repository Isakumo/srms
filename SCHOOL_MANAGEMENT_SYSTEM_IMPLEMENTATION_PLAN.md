# Comprehensive School Management System (CSMS)
## Complete AI Code Agent Implementation Plan

**Version:** 1.0  
**Target:** Nursery, Primary, Junior Secondary, Senior Secondary  
**Recommended Stack:** Laravel + MySQL + Blade + Tailwind CSS + Alpine.js  
**Architecture:** Modular Monolith  
**Primary Client:** Responsive Web Application  
**Future Client:** Flutter mobile application via REST API

---

# 1. Purpose of This Document

This document is the authoritative implementation plan for building a production-oriented Comprehensive School Management System (CSMS). An AI code agent should use this document as the development specification and implement the project incrementally, testing every phase before proceeding.

The system must manage a complete school covering configurable sections such as:

- Nursery 1–2
- Primary 1–6
- JSS 1–3
- SS 1–3

Do not hard-code these levels. They must be configurable through the application.

The application must preserve historical academic and financial records. Never implement promotion, class changes, results, payments, or transfers in a way that destroys historical data.

---

# 2. Core Engineering Principles

The code agent MUST follow these rules throughout development:

1. Use Laravel conventions and clean, maintainable PHP.
2. Use MySQL/InnoDB with `utf8mb4`.
3. Use migrations, seeders, factories, Form Requests, Policies, services, events/listeners, and automated tests appropriately.
4. Implement a modular monolith; do not introduce microservices.
5. Keep controllers thin. Business workflows belong in service/action classes.
6. Enforce authorization server-side on every protected operation.
7. Implement RBAC plus resource scope/assignment checks.
8. Use database transactions for multi-record critical workflows.
9. Preserve historical data rather than overwriting it.
10. Never hard-delete important academic or financial transactions.
11. Never store passwords in plaintext.
12. Never use floating-point types for money.
13. Use `DECIMAL` for money and scores.
14. Validate all inputs server-side.
15. Prevent cross-school/tenant data leakage.
16. Create audit records for sensitive operations.
17. Write automated tests for business rules and authorization.
18. Do not move to the next phase while the current phase has failing tests or known critical errors.
19. Do not silently change requirements. Document unavoidable implementation deviations.
20. Build the first version as a responsive web application; keep the service layer reusable for a future REST API/Flutter app.

---

# 3. High-Level Architecture

```text
Browser / Responsive UI
        |
        v
Laravel Routes
        |
        v
Authentication + Middleware
        |
        v
Authorization (Permissions + Policies + Scope)
        |
        v
Controllers
        |
        v
Application / Domain Services
        |
        v
Eloquent Models
        |
        v
MySQL
```

Recommended frontend:

- Blade
- Tailwind CSS
- Alpine.js
- Minimal JavaScript where possible

Future architecture:

```text
Web UI -----------\
                   -> Laravel Application/API -> MySQL
Flutter App ------/
```

---

# 4. Functional Modules

Implement these bounded modules:

1. Identity & Access Management
2. Dashboard
3. School Configuration
4. Admissions
5. Students & Guardians
6. Staff & Teachers
7. Academic Management
8. Enrollment & Subject Registration
9. Timetable
10. Attendance
11. Assessments
12. Results & Report Cards
13. Promotion / Graduation / Transfer
14. Finance
15. Communication
16. Applications / Service Requests
17. Reports & Analytics
18. Documents
19. Audit Logs
20. System Settings

---

# 5. User Roles

Seed the following default roles while allowing authorized administrators to create additional roles:

- Super Administrator
- Proprietor / School Owner
- School Administrator
- Principal / Head Teacher
- Academic Officer
- Bursar / Accountant
- Class Teacher
- Subject Teacher
- Admission Officer
- Parent / Guardian
- Student

A user may have multiple roles.

## Authorization model

Authorization must evaluate:

```text
Authenticated user
    -> role(s)
    -> permission
    -> school scope
    -> resource scope
    -> assignment/relationship
    -> workflow status
    -> allow/deny
```

Examples:

- A Subject Teacher with `scores.update` may update scores only for subjects/classes to which the teacher is assigned and only while marks entry is open.
- A Parent may access only children linked through `student_guardians`.
- A Class Teacher may manage attendance only for assigned classes unless granted wider authority.
- A Bursar may record payments but must not permanently delete completed payments.

---

# 6. Permission Naming Convention

Use granular permission codes. At minimum implement permissions following this pattern:

```text
students.view
students.create
students.update
students.archive

guardians.view
guardians.create
guardians.update

admissions.view
admissions.create
admissions.review
admissions.approve

staff.view
staff.create
staff.update

classes.view
classes.create
classes.update

subjects.view
subjects.create
subjects.update

teacher_assignments.view
teacher_assignments.manage

attendance.view
attendance.create
attendance.update
attendance.approve_correction

assessments.view
assessments.create
assessments.update
assessments.open
assessments.close

scores.view
scores.create
scores.update
scores.submit
scores.unlock

results.view
results.process
results.review
results.approve
results.publish

promotion.view
promotion.process
promotion.approve

fees.view
fees.manage
invoices.view
invoices.create
payments.view
payments.create
payments.verify
payments.reverse
expenses.view
expenses.create
expenses.approve

reports.students
reports.academic
reports.attendance
reports.financial
reports.staff

users.view
users.create
users.update
users.disable
roles.view
roles.create
roles.update
roles.assign

settings.view
settings.update

audit_logs.view
```

Seed sensible role-permission defaults.

---

# 7. Database Design

Use `BIGINT UNSIGNED` IDs consistently unless Laravel conventions justify equivalent types. Add timestamps. Use foreign keys and indexes deliberately.

## 7.1 Identity and access

### schools
- id
- name
- code
- motto nullable
- logo_path nullable
- address nullable
- phone nullable
- email nullable
- website nullable
- status
- timestamps

### users
- id
- school_id nullable where system-wide account is necessary
- username
- email nullable
- phone nullable
- password
- status
- must_change_password
- last_login_at nullable
- timestamps

Unique keys should be tenant-aware where appropriate.

### roles
- id
- school_id nullable
- name
- code
- description nullable
- is_system_role
- status
- timestamps

### permissions
- id
- code unique
- name
- module
- description nullable
- timestamps

### user_roles
- id
- user_id
- role_id
- timestamps
- unique(user_id, role_id)

### role_permissions
- id
- role_id
- permission_id
- timestamps
- unique(role_id, permission_id)

## 7.2 Academic configuration

### school_sections
- id
- school_id
- name
- code
- display_order
- status
- timestamps

### grade_levels
- id
- school_id
- section_id
- name
- code
- sequence
- status
- timestamps

### class_groups
- id
- school_id
- grade_level_id
- name
- code
- capacity nullable
- status
- timestamps

### academic_sessions
- id
- school_id
- name
- start_date
- end_date
- is_current
- status
- timestamps

### terms
- id
- academic_session_id
- name
- sequence
- start_date
- end_date
- is_current
- status
- timestamps

Ensure current session/term switching is handled safely.

## 7.3 Students and guardians

### students
- id
- school_id
- user_id nullable
- admission_no
- first_name
- middle_name nullable
- last_name
- gender
- date_of_birth
- photo_path nullable
- address nullable
- admission_date
- status
- timestamps

Do NOT store authoritative current class/term directly on the student.

### guardians
- id
- school_id
- user_id nullable
- first_name
- middle_name nullable
- last_name
- phone
- alternate_phone nullable
- email nullable
- address nullable
- occupation nullable
- status
- timestamps

### student_guardians
- id
- student_id
- guardian_id
- relationship
- is_primary
- can_pickup
- receives_notifications
- timestamps
- unique(student_id, guardian_id)

### student_documents
- id
- student_id
- document_type
- file_path
- original_name
- mime_type
- file_size
- uploaded_by
- created_at

## 7.4 Enrollment

### student_enrollments
- id
- student_id
- academic_session_id
- class_group_id
- roll_number nullable
- enrollment_date
- status
- timestamps

Preserve old enrollments. Do not overwrite enrollment during promotion.

### enrollment_history
- id
- enrollment_id
- from_class_group_id nullable
- to_class_group_id
- effective_date
- reason
- changed_by
- created_at

## 7.5 Staff

### staff
- id
- school_id
- user_id nullable
- staff_no
- first_name
- middle_name nullable
- last_name
- gender
- date_of_birth nullable
- phone
- email nullable
- address nullable
- job_title
- qualification nullable
- employment_date
- employment_status
- photo_path nullable
- timestamps

## 7.6 Subjects and assignments

### subjects
- id
- school_id
- name
- code
- description nullable
- status
- timestamps

### grade_level_subjects
- id
- grade_level_id
- subject_id
- subject_type (`CORE`, `ELECTIVE`, `OPTIONAL`)
- status
- timestamps
- unique(grade_level_id, subject_id)

### teacher_assignments
- id
- staff_id
- academic_session_id
- term_id nullable
- class_group_id
- subject_id
- status
- assigned_at
- timestamps

### class_teacher_assignments
- id
- staff_id
- academic_session_id
- term_id nullable
- class_group_id
- assignment_type (`MAIN`, `ASSISTANT`)
- status
- timestamps

### student_subject_registrations
- id
- enrollment_id
- term_id
- subject_id
- registration_type
- status
- timestamps
- unique(enrollment_id, term_id, subject_id)

## 7.7 Timetable

### timetable_periods
- id
- school_id
- name
- start_time
- end_time
- sequence
- is_break
- timestamps

### timetables
- id
- academic_session_id
- term_id
- class_group_id
- name
- status
- timestamps

### timetable_entries
- id
- timetable_id
- day_of_week
- period_id
- subject_id nullable for breaks
- teacher_assignment_id nullable
- room nullable
- timestamps

Detect class, teacher, and room conflicts.

## 7.8 Attendance

### attendance_sessions
- id
- class_group_id
- term_id
- attendance_date
- attendance_type
- recorded_by
- status
- submitted_at nullable
- timestamps

### attendance_records
- id
- attendance_session_id
- enrollment_id
- status (`PRESENT`, `ABSENT`, `LATE`, `EXCUSED`)
- remarks nullable
- recorded_at
- timestamps
- unique(attendance_session_id, enrollment_id)

## 7.9 Assessment and results

### assessment_schemes
- id
- school_id
- name
- section_id nullable
- grade_level_id nullable
- effective_session_id
- status
- timestamps

### assessment_components
- id
- assessment_scheme_id
- name
- code
- max_score decimal
- weight decimal
- sequence
- status
- timestamps

Do not hard-code 30/70 or any specific CA/exam split.

### assessments
- id
- term_id
- class_group_id
- subject_id
- assessment_component_id
- teacher_assignment_id
- title
- max_score
- status
- opens_at nullable
- submission_deadline nullable
- submitted_at nullable
- reviewed_at nullable
- approved_at nullable
- created_by
- timestamps

### student_scores
- id
- assessment_id
- enrollment_id
- score decimal
- remarks nullable
- entered_by
- timestamps
- unique(assessment_id, enrollment_id)

### grading_schemes
- id
- school_id
- name
- section_id nullable
- grade_level_id nullable
- effective_session_id
- status
- timestamps

### grade_bands
- id
- grading_scheme_id
- min_score
- max_score
- grade
- remark
- grade_point nullable
- timestamps

Prevent overlapping bands through application validation.

### student_term_results
- id
- enrollment_id
- term_id
- grading_scheme_id
- total_score
- average_score
- position nullable
- subjects_taken
- subjects_passed
- subjects_failed
- attendance_present
- attendance_absent
- attendance_late
- class_teacher_comment nullable
- principal_comment nullable
- status
- reviewed_by nullable
- approved_by nullable
- approved_at nullable
- published_at nullable
- timestamps
- unique(enrollment_id, term_id)

### subject_term_results
- id
- student_term_result_id
- subject_id
- total_score
- grade
- remark
- teacher_comment nullable
- timestamps
- unique(student_term_result_id, subject_id)

Published result tables are historical snapshots. Do not recalculate old published reports using new grading configuration.

## 7.10 Promotion

### promotion_batches
- id
- school_id
- from_session_id
- to_session_id
- from_grade_level_id
- to_grade_level_id nullable
- status
- created_by
- approved_by nullable
- processed_at nullable
- timestamps

### promotion_records
- id
- promotion_batch_id
- student_id
- from_enrollment_id
- to_enrollment_id nullable
- decision (`PROMOTED`, `REPEATED`, `GRADUATED`, `TRANSFERRED`, `PENDING`)
- remarks nullable
- approved_by nullable
- timestamps

SS3 graduation must not create a fictitious next class.

## 7.11 Admissions

### admission_applications
- id
- school_id
- application_no
- first_name
- middle_name nullable
- last_name
- gender
- date_of_birth
- intended_grade_level_id
- previous_school nullable
- guardian_name
- guardian_phone
- guardian_email nullable
- application_date
- status
- converted_student_id nullable
- timestamps

### admission_reviews
- id
- application_id
- review_type
- score nullable
- remarks nullable
- decision nullable
- reviewed_by
- reviewed_at
- created_at

## 7.12 Finance

Use `DECIMAL(12,2)` for monetary values.

### fee_categories
- id
- school_id
- name
- code
- description nullable
- status
- timestamps

### fee_structures
- id
- school_id
- academic_session_id
- term_id nullable
- grade_level_id
- name
- status
- timestamps

### fee_structure_items
- id
- fee_structure_id
- fee_category_id
- amount
- is_mandatory
- timestamps

### student_invoices
- id
- school_id
- student_id
- enrollment_id
- term_id
- invoice_no
- issue_date
- due_date nullable
- subtotal
- discount_amount
- total_amount
- status
- created_by
- timestamps

### invoice_items
- id
- invoice_id
- fee_category_id
- description
- quantity
- unit_amount
- discount_amount
- net_amount
- timestamps

### payments
- id
- school_id
- student_id
- receipt_no
- amount
- payment_method
- transaction_reference nullable
- payment_date
- status
- received_by
- verified_by nullable
- timestamps

### payment_allocations
- id
- payment_id
- invoice_id
- invoice_item_id nullable
- amount
- created_at

### payment_reversals
- id
- payment_id
- reason
- requested_by
- approved_by nullable
- status
- requested_at
- approved_at nullable
- created_at

Never delete a completed payment to correct it. Use reversal.

### expense_categories
- id
- school_id
- name
- code
- status
- timestamps

### expenses
- id
- school_id
- expense_category_id
- amount
- description
- expense_date
- payee nullable
- payment_method
- reference nullable
- status
- recorded_by
- approved_by nullable
- timestamps

## 7.13 Communication

### announcements
- id
- school_id
- title
- body
- priority
- published_by
- publish_at
- expires_at nullable
- status
- timestamps

### announcement_audiences
- id
- announcement_id
- audience_type
- section_id nullable
- class_group_id nullable

Support audiences such as ALL, STAFF, TEACHERS, PARENTS, STUDENTS, SECTION, CLASS.

Implement messages and meetings as separate tables/modules if included in the current development phase.

## 7.14 Requests

### request_types
- id
- school_id
- name
- code
- description
- status

### service_requests
- id
- school_id
- request_no
- request_type_id
- student_id
- requested_by
- description
- status
- submitted_at
- reviewed_by nullable
- completed_at nullable
- timestamps

### request_status_history
- id
- service_request_id
- from_status
- to_status
- remarks nullable
- changed_by
- changed_at

## 7.15 System

### school_settings
- id
- school_id
- setting_key
- setting_value
- data_type
- timestamps
- unique(school_id, setting_key)

### audit_logs
- id
- school_id
- user_id nullable
- action
- module
- entity_type
- entity_id nullable
- old_values JSON nullable
- new_values JSON nullable
- ip_address nullable
- user_agent nullable
- created_at

Do not provide ordinary users with edit/delete actions for audit logs.

---

# 8. Important Domain Workflows

## 8.1 Admission conversion

```text
Application
 -> Review
 -> Accepted
 -> BEGIN TRANSACTION
 -> Create student
 -> Create/link guardian
 -> Create student_guardian relationship
 -> Create enrollment
 -> Register required subjects
 -> Link converted_student_id
 -> Mark application ENROLLED
 -> Audit
 -> COMMIT
```

Rollback on any critical failure.

## 8.2 Student promotion

```text
Select source session/class
 -> load students
 -> determine/review decision
 -> approval
 -> BEGIN TRANSACTION
 -> close/update old enrollment status
 -> create new enrollment for promoted/repeated student
 -> create promotion record
 -> register appropriate subjects
 -> graduate SS3 students without next enrollment
 -> audit
 -> COMMIT
```

Never overwrite the old enrollment.

## 8.3 Attendance

```text
Teacher selects assigned class/date
 -> system loads active enrollments
 -> mark all present option
 -> edit exceptions
 -> validate assignment and date
 -> save draft / submit
 -> lock according to policy
 -> corrections require authorized workflow after lock period
```

## 8.4 Score entry

```text
Academic officer opens assessment
 -> assigned teacher enters scores
 -> save draft
 -> validate 0 <= score <= max_score
 -> submit
 -> lock teacher editing
 -> academic review
 -> return for correction OR approve
```

All post-submission changes must be auditable.

## 8.5 Result processing

```text
Load enrollment
 -> load registered subjects
 -> load configured assessment scheme
 -> load scores
 -> validate completeness
 -> calculate component/subject totals
 -> apply grading scheme
 -> calculate student totals/average
 -> calculate optional position/statistics
 -> create/update DRAFT result snapshot
 -> review
 -> approval
 -> publish
```

Only PUBLISHED results are visible to parents/students.

## 8.6 Payment

```text
Select student
 -> show outstanding invoices
 -> enter payment
 -> select allocation
 -> validate allocation <= payment and outstanding balance
 -> BEGIN TRANSACTION
 -> create payment
 -> create allocations
 -> update derived invoice statuses
 -> audit
 -> COMMIT
 -> generate receipt
```

## 8.7 Payment reversal

```text
Request reversal
 -> authorized approval
 -> transaction
 -> mark payment REVERSED
 -> reverse/neutralize allocations
 -> recalculate invoice statuses
 -> audit
 -> commit
```

---

# 9. Result Workflow States

Use controlled transitions such as:

```text
DRAFT
 -> PROCESSED
 -> SUBMITTED
 -> REVIEWED
 -> APPROVED
 -> PUBLISHED
```

Support RETURNED where correction is required.

Do not allow arbitrary transitions. A published result must not be silently edited.

---

# 10. Student Statuses

Support appropriate statuses including:

- ADMITTED
- ACTIVE
- SUSPENDED
- TRANSFERRED
- WITHDRAWN
- GRADUATED
- ALUMNI

Do not permanently delete students with historical records.

---

# 11. UI/UX Requirements

Use the supplied/proposed mobile-style prototype as visual inspiration but adapt it into a professional responsive school management interface.

## General

- Responsive desktop/tablet/mobile layout.
- Role-specific dashboard.
- Sidebar navigation on desktop and suitable mobile navigation.
- Consistent cards, tables, forms, modals, alerts, badges, pagination and filters.
- Accessible labels and useful validation messages.
- Confirmation before destructive/sensitive actions.
- Empty states and loading states.
- Search and filters for large datasets.
- Never expose internal IDs unnecessarily in the UI.

## Navigation

Recommended top-level navigation:

```text
Dashboard
Students
Admissions
Staff
Academics
Attendance
Assessments
Results
Promotion
Finance
Communication
Applications
Reports
Administration
```

Hide unauthorized navigation for UX, but still enforce server-side authorization.

## Student profile

Provide tabs/sections:

- Overview
- Guardians
- Academic History
- Current Enrollment
- Subjects
- Attendance
- Results
- Finance
- Documents
- Activity/History

## Teacher dashboard

Prioritize:

- My Classes
- My Subjects
- Today's Timetable
- Attendance Pending
- Assessments Pending
- Result Submission Status
- Announcements

## Bursar dashboard

Prioritize:

- Today's Collection
- Term Collection
- Outstanding Fees
- Recent Payments
- Expenses
- Financial Reports

## Parent dashboard (when implemented)

- My Children
- Attendance
- Published Results
- Fees/Outstanding Balance
- Receipts
- Announcements

---

# 12. Reports

Implement filterable reports with appropriate print/export support.

## Student reports
- Student list
- Students by section/class/gender/status
- New admissions
- Transfers
- Withdrawals
- Graduates

## Academic reports
- Individual results
- Class results
- Subject performance
- Grade distribution
- Class performance
- Promotion list
- Result submission status
- Broadsheet where applicable

## Attendance reports
- Daily attendance
- Student attendance history
- Class attendance
- Monthly/term summaries
- Frequent absence

## Finance reports
- Daily collection
- Collection by date range
- Collection by class
- Collection by fee category
- Outstanding fees
- Student statement
- Payment history
- Expenses
- Income/expense summary

## Staff reports
- Staff list
- Teacher assignments
- Class teacher assignments

---

# 13. PDF/Printable Documents

Support printable/PDF output for at least:

- Report cards
- Payment receipts
- Student statements
- Admission letters
- Admission lists
- Promotion lists
- Selected management reports

Report cards should use finalized result snapshots, not live recalculation of old scores.

---

# 14. File Security

- Validate MIME type, extension and file size.
- Generate safe storage filenames.
- Keep sensitive documents outside direct public access where practical.
- Serve private files through authorized routes/controllers.
- Store file paths/references in the database rather than binary blobs.
- Prevent path traversal.

---

# 15. Audit Requirements

Audit at minimum:

- Login/security events where appropriate
- User/role changes
- Student critical profile changes
- Enrollment/class changes
- Attendance corrections
- Score changes after initial entry
- Score submission/unlock
- Result review/approval/publication
- Promotion
- Payment creation
- Payment verification
- Payment reversal
- Expense approval
- Configuration changes

Audit entries should capture actor, action, target, timestamp and old/new values where appropriate.

---

# 16. Security Requirements

Implement:

- Laravel password hashing.
- Session regeneration after login.
- CSRF protection.
- Output escaping/XSS protection.
- Form Request validation.
- Eloquent/query parameterization.
- Rate limiting for sensitive authentication endpoints where appropriate.
- Secure file upload validation.
- Authorization on every protected request.
- Tenant/school isolation.
- Least privilege and deny-by-default behavior.
- Account status checks.
- Audit logs.
- Safe production error handling.
- HTTPS-ready deployment configuration.

Never rely on hidden buttons or menu items as authorization.

---

# 17. Testing Strategy

Use automated feature/unit tests throughout.

## Required test groups

### Authentication
- Valid login succeeds.
- Invalid login fails.
- Disabled account cannot login.
- Unauthorized routes redirect/deny correctly.

### RBAC
- Role permissions work.
- Multi-role user receives intended effective permissions.
- User without permission is denied.

### Tenant isolation
- School A user cannot view/update School B data.

### Student
- Student creation validates required data.
- Admission number uniqueness enforced per school.
- Guardian linking works.

### Enrollment
- Historical enrollment is preserved.
- Promotion does not overwrite previous enrollment.
- Invalid duplicate active enrollment is prevented by business rules.

### Teacher scope
- Teacher can access assigned class/subject.
- Teacher cannot modify unassigned class/subject scores.

### Attendance
- Duplicate student attendance for one attendance session is prevented.
- Unauthorized teacher cannot submit attendance.

### Scores
- Score below zero rejected.
- Score above assessment maximum rejected.
- Submitted/locked score cannot be edited without authorization.

### Results
- Correct total and grade calculation.
- Published result only visible to allowed users.
- Old published result remains stable after grading configuration changes.

### Promotion
- Promotion creates new enrollment.
- Repetition creates correct next-session enrollment.
- Graduation creates no next grade enrollment.
- Transaction rolls back on failure.

### Finance
- Partial payment works.
- Full payment works.
- Over-allocation rejected.
- Invoice status updates correctly.
- Reversal restores appropriate outstanding balance.
- Completed payment cannot be deleted through normal workflow.

### Parent access
- Parent sees linked children only.

### Audit
- Critical operations generate audit entries.

Run the full test suite before every phase completion.

---

# 18. Development Phases

The AI code agent must implement sequentially. After each phase: run migrations/tests, inspect errors, fix regressions, update documentation, and only then proceed.

## Phase 0 — Project Initialization

### Tasks
- Create Laravel project.
- Configure `.env.example`.
- Configure MySQL.
- Install/build Tailwind and Alpine integration as appropriate.
- Establish application layout/components.
- Configure timezone and localization-ready structure.
- Initialize Git-friendly project structure.
- Configure PHPUnit/Pest according to project choice.
- Create README installation instructions.

### Acceptance criteria
- Fresh install succeeds.
- App boots without errors.
- Database connection works.
- Frontend assets compile.
- Test runner works.

---

## Phase 1 — Identity, Authentication & RBAC

### Build
- schools
- users
- roles
- permissions
- user_roles
- role_permissions
- login/logout/password features
- account status middleware
- permission middleware/policies
- Super Admin seed
- default role/permission seeders
- user/role administration UI

### Acceptance criteria
- Administrator can create/manage users.
- Multiple roles can be assigned.
- Permissions are enforced server-side.
- Unauthorized users receive 403/appropriate response.
- Tests cover RBAC.

---

## Phase 2 — School & Academic Configuration

### Build
- school profile
- sections
- grade levels
- class groups
- academic sessions
- terms
- current session/term management
- settings

Seed configurable example structure Nursery through SS3.

### Acceptance criteria
- Admin can configure hierarchy without code changes.
- Only one appropriate current session/term is active per school according to rules.
- Historical configuration referenced by records cannot be dangerously deleted.

---

## Phase 3 — Student & Guardian Management

### Build
- students
- guardians
- student_guardians
- student documents
- student registration wizard
- student list/search/filter
- student profile tabs
- status management

### Acceptance criteria
- Student can be registered with guardian(s).
- Guardian can link to multiple children.
- Student profile displays correctly.
- Admission number uniqueness enforced.
- Sensitive documents require authorization.

---

## Phase 4 — Staff & Teacher Management

### Build
- staff
- staff profiles
- optional user account linking
- teacher assignments
- class teacher assignments
- assignment screens

### Acceptance criteria
- Staff can exist without login.
- Teacher user can be linked to staff.
- Subject/class assignments are session-aware.
- Assignment history is retained.

---

## Phase 5 — Subjects, Enrollment & Subject Registration

### Build
- subjects
- grade_level_subjects
- student_enrollments
- enrollment_history
- student_subject_registrations
- enrollment workflows
- core/elective/optional subject support

### Acceptance criteria
- Student enrollment is session-specific.
- Historical enrollment remains intact.
- SSS students may have different subject combinations.
- Core subjects can be registered automatically where configured.

---

## Phase 6 — Dashboard Foundation

### Build role-specific dashboard widgets.

Administrator:
- total students
- staff/teachers
- classes
- admissions
- attendance snapshot

Teacher:
- assigned classes
- assigned subjects
- attendance tasks
- assessments

Academic Officer:
- score submission progress
- results pending review

Bursar (finance widgets may initially be placeholders until finance phase):
- collections
- outstanding balances

### Acceptance criteria
- Dashboard contents respect permissions and scope.
- No unauthorized data leaks through widgets.

---

## Phase 7 — Timetable

### Build
- timetable periods
- timetable creation
- timetable entries
- class timetable
- teacher timetable
- conflict detection

### Acceptance criteria
- Teacher cannot be scheduled in two places at same period.
- Class cannot have two subjects at same period.
- Timetable displays cleanly on desktop/mobile.

---

## Phase 8 — Attendance

### Build
- attendance sessions
- attendance records
- teacher attendance UI
- mark-all-present shortcut
- save/submit
- attendance history
- corrections with authorization
- reports

### Acceptance criteria
- Only scoped users can record attendance.
- Duplicate attendance prevented.
- Historical attendance searchable.
- Attendance totals available for result/report-card use.

---

## Phase 9 — Assessment Configuration

### Build
- assessment schemes
- components
- grading schemes
- grade bands
- section/grade applicability
- assessment creation/open/close

### Acceptance criteria
- CA/exam split is configurable.
- Nursery can use a different scheme from Primary/Secondary.
- Grade bands cannot overlap.
- Assessment maximums are validated.

---

## Phase 10 — Score Entry & Submission

### Build
- teacher score-entry screens
- bulk class score entry
- draft saving
- validation
- submission
- locking
- correction/unlock workflow
- submission progress dashboard

### Acceptance criteria
- Teacher only sees assigned subjects/classes.
- Invalid score rejected server-side.
- Submitted scores lock.
- Authorized correction workflow works.
- Audit records capture sensitive changes.

---

## Phase 11 — Result Processing & Report Cards

### Build
- ResultProcessingService
- subject totals
- grading
- averages
- optional ranking/position controlled by setting
- result snapshots
- review
- approval
- publication
- class teacher comments
- principal comments
- report card view/PDF
- result analysis

### Acceptance criteria
- Calculations match configured scheme.
- Only approved results can publish.
- Parents/students can only see published results when portals exist.
- Published historical snapshots remain stable.
- Report cards print correctly.

---

## Phase 12 — Promotion, Repetition, Graduation & Transfer

### Build
- promotion batches
- promotion records
- bulk review
- individual overrides
- approval
- new enrollment creation
- repetition
- graduation
- transfer/withdrawal statuses
- academic history display

### Acceptance criteria
- Old enrollment remains intact.
- New enrollment created transactionally.
- SS3 graduation creates no false class.
- Failed batch operation rolls back safely.

---

## Phase 13 — Admissions

### Build
- admission applications
- application numbering
- reviews
- entrance assessment/interview records
- decisions
- admission lists
- admission letter
- applicant-to-student conversion

### Acceptance criteria
- Applicant lifecycle works.
- Accepted applicant converts once only.
- Conversion transaction creates consistent student/guardian/enrollment data.

---

## Phase 14 — Finance Foundation

### Build
- fee categories
- fee structures
- fee structure items
- invoice generation
- invoice items
- student finance profile
- outstanding balance calculation

### Acceptance criteria
- Fees vary by session/term/grade.
- Old invoices remain unchanged if fee structures change.
- Partial/full outstanding calculations are accurate.

---

## Phase 15 — Payments, Receipts & Expenses

### Build
- payments
- allocations
- receipt generation
- verification
- reversal workflow
- expense categories
- expenses
- approval where configured
- finance dashboard

### Acceptance criteria
- Partial payments work.
- One payment can allocate across obligations.
- Over-allocation is impossible.
- Reversal is auditable.
- Completed payments cannot be hard-deleted.
- Receipt PDF/print works.

---

## Phase 16 — Communication

### Build
- announcements
- audiences
- class/section targeting
- messages if in current scope
- meetings if in current scope
- notification hooks/events

### Acceptance criteria
- Users see only relevant announcements.
- Expired/unpublished announcements behave correctly.

---

## Phase 17 — Applications / Service Requests

### Build
- request types
- transfer request
- transcript/document requests
- generic request workflow
- status history

### Acceptance criteria
- Request lifecycle retained.
- Status changes are auditable.

---

## Phase 18 — Reports & Analytics

### Build all required student, attendance, academic, finance and staff reports.

### Requirements
- filters
- pagination where appropriate
- print views
- CSV/Excel/PDF only where useful and supported
- authorization per report type

### Acceptance criteria
- Reports agree with authoritative database records.
- Large datasets do not load entire tables unnecessarily.

---

## Phase 19 — Audit, Security Hardening & Data Integrity

### Tasks
- review all policies/middleware
- cross-school authorization tests
- CSRF review
- validation review
- file upload security review
- session/cookie production settings
- rate limits where appropriate
- audit coverage review
- foreign-key/referential integrity review
- indexes/query performance review
- N+1 query review

### Acceptance criteria
- Security test suite passes.
- No known horizontal privilege escalation.
- No known tenant data leakage.
- Sensitive operations audited.

---

## Phase 20 — UX Polish

### Tasks
- responsive review
- navigation consistency
- form validation UX
- empty states
- confirmation dialogs
- flash messages/toasts
- loading states
- accessibility basics
- mobile/tablet review
- print layouts

### Acceptance criteria
- Core workflows are usable on common desktop and mobile screen sizes.

---

## Phase 21 — Full QA & Regression Testing

Test complete end-to-end scenarios:

1. Configure school.
2. Create users/roles.
3. Create academic session/term/classes.
4. Create staff/teacher.
5. Register/admit student and guardian.
6. Enroll student.
7. Assign subjects/teachers.
8. Take attendance.
9. Configure assessments.
10. Enter and submit scores.
11. Process/review/approve/publish result.
12. Generate report card.
13. Generate invoice.
14. Record partial/full payment.
15. Generate receipt.
16. Promote student.
17. Confirm old records remain accessible.
18. Confirm unauthorized accounts cannot access protected records.

Fix all critical/high-severity issues before deployment.

---

## Phase 22 — Deployment Readiness

### Build/document
- production `.env` guidance
- `APP_DEBUG=false`
- HTTPS requirement
- storage permissions
- queue/scheduler configuration if used
- migration deployment process
- database backup procedure
- uploaded-file backup procedure
- restore procedure
- cron/scheduler configuration
- cache optimization commands
- web server configuration guidance

### Acceptance criteria
- Fresh production-style installation succeeds from documentation.
- Backup and restore are tested.
- No development secrets committed.

---

# 19. Seed Data

Provide safe development seeders for:

- Demo school
- Sections Nursery/Primary/JSS/SSS
- Nursery 1–2
- Primary 1–6
- JSS 1–3
- SS 1–3
- First/Second/Third Term
- Example academic session
- Default roles
- Default permissions
- Super Admin
- Example subjects
- Example grading scheme
- Example assessment scheme

Do not seed real personal data.

---

# 20. Naming and Code Quality

- Follow PSR standards and Laravel conventions.
- Use meaningful class/method names.
- Avoid duplicated business logic.
- Avoid giant controllers/models.
- Prefer enums/value objects for stable statuses where appropriate.
- Keep UI labels user-friendly even if internal codes are uppercase.
- Document complex domain logic.
- Avoid premature abstraction.
- Do not introduce packages unless they clearly reduce risk/complexity; document package purpose.

---

# 21. Performance Requirements

- Paginate large lists.
- Add indexes based on query patterns.
- Eager-load relationships to avoid N+1 queries.
- Avoid loading all students/results/payments into memory for reports.
- Queue expensive bulk operations when appropriate.
- Cache only where correctness is preserved.
- Keep authoritative transactional data in the database.

Suggested important indexes include combinations around:

- enrollments by session/class/status
- teacher assignments by session/class/subject
- attendance by term/class/date
- scores by assessment/enrollment
- subject registrations by enrollment/term
- results by term/enrollment
- invoices by student/status
- payments by student/date
- audit logs by school/date

---

# 22. Business Invariants

The AI code agent must preserve these invariants:

1. Historical enrollments are never destroyed by promotion.
2. A user cannot access another school's data.
3. A teacher cannot modify unassigned subject/class records.
4. A parent cannot access an unrelated child.
5. Score cannot exceed assessment maximum.
6. Published results cannot be silently altered.
7. Payment allocations cannot exceed the payment amount.
8. Payment allocations cannot exceed valid outstanding obligations.
9. Completed payments are reversed, not deleted.
10. Promotion is transactional.
11. Admission conversion is transactional.
12. Result publication is controlled by workflow/permission.
13. Old invoices retain historical amounts after fee configuration changes.
14. Old published results retain historical grades after grading configuration changes.
15. Audit logs are not editable by ordinary users.

Automated tests should explicitly verify these invariants.

---

# 23. MVP Boundary

The first production release MUST prioritize:

- Authentication/RBAC
- School configuration
- Students/guardians
- Staff/teachers
- Academic structure
- Enrollment
- Subjects/teacher assignments
- Attendance
- Assessments
- Results/report cards
- Promotion
- Basic admissions
- Basic finance/payments
- Core reports
- Audit/security

Do NOT delay the core system by adding the following before the MVP is stable:

- Flutter mobile app
- Online payment gateway
- SMS gateway
- WhatsApp integration
- E-learning/LMS
- CBT
- Library
- Hostel
- Transport tracking
- Payroll
- Biometrics
- Full accounting ERP

These belong to later releases.

---

# 24. Future Phase

After the web application is stable, expose versioned REST APIs and build a Flutter app for parents/teachers/students as needed.

Possible later modules:

```text
Mobile App
Online Payments
SMS/Email/WhatsApp Notifications
E-learning
CBT
Library
Transport
Hostel
Payroll
Biometric Attendance
Advanced Accounting
Advanced Analytics
```

Reuse the same application services and authorization rules rather than duplicating business logic.

---

# 25. Required Documentation Deliverables

Maintain throughout development:

- `README.md`
- installation/setup guide
- environment configuration guide
- database/migration notes
- role/permission documentation
- seed/demo credentials documentation (development only)
- deployment guide
- backup/restore guide
- test instructions
- known limitations
- change log or implementation progress log

---

# 26. AI Code Agent Execution Rules

The AI coding agent receiving this plan must:

1. Read the entire specification before editing code.
2. Inspect the existing repository if one exists.
3. Do not destroy working functionality unnecessarily.
4. Create a checklist from the phases.
5. Implement one phase at a time.
6. Run relevant tests after each meaningful change.
7. Run the full suite before marking a phase complete.
8. Fix migration, runtime, validation, authorization and test failures before continuing.
9. Use transactions for critical workflows.
10. Preserve backwards-compatible historical data.
11. Never bypass authorization merely to make a test/page work.
12. Never replace business rules with frontend-only checks.
13. Avoid fake placeholder implementations for completed phases.
14. Do not claim a feature is complete unless its happy path, validation, authorization and key failure paths work.
15. Update README/documentation as the implementation evolves.
16. At the end, perform a repository-wide audit for security, data integrity, broken routes, N+1 queries, unused code and inconsistent UI.

---

# 27. Definition of Done

The project is considered ready for first production deployment only when:

- all MVP modules are implemented;
- migrations run successfully on a clean database;
- seeders run successfully;
- authentication and RBAC work;
- tenant/school isolation is tested;
- core business invariants are tested;
- student history survives promotion;
- attendance works;
- assessment and result calculations are correct;
- result approval/publication workflow works;
- report cards generate correctly;
- finance supports invoices, partial/full payments, receipts and reversals;
- critical operations are audited;
- major reports work;
- responsive UI is usable;
- production error handling is safe;
- full automated test suite passes;
- deployment documentation is complete;
- backup and restore procedures have been tested;
- no known critical/high-severity bugs remain.

---

# 28. Final Implementation Goal

The finished system should allow a school to manage a learner continuously from initial admission through Nursery, Primary, Junior Secondary and Senior Secondary while preserving a trustworthy historical record of:

```text
Student Identity
    |
    +-- Guardians
    +-- Admissions
    +-- Enrollments by Academic Session
    |     +-- Class/Arm
    |     +-- Subjects
    |     +-- Attendance
    |     +-- Assessments
    |     +-- Results
    |     +-- Promotion
    |
    +-- Financial Records
    |     +-- Invoices
    |     +-- Payments
    |     +-- Receipts
    |
    +-- Documents
    +-- Requests
    +-- Audit History
```

The architecture must favor correctness, historical integrity, security, maintainability and configurability over shortcuts.

**End of Implementation Plan**

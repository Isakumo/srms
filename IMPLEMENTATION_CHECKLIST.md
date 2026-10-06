# Implementation Checklist

## Phase 0 — Project Initialization

- [x] Create initial repository structure
- [x] Configure Laravel project skeleton
- [x] Set up `.env.example`
- [x] Prepare MySQL configuration guidance
- [x] Configure Tailwind + Alpine frontend tooling
- [x] Configure test runner
- [x] Document project setup and progress

## Phase 1 — Identity, Authentication & RBAC

- [ ] Build schools, users, roles, permissions and assignments
- [ ] Add login/logout and password flows
- [ ] Add account status checks and middleware
- [ ] Add permission checks and policies
- [ ] Seed super admin and default roles
- [ ] Add user administration screens
- [ ] Write RBAC tests

## Phase 2 — School & Academic Configuration

- [ ] Build school profile and configuration screens
- [ ] Add sections, grade levels, class groups and settings
- [ ] Add academic sessions and terms
- [ ] Enforce current session/term rules
- [ ] Add tests for configuration and historical safety

## Phase 3 — Student & Guardian Management

- [ ] Build student records and guardians
- [ ] Add student documents and profile views
- [ ] Add enrollment compatibility workflow
- [ ] Add student list/search/filter UI
- [ ] Add tests for uniqueness and access control

## Phase 4 — Staff & Teacher Management

- [ ] Build staff profiles and linked users
- [ ] Add teacher assignments and class teacher assignments
- [ ] Add assignment history retention
- [ ] Write tests for assignment limits and authorization

## Phase 5 — Subjects, Enrollment & Subject Registration

- [ ] Build subjects and grade-level subject registration
- [ ] Add enrollment records and history
- [ ] Add subject registration by term
- [ ] Validate historical preservation and duplicate rules

## Phase 6 — Dashboard Foundation

- [ ] Add role-based dashboard widgets
- [ ] Enforce permissions on dashboard queries
- [ ] Validate secure access to dashboard data

## Phase 7 — Timetable

- [ ] Add timetable periods and entries
- [ ] Detect class, teacher and room conflicts
- [ ] Add UI for class and teacher timetables

## Phase 8 — Attendance

- [ ] Add attendance sessions and records
- [ ] Add mark-all-present and submission workflow
- [ ] Add correction authorization rules
- [ ] Add attendance reports

## Phase 9 — Assessment Configuration

- [ ] Build assessment schemes and components
- [ ] Add grading schemes and grade bands
- [ ] Enforce valid grade band ranges
- [ ] Add assessment configuration tests

## Phase 10 — Score Entry & Submission

- [ ] Add score entry screens and validations
- [ ] Add draft/save/submit/lock workflows
- [ ] Add audit trails for post-submission edits

## Phase 11 — Result Processing & Report Cards

- [ ] Add result calculation service
- [ ] Implement grading and totals
- [ ] Add review / approval / publication pipeline
- [ ] Generate report cards and snapshots

## Phase 12 — Promotion, Repetition, Graduation & Transfer

- [ ] Add promotion batches and records
- [ ] Enforce transactional promotion logic
- [ ] Handle repetitions and graduation safely

## Phase 13 — Admissions

- [ ] Add application lifecycle and review workflow
- [ ] Add conversion into student + guardians + enrollment
- [ ] Enforce accepted-applicant conversion rules

## Phase 14 — Finance Foundation

- [ ] Add fees, structures and invoice generation
- [ ] Maintain historical invoice values
- [ ] Add student finance overview screens

## Phase 15 — Payments, Receipts & Expenses

- [ ] Add payment workflow and allocation logic
- [ ] Add reversal and audit recording
- [ ] Add expense approvals and finance dashboards

## Phase 16 — Communication

- [ ] Add announcements and audience targeting
- [ ] Add notifications where included in the phase scope

## Phase 17 — Applications / Service Requests

- [ ] Add request types and request workflow
- [ ] Add status history and audit trails

## Phase 18 — Reports & Analytics

- [ ] Build student, academic, attendance and finance reports
- [ ] Add filters, pagination and print/export support

## Phase 19 — Audit, Security Hardening & Data Integrity

- [ ] Review authorization, tenant isolation and policy rules
- [ ] Review file upload security and auditing
- [ ] Add validation and security tests

## Phase 20 — UX Polish

- [ ] Review responsive layouts and common user flows
- [ ] Add loading and empty states
- [ ] Improve accessibility and navigation

## Phase 21 — Full QA & Regression Testing

- [ ] Run full test suite
- [ ] Confirm end-to-end business workflow stability
- [ ] Fix critical issues before deployment

## Phase 22 — Deployment Readiness

- [ ] Document production setup
- [ ] Define backup and restore process
- [ ] Validate deployment checklist

## Notes

The implementation must follow the business invariants, security requirements, and phase execution rules in the main implementation plan.

<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['code' => 'students.view', 'name' => 'View students', 'module' => 'students'],
            ['code' => 'students.create', 'name' => 'Create students', 'module' => 'students'],
            ['code' => 'students.update', 'name' => 'Update students', 'module' => 'students'],
            ['code' => 'students.archive', 'name' => 'Archive students', 'module' => 'students'],
            ['code' => 'guardians.view', 'name' => 'View guardians', 'module' => 'guardians'],
            ['code' => 'guardians.create', 'name' => 'Create guardians', 'module' => 'guardians'],
            ['code' => 'guardians.update', 'name' => 'Update guardians', 'module' => 'guardians'],
            ['code' => 'admissions.view', 'name' => 'View admissions', 'module' => 'admissions'],
            ['code' => 'admissions.create', 'name' => 'Create admissions', 'module' => 'admissions'],
            ['code' => 'admissions.review', 'name' => 'Review admissions', 'module' => 'admissions'],
            ['code' => 'admissions.approve', 'name' => 'Approve admissions', 'module' => 'admissions'],
            ['code' => 'staff.view', 'name' => 'View staff', 'module' => 'staff'],
            ['code' => 'staff.create', 'name' => 'Create staff', 'module' => 'staff'],
            ['code' => 'staff.update', 'name' => 'Update staff', 'module' => 'staff'],
            ['code' => 'classes.view', 'name' => 'View classes', 'module' => 'classes'],
            ['code' => 'classes.create', 'name' => 'Create classes', 'module' => 'classes'],
            ['code' => 'classes.update', 'name' => 'Update classes', 'module' => 'classes'],
            ['code' => 'subjects.view', 'name' => 'View subjects', 'module' => 'subjects'],
            ['code' => 'subjects.create', 'name' => 'Create subjects', 'module' => 'subjects'],
            ['code' => 'subjects.update', 'name' => 'Update subjects', 'module' => 'subjects'],
            ['code' => 'teacher_assignments.view', 'name' => 'View teacher assignments', 'module' => 'teacher_assignments'],
            ['code' => 'teacher_assignments.manage', 'name' => 'Manage teacher assignments', 'module' => 'teacher_assignments'],
            ['code' => 'attendance.view', 'name' => 'View attendance', 'module' => 'attendance'],
            ['code' => 'attendance.create', 'name' => 'Create attendance', 'module' => 'attendance'],
            ['code' => 'attendance.update', 'name' => 'Update attendance', 'module' => 'attendance'],
            ['code' => 'attendance.approve_correction', 'name' => 'Approve attendance corrections', 'module' => 'attendance'],
            ['code' => 'assessments.view', 'name' => 'View assessments', 'module' => 'assessments'],
            ['code' => 'assessments.create', 'name' => 'Create assessments', 'module' => 'assessments'],
            ['code' => 'assessments.update', 'name' => 'Update assessments', 'module' => 'assessments'],
            ['code' => 'assessments.open', 'name' => 'Open assessments', 'module' => 'assessments'],
            ['code' => 'assessments.close', 'name' => 'Close assessments', 'module' => 'assessments'],
            ['code' => 'scores.view', 'name' => 'View scores', 'module' => 'scores'],
            ['code' => 'scores.create', 'name' => 'Create scores', 'module' => 'scores'],
            ['code' => 'scores.update', 'name' => 'Update scores', 'module' => 'scores'],
            ['code' => 'scores.submit', 'name' => 'Submit scores', 'module' => 'scores'],
            ['code' => 'scores.unlock', 'name' => 'Unlock scores', 'module' => 'scores'],
            ['code' => 'results.view', 'name' => 'View results', 'module' => 'results'],
            ['code' => 'results.process', 'name' => 'Process results', 'module' => 'results'],
            ['code' => 'results.review', 'name' => 'Review results', 'module' => 'results'],
            ['code' => 'results.approve', 'name' => 'Approve results', 'module' => 'results'],
            ['code' => 'results.publish', 'name' => 'Publish results', 'module' => 'results'],
            ['code' => 'promotion.view', 'name' => 'View promotions', 'module' => 'promotion'],
            ['code' => 'promotion.process', 'name' => 'Process promotions', 'module' => 'promotion'],
            ['code' => 'promotion.approve', 'name' => 'Approve promotions', 'module' => 'promotion'],
            ['code' => 'fees.view', 'name' => 'View fees', 'module' => 'finance'],
            ['code' => 'fees.manage', 'name' => 'Manage fees', 'module' => 'finance'],
            ['code' => 'invoices.view', 'name' => 'View invoices', 'module' => 'finance'],
            ['code' => 'invoices.create', 'name' => 'Create invoices', 'module' => 'finance'],
            ['code' => 'payments.view', 'name' => 'View payments', 'module' => 'finance'],
            ['code' => 'payments.create', 'name' => 'Create payments', 'module' => 'finance'],
            ['code' => 'payments.verify', 'name' => 'Verify payments', 'module' => 'finance'],
            ['code' => 'payments.reverse', 'name' => 'Reverse payments', 'module' => 'finance'],
            ['code' => 'expenses.view', 'name' => 'View expenses', 'module' => 'finance'],
            ['code' => 'expenses.create', 'name' => 'Create expenses', 'module' => 'finance'],
            ['code' => 'expenses.approve', 'name' => 'Approve expenses', 'module' => 'finance'],
            ['code' => 'reports.students', 'name' => 'Student reports', 'module' => 'reports'],
            ['code' => 'reports.academic', 'name' => 'Academic reports', 'module' => 'reports'],
            ['code' => 'reports.attendance', 'name' => 'Attendance reports', 'module' => 'reports'],
            ['code' => 'reports.financial', 'name' => 'Financial reports', 'module' => 'reports'],
            ['code' => 'reports.staff', 'name' => 'Staff reports', 'module' => 'reports'],
            ['code' => 'users.view', 'name' => 'View users', 'module' => 'users'],
            ['code' => 'users.create', 'name' => 'Create users', 'module' => 'users'],
            ['code' => 'users.update', 'name' => 'Update users', 'module' => 'users'],
            ['code' => 'users.disable', 'name' => 'Disable users', 'module' => 'users'],
            ['code' => 'roles.view', 'name' => 'View roles', 'module' => 'roles'],
            ['code' => 'roles.create', 'name' => 'Create roles', 'module' => 'roles'],
            ['code' => 'roles.update', 'name' => 'Update roles', 'module' => 'roles'],
            ['code' => 'roles.assign', 'name' => 'Assign roles', 'module' => 'roles'],
            ['code' => 'settings.view', 'name' => 'View settings', 'module' => 'settings'],
            ['code' => 'settings.update', 'name' => 'Update settings', 'module' => 'settings'],
            ['code' => 'audit_logs.view', 'name' => 'View audit logs', 'module' => 'audit'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['code' => $permission['code']],
                $permission
            );
        }
    }
}

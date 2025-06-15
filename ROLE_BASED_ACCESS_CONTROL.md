# CSD Intranet - Role-Based Access Control Implementation

## Overview
The CSD Intranet system now implements a comprehensive role-based access control (RBAC) system that differentiates between different user types and their permissions.

## User Roles

### 1. Admin
- **Full System Access**: Complete control over all features
- **User Management**: Can manage all users (future feature)
- **Attendance Management**: Can view, create, edit, and delete attendance for all employees
- **Event Management**: Can create, edit, and delete events
- **Report Management**: Can create, view, edit, and delete reports
- **Dashboard Access**: Full dashboard with system statistics

### 2. HR (Human Resources)
- **Employee Management**: Can manage attendance, events, and reports
- **Attendance Management**: Can view, create, edit, and delete attendance for all employees
- **Event Management**: Can create, edit, and delete events
- **Report Management**: Can create, view, edit, and delete reports
- **Dashboard Access**: HR-focused dashboard

### 3. Employee
- **Self-Service Access**: Limited to own data and viewing public information
- **Attendance**: Can view own attendance records and mark own attendance
- **Events**: Can view events (read-only)
- **Reports**: No access to reports section
- **Dashboard Access**: Personal dashboard showing own statistics

## Key Features Implemented

### 1. Database Schema Updates
- Added `role` column to `users` table with ENUM('admin', 'hr', 'employee')
- Added `created_by` columns to track who created records
- Added unique constraints to prevent duplicate attendance entries

### 2. Authentication & Authorization
- **AuthMiddleware**: Centralized permission checking
- **Session Management**: Role information stored in sessions
- **Route Protection**: Controllers check permissions before allowing access

### 3. User Interface Adaptations
- **Role-based Navigation**: Different menu items based on user role
- **Conditional Buttons**: Create/Edit/Delete buttons shown based on permissions
- **User Info Display**: Shows current user role in header
- **Contextual Messages**: Different content for different user types

### 4. Attendance System Enhancements
- **Self-Service**: Employees can mark their own attendance
- **Permission-based Views**: Employees see only their records, HR/Admin see all
- **Edit Restrictions**: Employees can edit own records, HR/Admin can edit any
- **Audit Trail**: Tracks who created each attendance record

## Default User Accounts

After running setup.php, the following accounts are available:

| Username | Password | Role | Email |
|----------|----------|------|-------|
| admin | admin123 | Admin | admin@csd.com |
| mike_johnson | password123 | HR | mike.johnson@csd.com |
| john_doe | password123 | Employee | john.doe@csd.com |
| jane_smith | password123 | Employee | jane.smith@csd.com |
| sarah_wilson | password123 | Employee | sarah.wilson@csd.com |

## Testing the System

### As an Employee (john_doe):
1. Login with: john_doe / password123
2. **Dashboard**: See personal statistics
3. **Attendance**: 
   - View only your own attendance records
   - Use "Mark My Attendance" to record your attendance
   - Edit your own attendance records
4. **Events**: View events (no create/edit/delete options)
5. **Reports**: No access (menu item not visible)

### As HR (mike_johnson):
1. Login with: mike_johnson / password123
2. **Dashboard**: See organization-wide statistics
3. **Attendance**: 
   - View all employee attendance records
   - Create attendance for any employee
   - Edit/delete any attendance record
4. **Events**: Full CRUD operations
5. **Reports**: Full CRUD operations

### As Admin (admin):
1. Login with: admin / admin123
2. **Full Access**: All features available
3. **Complete Control**: Can manage all aspects of the system

## Key Differences from Previous Version

### Before Role Implementation:
- ❌ All users had identical access
- ❌ No distinction between admin and regular users
- ❌ Employees could manage others' attendance
- ❌ Everyone could create/edit/delete events and reports

### After Role Implementation:
- ✅ Role-based access control
- ✅ Proper separation of concerns
- ✅ Self-service for employees
- ✅ Administrative controls for HR and Admin
- ✅ Audit trails and data ownership
- ✅ Secure permission checking

## Security Improvements

1. **Middleware Protection**: All controllers check permissions
2. **Session Validation**: Role information verified on each request
3. **UI Security**: Buttons and forms hidden based on permissions
4. **Data Isolation**: Employees see only their own data
5. **Audit Logging**: Track who performs what actions

## Migration Instructions

For existing installations:

1. **Backup Database**: Always backup before migration
2. **Run Migration**: Access `migrate_roles.php` via web browser
3. **Verify Roles**: Check that users have appropriate roles assigned
4. **Test Access**: Login with different accounts to verify permissions

For new installations:

1. **Run Setup**: Access `setup.php` via web browser
2. **Database Creation**: Creates tables with role support
3. **Sample Data**: Includes users with different roles
4. **Ready to Use**: System ready with role-based access

## Future Enhancements

1. **User Management Interface**: Admin panel for managing users
2. **Role Permissions Configuration**: Dynamic permission settings
3. **Department-based Access**: Additional organizational hierarchy
4. **Advanced Reporting**: Role-specific reports and analytics
5. **Email Notifications**: Role-based notification system

## Troubleshooting

### Common Issues:
1. **403 Access Denied**: User doesn't have required permissions
2. **Missing Menu Items**: Feature not available for user role
3. **Empty Views**: Employee viewing data they don't have access to

### Solutions:
1. Check user role in session
2. Verify middleware is working
3. Review permission requirements in controllers
4. Check database role assignments

This implementation provides a solid foundation for a multi-user intranet system with proper security and user experience tailored to different organizational roles.

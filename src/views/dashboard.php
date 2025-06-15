<?php include 'includes/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <?php $userRole = $_SESSION['role']; ?>
    
    <?php if ($userRole === 'employee'): ?>
        <!-- EMPLOYEE DASHBOARD -->
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Dashboard</h1>
            <p class="text-gray-600">Welcome back, <?php echo htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username']); ?>! Here's your personal overview.</p>
        </div>

        <!-- Personal Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Days Worked This Month -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-blue-100 text-sm font-medium">Days Worked This Month</p>
                        <p class="text-3xl font-bold"><?php echo $stats['my_attendance_this_month'] ?? 0; ?></p>
                    </div>
                </div>
            </div>

            <!-- Attendance Percentage -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-green-100 text-sm font-medium">Attendance Rate</p>
                        <p class="text-3xl font-bold"><?php echo $stats['my_attendance_percentage'] ?? 0; ?>%</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-white bg-opacity-30 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-purple-100 text-sm font-medium">Upcoming Events</p>
                        <p class="text-3xl font-bold"><?php echo $stats['upcoming_events'] ?? 0; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Dashboard Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="?controller=Attendance&action=markOwn" class="block w-full bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-4 transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Mark My Attendance</p>
                                <p class="text-xs text-gray-500">Record your attendance for today</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="?controller=Attendance&action=index" class="block w-full bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-4 transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">View My Attendance</p>
                                <p class="text-xs text-gray-500">Check your attendance history</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="?controller=Event&action=index" class="block w-full bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg p-4 transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">View Events</p>
                                <p class="text-xs text-gray-500">Check upcoming events and activities</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- My Recent Activity -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">My Recent Activity</h3>
                <?php if (!empty($recentActivity)): ?>
                    <div class="space-y-3">
                        <?php foreach (array_slice($recentActivity, 0, 5) as $activity): ?>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 capitalize"><?php echo htmlspecialchars($activity['description']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo date('M d, Y', strtotime($activity['activity_date'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-sm">No recent activity found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Personal Insights -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Insights</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600"><?php echo $quickStats['attendance_streak'] ?? 0; ?></div>
                    <div class="text-sm text-gray-600">Days Streak</div>
                </div>
                
                <?php if (isset($quickStats['next_event']) && $quickStats['next_event']): ?>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-sm font-medium text-purple-600"><?php echo htmlspecialchars($quickStats['next_event']['title']); ?></div>
                        <div class="text-xs text-gray-600"><?php echo date('M d, Y', strtotime($quickStats['next_event']['event_date'])); ?></div>
                    </div>
                <?php else: ?>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-600">No upcoming events</div>
                    </div>
                <?php endif; ?>
                
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600"><?php echo $quickStats['days_worked_this_month'] ?? 0; ?></div>
                    <div class="text-sm text-gray-600">This Month</div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- ADMIN/HR DASHBOARD -->
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Administrative Dashboard</h1>
            <p class="text-gray-600">Welcome to CSD Intranet. Here's an overview of your organization.</p>
        </div>

        <!-- Organizational Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo $stats['total_users']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Today's Attendance -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Today's Attendance</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo $stats['today_attendance']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Upcoming Events</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo $stats['upcoming_events']; ?></p>
                    </div>
                </div>
            </div>

            <!-- Total Reports -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Reports</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo $stats['total_reports']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin/HR Dashboard Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Today's Statistics -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Today's Overview</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="text-xl font-bold text-green-600"><?php echo $quickStats['present_today'] ?? 0; ?></div>
                        <div class="text-xs text-gray-600">Present</div>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="text-xl font-bold text-red-600"><?php echo $quickStats['absent_today'] ?? 0; ?></div>
                        <div class="text-xs text-gray-600">Absent</div>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-xl font-bold text-yellow-600"><?php echo $quickStats['on_leave_today'] ?? 0; ?></div>
                        <div class="text-xs text-gray-600">On Leave</div>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Attendance Rate</span>
                        <span class="text-lg font-semibold text-blue-600"><?php echo $quickStats['attendance_rate'] ?? 0; ?>%</span>
                    </div>
                </div>
            </div>

            <!-- System Activity -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent System Activity</h3>
                <?php if (!empty($recentActivity)): ?>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        <?php foreach (array_slice($recentActivity, 0, 8) as $activity): ?>
                            <div class="flex items-center p-2 hover:bg-gray-50 rounded">
                                <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm text-gray-900"><?php echo htmlspecialchars($activity['description']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo date('M d, H:i', strtotime($activity['activity_date'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-sm">No recent activity found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Administrative Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Attendance Management -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-lg font-semibold text-gray-900">Attendance Management</h3>
                </div>
                <p class="text-gray-600 mb-4">Manage employee attendance records and reports.</p>
                <div class="flex space-x-3">
                    <a href="?controller=Attendance&action=index" class="btn-primary text-sm">View All</a>
                    <a href="?controller=Attendance&action=create" class="btn-secondary text-sm">Add Record</a>
                </div>
            </div>

            <!-- Events Management -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-lg font-semibold text-gray-900">Events Management</h3>
                </div>
                <p class="text-gray-600 mb-4">Create and manage organizational events and activities.</p>
                <div class="flex space-x-3">
                    <a href="?controller=Event&action=index" class="btn-primary text-sm">View Events</a>
                    <a href="?controller=Event&action=create" class="btn-secondary text-sm">Create Event</a>
                </div>
            </div>

            <!-- Reports Management -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="ml-4 text-lg font-semibold text-gray-900">Reports</h3>
                </div>
                <p class="text-gray-600 mb-4">Generate and view various reports and documents.</p>
                <div class="flex space-x-3">
                    <a href="?controller=Report&action=index" class="btn-primary text-sm">View Reports</a>
                    <a href="?controller=Report&action=create" class="btn-secondary text-sm">Generate Report</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
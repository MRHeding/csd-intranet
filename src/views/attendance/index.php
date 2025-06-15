<?php include 'includes/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'employee'): ?>
                    My Attendance Records
                <?php else: ?>
                    Attendance Records
                <?php endif; ?>
            </h1>
            <p class="text-gray-600">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'employee'): ?>
                    View and manage your attendance records
                <?php else: ?>
                    Track and manage employee attendance records
                <?php endif; ?>
            </p>
        </div>
        <div class="flex space-x-3">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'employee'): ?>
                <a href="?controller=Attendance&action=markOwn" class="btn-primary">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Mark My Attendance
                </a>
            <?php else: ?>
                <a href="?controller=Attendance&action=create" class="btn-primary">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Mark Attendance
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Messages -->
    <?php if (isset($_GET['message']) && $_GET['message'] == 'deleted'): ?>
        <div class="alert-success">
            <strong>Success!</strong> Attendance record deleted successfully.
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error']) && $_GET['error'] == 'delete_failed'): ?>
        <div class="alert-error">
            <strong>Error!</strong> Failed to delete attendance record.
        </div>
    <?php endif; ?>

    <!-- Attendance Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">All Attendance Records</h3>
        </div>
        
        <?php if (empty($attendanceRecords)): ?>
            <div class="px-6 py-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No attendance records</h3>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'employee'): ?>
                    <p class="text-gray-600 mb-4">You haven't marked any attendance yet.</p>
                    <a href="?controller=Attendance&action=markOwn" class="btn-primary">Mark My Attendance</a>
                <?php else: ?>
                    <p class="text-gray-600 mb-4">Get started by marking attendance for employees.</p>
                    <a href="?controller=Attendance&action=create" class="btn-primary">Mark Attendance</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($attendanceRecords as $record): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                <span class="text-white font-medium text-sm">
                                                    <?php echo strtoupper(substr($record['full_name'] ?? $record['username'] ?? 'U', 0, 1)); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($record['full_name'] ?? $record['username'] ?? 'Unknown User'); ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?php echo htmlspecialchars($record['username'] ?? ''); ?> • <?php echo htmlspecialchars($record['email'] ?? ''); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo date('M j, Y', strtotime($record['date'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $statusClasses = [
                                        'present' => 'bg-green-100 text-green-800',
                                        'absent' => 'bg-red-100 text-red-800',
                                        'leave' => 'bg-yellow-100 text-yellow-800'
                                    ];
                                    $class = $statusClasses[$record['status']] ?? 'bg-gray-100 text-gray-800';
                                    ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $class; ?>">
                                        <?php echo ucfirst($record['status']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <?php 
                                        $canEdit = false;
                                        $canDelete = false;
                                        
                                        if (isset($_SESSION['role'])) {
                                            if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'hr') {
                                                $canEdit = true;
                                                $canDelete = true;
                                            } elseif ($_SESSION['role'] === 'employee' && $record['user_id'] == $_SESSION['user_id']) {
                                                $canEdit = true; // Employees can edit their own records
                                            }
                                        }
                                        ?>
                                        
                                        <?php if ($canEdit): ?>
                                            <a href="?controller=Attendance&action=edit&id=<?php echo $record['id']; ?>" 
                                               class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ($canDelete): ?>
                                            <a href="?controller=Attendance&action=delete&id=<?php echo $record['id']; ?>" 
                                               class="text-red-600 hover:text-red-900"
                                               onclick="return confirm('Are you sure you want to delete this attendance record?')">Delete</a>
                                        <?php endif; ?>
                                        
                                        <?php if (!$canEdit && !$canDelete): ?>
                                            <span class="text-gray-400">No actions</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
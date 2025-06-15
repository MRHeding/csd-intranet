<?php include 'includes/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="?controller=Attendance&action=index" class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Attendance</h1>
        </div>
        <p class="text-gray-600">Update attendance record</p>
    </div>

    <!-- Messages -->
    <?php if (!empty($message)): ?>
        <div class="alert-<?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Attendance Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="POST" action="?controller=Attendance&action=edit&id=<?php echo $attendance['id']; ?>" class="space-y-6">
            <!-- Employee Info (Read-only) -->
            <div class="form-group">
                <label class="form-label">Employee</label>
                <div class="p-3 bg-gray-50 rounded-lg border">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8">
                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                <span class="text-white font-medium text-xs">
                                    <?php echo strtoupper(substr($attendance['username'], 0, 1)); ?>
                                </span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">
                                <?php echo htmlspecialchars($attendance['username']); ?>
                            </div>
                            <div class="text-sm text-gray-500">
                                <?php echo htmlspecialchars($attendance['email']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date (Read-only) -->
            <div class="form-group">
                <label class="form-label">Date</label>
                <div class="p-3 bg-gray-50 rounded-lg border">
                    <span class="text-gray-900"><?php echo date('F j, Y', strtotime($attendance['date'])); ?></span>
                </div>
            </div>

            <!-- Status (Editable) -->
            <div class="form-group">
                <label for="status" class="form-label">Status *</label>
                <select id="status" name="status" required class="form-select">
                    <option value="present" <?php echo ($attendance['status'] == 'present') ? 'selected' : ''; ?>>
                        Present
                    </option>
                    <option value="absent" <?php echo ($attendance['status'] == 'absent') ? 'selected' : ''; ?>>
                        Absent
                    </option>
                    <option value="leave" <?php echo ($attendance['status'] == 'leave') ? 'selected' : ''; ?>>
                        On Leave
                    </option>
                </select>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="?controller=Attendance&action=index" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Attendance
                </button>
            </div>
        </form>
    </div>

    <!-- Record Info -->
    <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-gray-800 mb-1">Record Information</h3>
                <p class="text-sm text-gray-600">
                    Created on: <?php echo date('F j, Y \a\t g:i A', strtotime($attendance['created_at'])); ?>
                </p>
                <p class="text-sm text-gray-600 mt-1">
                    Note: You can only change the attendance status. Employee and date cannot be modified.
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

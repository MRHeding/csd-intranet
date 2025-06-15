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
            <h1 class="text-3xl font-bold text-gray-900">Mark Attendance</h1>
        </div>
        <p class="text-gray-600">Record attendance for an employee</p>
    </div>

    <!-- Messages -->
    <?php if (!empty($message)): ?>
        <div class="alert-<?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Attendance Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="POST" action="?controller=Attendance&action=create" class="space-y-6">
            <!-- Employee Selection -->
            <div class="form-group">
                <label for="user_id" class="form-label">Employee *</label>
                <select id="user_id" name="user_id" required class="form-select">
                    <option value="">Select an employee</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>" <?php echo (isset($_POST['user_id']) && $_POST['user_id'] == $user['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars(($user['full_name'] ?? $user['username']) . ' (' . $user['email'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Date -->
            <div class="form-group">
                <label for="date" class="form-label">Date *</label>
                <input type="date" 
                       id="date" 
                       name="date" 
                       value="<?php echo isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'); ?>"
                       max="<?php echo date('Y-m-d'); ?>"
                       required 
                       class="form-input">
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status" class="form-label">Status *</label>
                <select id="status" name="status" required class="form-select">
                    <option value="">Select status</option>
                    <option value="present" <?php echo (isset($_POST['status']) && $_POST['status'] == 'present') ? 'selected' : ''; ?>>
                        Present
                    </option>
                    <option value="absent" <?php echo (isset($_POST['status']) && $_POST['status'] == 'absent') ? 'selected' : ''; ?>>
                        Absent
                    </option>
                    <option value="leave" <?php echo (isset($_POST['status']) && $_POST['status'] == 'leave') ? 'selected' : ''; ?>>
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
                    Record Attendance
                </button>
            </div>
        </form>
    </div>

    <!-- Instructions -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-blue-800 mb-1">Instructions</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Select the employee from the dropdown list</li>
                    <li>• Choose the appropriate date (cannot be in the future)</li>
                    <li>• Select the attendance status</li>
                    <li>• You cannot mark attendance for the same employee on the same date twice</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
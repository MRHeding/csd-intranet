<?php include 'includes/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="?controller=Report&action=index" class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Report</h1>
        </div>
        <p class="text-gray-600">Update report content</p>
    </div>

    <!-- Messages -->
    <?php if (!empty($message)): ?>
        <div class="alert-<?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Report Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="POST" action="?controller=Report&action=edit&id=<?php echo $report['id']; ?>" class="space-y-6">
            <!-- Report Title -->
            <div class="form-group">
                <label for="title" class="form-label">Report Title *</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="<?php echo htmlspecialchars($report['title']); ?>"
                       required 
                       class="form-input">
            </div>

            <!-- Report Content -->
            <div class="form-group">
                <label for="content" class="form-label">Report Content *</label>
                <textarea id="content" 
                          name="content" 
                          rows="12" 
                          required
                          class="form-input"><?php echo htmlspecialchars($report['content']); ?></textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="?controller=Report&action=view&id=<?php echo $report['id']; ?>" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Report
                </button>
            </div>
        </form>
    </div>

    <!-- Report Info -->
    <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-gray-800 mb-1">Report Information</h3>
                <p class="text-sm text-gray-600">
                    Created on: <?php echo date('F j, Y \a\t g:i A', strtotime($report['created_at'])); ?>
                </p>
                <p class="text-sm text-gray-600">
                    Report ID: #<?php echo $report['id']; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

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
            <h1 class="text-3xl font-bold text-gray-900">Create Report</h1>
        </div>
        <p class="text-gray-600">Generate a new report document</p>
    </div>

    <!-- Messages -->
    <?php if (!empty($message)): ?>
        <div class="alert-<?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Report Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="POST" action="?controller=Report&action=create" class="space-y-6">
            <!-- Report Title -->
            <div class="form-group">
                <label for="title" class="form-label">Report Title *</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>"
                       required 
                       class="form-input"
                       placeholder="Enter report title">
            </div>

            <!-- Report Content -->
            <div class="form-group">
                <label for="content" class="form-label">Report Content *</label>
                <textarea id="content" 
                          name="content" 
                          rows="12" 
                          required
                          class="form-input"
                          placeholder="Enter the detailed content of your report..."><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="?controller=Report&action=index" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Create Report
                </button>
            </div>
        </form>
    </div>

    <!-- Tips -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-blue-800 mb-1">Report Writing Tips</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Use a clear and descriptive title</li>
                    <li>• Structure your content with headings and bullet points</li>
                    <li>• Include relevant data, statistics, and findings</li>
                    <li>• Keep the language professional and concise</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

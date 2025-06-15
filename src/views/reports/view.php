<?php include 'includes/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="?controller=Report&action=index" class="text-gray-600 hover:text-gray-900 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900"><?php echo htmlspecialchars($report['title']); ?></h1>
                    <p class="text-gray-600 mt-1">Created on <?php echo date('F j, Y \a\t g:i A', strtotime($report['created_at'])); ?></p>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="?controller=Report&action=edit&id=<?php echo $report['id']; ?>" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <button onclick="window.print()" class="btn-primary">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print
                </button>
            </div>
        </div>
    </div>

    <!-- Report Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
        <div class="prose max-w-none">
            <?php echo nl2br(htmlspecialchars($report['content'])); ?>
        </div>
    </div>

    <!-- Report Metadata -->
    <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-gray-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-gray-800 mb-1">Report Information</h3>
                <p class="text-sm text-gray-600">
                    Report ID: #<?php echo $report['id']; ?>
                </p>
                <p class="text-sm text-gray-600">
                    Created: <?php echo date('F j, Y \a\t g:i A', strtotime($report['created_at'])); ?>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn-primary, .btn-secondary, nav, header, footer {
        display: none !important;
    }
    
    .container {
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    body {
        background: white !important;
    }
}
</style>

<?php include 'includes/footer.php'; ?>

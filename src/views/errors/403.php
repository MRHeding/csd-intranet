<?php include 'includes/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto text-center">        <div class="mb-8">            <div class="mx-auto h-16 w-16 flex items-center justify-center mb-4">
                <img src="assets/img/csd.png" alt="CSD Logo" class="csd-logo-large">
            </div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-red-100">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Access Denied</h1>
        <p class="text-gray-600 mb-8">You don't have permission to access this resource. Please contact your administrator if you believe this is an error.</p>
        
        <div class="space-y-4">
            <a href="?controller=Dashboard&action=dashboard" class="btn-primary inline-block">
                Go to Dashboard
            </a>
            <br>
            <a href="?controller=Auth&action=logout" class="text-gray-500 hover:text-gray-700">
                Logout
            </a>
        </div>
        
        <div class="mt-8 text-sm text-gray-500">
            <p>Your current role: <span class="font-medium"><?php echo ucfirst($_SESSION['role'] ?? 'Unknown'); ?></span></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

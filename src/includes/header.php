<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSD Intranet</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <img src="assets/img/csd.png" alt="CSD Logo" class="csd-logo">
                    <h1 class="text-2xl font-bold text-blue-600">CSD Intranet</h1>
                </div>
                
                <?php 
                // Check if we're on an authentication page
                $controller = $_GET['controller'] ?? 'Auth';
                $action = $_GET['action'] ?? 'login';
                $isAuthPage = ($controller === 'Auth' && ($action === 'login' || $action === 'register'));
                ?>
                
                <?php if (!$isAuthPage): ?>
                <nav class="hidden md:flex space-x-8">
                    <a href="?controller=Dashboard&action=dashboard" class="text-gray-600 hover:text-blue-600 font-medium transition duration-200">Dashboard</a>
                    <a href="?controller=Attendance&action=index" class="text-gray-600 hover:text-blue-600 font-medium transition duration-200">Attendance</a>
                    <a href="?controller=Event&action=index" class="text-gray-600 hover:text-blue-600 font-medium transition duration-200">Events</a>
                    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'hr')): ?>
                        <a href="?controller=Report&action=index" class="text-gray-600 hover:text-blue-600 font-medium transition duration-200">Reports</a>
                    <?php endif; ?>
                    
                    <!-- User Info Dropdown -->
                    <div class="relative inline-block text-left">
                        <div class="flex items-center space-x-2 text-gray-600">
                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                                <span class="text-white font-medium text-sm">
                                    <?php echo strtoupper(substr($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'U', 0, 1)); ?>
                                </span>
                            </div>
                            <div class="hidden sm:block">
                                <div class="text-sm font-medium"><?php echo htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'User'); ?></div>
                                <div class="text-xs text-gray-500"><?php echo ucfirst($_SESSION['role'] ?? 'employee'); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="?controller=Auth&action=logout" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">Logout</a>
                </nav>
                <!-- Mobile menu button -->
                <button class="md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <main class="flex-grow">
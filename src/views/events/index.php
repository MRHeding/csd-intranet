<?php include 'includes/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Events</h1>
            <p class="text-gray-600">Stay updated with organizational events and activities</p>
        </div>
        <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'hr')): ?>
            <a href="?controller=Event&action=create" class="btn-primary">
                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Event
            </a>
        <?php endif; ?>
    </div>

    <!-- Messages -->
    <?php if (isset($_GET['message']) && $_GET['message'] == 'deleted'): ?>
        <div class="alert-success">
            <strong>Success!</strong> Event deleted successfully.
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error']) && $_GET['error'] == 'delete_failed'): ?>
        <div class="alert-error">
            <strong>Error!</strong> Failed to delete event.
        </div>
    <?php endif; ?>

    <!-- Events List -->
    <?php if (empty($events)): ?>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No events scheduled</h3>
            <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'hr')): ?>
                <p class="text-gray-600 mb-4">Get started by creating your first event.</p>
                <a href="?controller=Event&action=create" class="btn-primary">Create Event</a>
            <?php else: ?>
                <p class="text-gray-600">No events are currently scheduled. Check back later for updates.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="grid gap-6">
            <?php foreach ($events as $event): ?>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <h3 class="text-xl font-semibold text-gray-900 mr-4">
                                    <?php echo htmlspecialchars($event['title']); ?>
                                </h3>
                                <?php
                                $eventDateTime = new DateTime($event['event_date']);
                                $now = new DateTime();
                                $isUpcoming = $eventDateTime > $now;
                                $isPast = $eventDateTime < $now;
                                $isToday = $eventDateTime->format('Y-m-d') === $now->format('Y-m-d');
                                ?>
                                <?php if ($isToday): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Today</span>
                                <?php elseif ($isUpcoming): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Upcoming</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Past</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="flex items-center text-gray-600 mb-3">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm">
                                    <?php echo $eventDateTime->format('F j, Y \a\t g:i A'); ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($event['description'])): ?>
                                <p class="text-gray-700 text-sm leading-relaxed">
                                    <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex space-x-2 ml-4">
                            <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'hr')): ?>
                                <a href="?controller=Event&action=edit&id=<?php echo $event['id']; ?>" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</a>
                                <a href="?controller=Event&action=delete&id=<?php echo $event['id']; ?>" 
                                   class="text-red-600 hover:text-red-800 text-sm font-medium"
                                   onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                            <?php else: ?>
                                <span class="text-gray-400 text-sm">View Only</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
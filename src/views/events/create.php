<?php include 'includes/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="?controller=Event&action=index" class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create Event</h1>
        </div>
        <p class="text-gray-600">Schedule a new organizational event</p>
    </div>

    <!-- Messages -->
    <?php if (!empty($message)): ?>
        <div class="alert-<?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Event Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form method="POST" action="?controller=Event&action=create" class="space-y-6">
            <!-- Event Title -->
            <div class="form-group">
                <label for="title" class="form-label">Event Title *</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>"
                       required 
                       class="form-input"
                       placeholder="Enter event title">
            </div>

            <!-- Event Date & Time -->
            <div class="form-group">
                <label for="event_date" class="form-label">Event Date & Time *</label>
                <input type="datetime-local" 
                       id="event_date" 
                       name="event_date" 
                       value="<?php echo isset($_POST['event_date']) ? $_POST['event_date'] : ''; ?>"
                       min="<?php echo date('Y-m-d\TH:i'); ?>"
                       required 
                       class="form-input">
            </div>

            <!-- Event Description -->
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          class="form-input"
                          placeholder="Enter event description (optional)"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="?controller=Event&action=index" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Create Event
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
                <h3 class="text-sm font-medium text-blue-800 mb-1">Tips for Creating Events</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• Use descriptive titles that clearly indicate the event purpose</li>
                    <li>• Set the date and time in the future</li>
                    <li>• Include relevant details in the description</li>
                    <li>• All organization members will be able to see this event</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
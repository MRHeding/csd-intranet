// CSD Intranet JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-success, .alert-error, .alert-warning, .alert-info');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // Mobile menu toggle
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    field.classList.remove('border-gray-300');
                } else {
                    field.classList.remove('border-red-500');
                    field.classList.add('border-gray-300');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showMessage('Please fill in all required fields.', 'error');
            }
        });
    });

    // Confirmation dialogs
    const deleteLinks = document.querySelectorAll('a[href*="delete"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // Date input restrictions
    const dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(input => {
        // Set max date to today for attendance
        if (input.name === 'date' || input.id === 'date') {
            const today = new Date().toISOString().split('T')[0];
            input.max = today;
        }
    });

    // Search functionality
    const searchInputs = document.querySelectorAll('input[type="search"], .search-input');
    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // Status badge color updates
    updateStatusBadges();
    
    // Initialize AJAX form handlers
    initializeFormHandlers();
});

// Helper function to show messages
function showMessage(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert-${type}`;
    alertDiv.innerHTML = `
        <strong>${type === 'error' ? 'Error!' : type === 'success' ? 'Success!' : 'Info:'}</strong>
        ${message}
    `;
    
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            alertDiv.style.opacity = '0';
            setTimeout(() => {
                alertDiv.remove();
            }, 300);
        }, 5000);
    }
}

// Update status badge colors
function updateStatusBadges() {
    const statusBadges = document.querySelectorAll('.status-badge');
    statusBadges.forEach(badge => {
        const status = badge.textContent.toLowerCase().trim();
        badge.classList.remove('bg-green-100', 'text-green-800', 'bg-red-100', 'text-red-800', 'bg-yellow-100', 'text-yellow-800');
        
        switch(status) {
            case 'present':
                badge.classList.add('bg-green-100', 'text-green-800');
                break;
            case 'absent':
                badge.classList.add('bg-red-100', 'text-red-800');
                break;
            case 'leave':
                badge.classList.add('bg-yellow-100', 'text-yellow-800');
                break;
        }
    });
}

// Loading states for buttons
function setLoading(button, loading = true) {
    const originalText = button.getAttribute('data-original-text') || button.innerHTML;
    
    if (loading) {
        button.setAttribute('data-original-text', originalText);
        button.disabled = true;
        button.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        `;
    } else {
        button.disabled = false;
        button.innerHTML = originalText;
        button.removeAttribute('data-original-text');
    }
}

// AJAX form handlers
function initializeFormHandlers() {
    // Attendance form submission
    const attendanceForm = document.getElementById('attendance-form');
    if (attendanceForm) {
        attendanceForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const submitButton = this.querySelector('button[type="submit"]');
            
            setLoading(submitButton, true);
            
            // Add your AJAX call here to submit the attendance data
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                setLoading(submitButton, false);
                if (data.success) {
                    showMessage(data.message || 'Attendance submitted successfully!', 'success');
                    this.reset();
                } else {
                    showMessage(data.message || 'Error submitting attendance.', 'error');
                }
            })
            .catch(error => {
                setLoading(submitButton, false);
                showMessage('Error submitting attendance.', 'error');
                console.error('Error:', error);
            });
        });
    }

    // Event form submission
    const eventForm = document.getElementById('event-form');
    if (eventForm) {
        eventForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const submitButton = this.querySelector('button[type="submit"]');
            
            setLoading(submitButton, true);
            
            // Add your AJAX call here to submit the event data
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                setLoading(submitButton, false);
                if (data.success) {
                    showMessage(data.message || 'Event submitted successfully!', 'success');
                    this.reset();
                } else {
                    showMessage(data.message || 'Error submitting event.', 'error');
                }
            })
            .catch(error => {
                setLoading(submitButton, false);
                showMessage('Error submitting event.', 'error');
                console.error('Error:', error);
            });
        });
    }

    // Report generation
    const reportButton = document.getElementById('generate-report');
    if (reportButton) {
        reportButton.addEventListener('click', function() {
            setLoading(this, true);
            
            // Add your AJAX call here to generate the report
            fetch('/reports/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                setLoading(this, false);
                if (data.success) {
                    showMessage(data.message || 'Report generated successfully!', 'success');
                    if (data.download_url) {
                        window.open(data.download_url, '_blank');
                    }
                } else {
                    showMessage(data.message || 'Error generating report.', 'error');
                }
            })
            .catch(error => {
                setLoading(this, false);
                showMessage('Error generating report.', 'error');
                console.error('Error:', error);
            });
        });
    }
}
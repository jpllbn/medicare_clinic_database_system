/**
 * Medicare Clinic Database System - JavaScript Functions
 * Separation of Concerns - All JavaScript logic centralized here
 */

// ==================== MODAL FUNCTIONS ====================

/**
 * Open view modal for patient
 */
function openViewModal(patient) {
    const modal = document.getElementById('viewModal');
    const content = document.getElementById('viewModalContent');
    
    if (!modal || !content) return;
    
    // Escape HTML to prevent XSS
    const escapeHtml = (text) => {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    };
    
    content.innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 mb-1">Patient ID</p>
                <p class="font-medium text-gray-800">${escapeHtml(patient.patient_id || 'N/A')}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Full Name</p>
                <p class="font-medium text-gray-800">${escapeHtml((patient.first_name || '') + ' ' + (patient.last_name || ''))}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Email</p>
                <p class="font-medium text-gray-800">${escapeHtml(patient.email || 'N/A')}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Phone</p>
                <p class="font-medium text-gray-800">${escapeHtml(patient.phone || 'N/A')}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Date of Birth</p>
                <p class="font-medium text-gray-800">${patient.date_of_birth ? new Date(patient.date_of_birth).toLocaleDateString() : 'N/A'}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Gender</p>
                <p class="font-medium text-gray-800">${escapeHtml(patient.gender || 'N/A')}</p>
            </div>
            <div class="col-span-2">
                <p class="text-sm text-gray-500 mb-1">Address</p>
                <p class="font-medium text-gray-800">${escapeHtml(patient.address || 'N/A')}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Created At</p>
                <p class="font-medium text-gray-800">${patient.created_at ? new Date(patient.created_at).toLocaleString() : 'N/A'}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Last Updated</p>
                <p class="font-medium text-gray-800">${patient.updated_at ? new Date(patient.updated_at).toLocaleString() : 'N/A'}</p>
            </div>
        </div>
    `;
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

/**
 * Close view modal
 */
function closeViewModal() {
    const modal = document.getElementById('viewModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
    }
}

/**
 * Open edit modal for patient
 */
function openEditModal(patient) {
    if (!patient) return;
    
    const patientIdField = document.getElementById('edit_patient_id');
    const firstNameField = document.getElementById('edit_first_name');
    const lastNameField = document.getElementById('edit_last_name');
    const emailField = document.getElementById('edit_email');
    const phoneField = document.getElementById('edit_phone');
    const dobField = document.getElementById('edit_date_of_birth');
    const genderField = document.getElementById('edit_gender');
    const addressField = document.getElementById('edit_address');
    
    if (patientIdField) patientIdField.value = patient.patient_id || '';
    if (firstNameField) firstNameField.value = patient.first_name || '';
    if (lastNameField) lastNameField.value = patient.last_name || '';
    if (emailField) emailField.value = patient.email || '';
    if (phoneField) phoneField.value = patient.phone || '';
    if (dobField) dobField.value = patient.date_of_birth || '';
    if (genderField) genderField.value = patient.gender || '';
    if (addressField) addressField.value = patient.address || '';
    
    const modal = document.getElementById('editModal');
    if (modal) {
        modal.classList.add('active');
    }
}

/**
 * Close edit modal
 */
function closeEditModal() {
    const modal = document.getElementById('editModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
    }
}

// ==================== APPOINTMENT MODAL FUNCTIONS ====================

/**
 * Open view modal for appointment
 */
function openAppointmentViewModal(appointment) {
    const modal = document.getElementById('viewModal');
    const content = document.getElementById('viewModalContent');
    
    if (!modal || !content) return;
    
    // Escape HTML to prevent XSS
    const escapeHtml = (text) => {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    };
    
    const appointmentDate = appointment.appointment_date ? new Date(appointment.appointment_date) : null;
    const dateStr = appointmentDate ? appointmentDate.toLocaleDateString() : 'N/A';
    const timeStr = appointmentDate ? appointmentDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'N/A';
    
    content.innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500 mb-1">Appointment ID</p>
                <p class="font-medium text-gray-800">${escapeHtml(appointment.appointment_id || 'N/A')}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Status</p>
                <p class="font-medium text-gray-800">
                    <span class="px-2 py-1 rounded-full text-xs ${getStatusColorClass(appointment.status)}">
                        ${escapeHtml(appointment.status || 'N/A')}
                    </span>
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Patient Name</p>
                <p class="font-medium text-gray-800">${escapeHtml((appointment.first_name || '') + ' ' + (appointment.last_name || ''))}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Patient Email</p>
                <p class="font-medium text-gray-800">${escapeHtml(appointment.email || 'N/A')}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Patient Phone</p>
                <p class="font-medium text-gray-800">${escapeHtml(appointment.phone || 'N/A')}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Appointment Date</p>
                <p class="font-medium text-gray-800">${dateStr}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Appointment Time</p>
                <p class="font-medium text-gray-800">${timeStr}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Appointment Type</p>
                <p class="font-medium text-gray-800">${escapeHtml(appointment.appointment_type || 'N/A')}</p>
            </div>
            <div class="col-span-2">
                <p class="text-sm text-gray-500 mb-1">Notes</p>
                <p class="font-medium text-gray-800">${escapeHtml(appointment.notes || 'N/A')}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Created At</p>
                <p class="font-medium text-gray-800">${appointment.created_at ? new Date(appointment.created_at).toLocaleString() : 'N/A'}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Last Updated</p>
                <p class="font-medium text-gray-800">${appointment.updated_at ? new Date(appointment.updated_at).toLocaleString() : 'N/A'}</p>
            </div>
        </div>
    `;
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

/**
 * Open edit modal for appointment
 */
function openAppointmentEditModal(appointment) {
    if (!appointment) return;
    
    const appointmentIdField = document.getElementById('edit_appointment_id');
    const patientIdField = document.getElementById('edit_patient_id');
    const dateField = document.getElementById('edit_appointment_date');
    const timeField = document.getElementById('edit_appointment_time');
    const typeField = document.getElementById('edit_appointment_type');
    const statusField = document.getElementById('edit_status');
    const notesField = document.getElementById('edit_notes');
    
    if (appointmentIdField) appointmentIdField.value = appointment.appointment_id || '';
    if (patientIdField) patientIdField.value = appointment.patient_id || '';
    
    if (appointment.appointment_date && dateField && timeField) {
        const appointmentDate = new Date(appointment.appointment_date);
        dateField.value = appointmentDate.toISOString().split('T')[0];
        const hours = String(appointmentDate.getHours()).padStart(2, '0');
        const minutes = String(appointmentDate.getMinutes()).padStart(2, '0');
        timeField.value = `${hours}:${minutes}`;
    }
    
    if (typeField) typeField.value = appointment.appointment_type || '';
    if (statusField) statusField.value = appointment.status || 'Scheduled';
    if (notesField) notesField.value = appointment.notes || '';
    
    const modal = document.getElementById('editModal');
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }
}

/**
 * Get status color class
 */
function getStatusColorClass(status) {
    const colors = {
        'Scheduled': 'status-scheduled',
        'Confirmed': 'status-confirmed',
        'Cancelled': 'status-cancelled',
        'Completed': 'status-completed'
    };
    return colors[status] || 'status-completed';
}

// ==================== UTILITY FUNCTIONS ====================

/**
 * Initialize modal event listeners
 */
function initModals() {
    // Close modals when clicking outside
    const viewModal = document.getElementById('viewModal');
    const editModal = document.getElementById('editModal');
    
    if (viewModal) {
        viewModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeViewModal();
            }
        });
    }
    
    if (editModal) {
        editModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    }
    
    // Close modals with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (viewModal && viewModal.classList.contains('active')) {
                closeViewModal();
            }
            if (editModal && editModal.classList.contains('active')) {
                closeEditModal();
            }
        }
    });
}

/**
 * Format date for display
 */
function formatDate(dateString) {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleDateString();
}

/**
 * Format datetime for display
 */
function formatDateTime(dateString) {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleString();
}

// ==================== MOBILE MENU FUNCTIONS ====================

/**
 * Initialize mobile sidebar menu
 */
function initMobileSidebar() {
    const openBtn = document.getElementById('openSidebar');
    const closeBtn = document.getElementById('closeSidebar');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (openBtn && sidebar) {
        openBtn.addEventListener('click', function() {
            sidebar.classList.add('mobile-open');
            if (overlay) {
                overlay.classList.add('active');
            }
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });
    }
    
    function closeSidebar() {
        if (sidebar) {
            sidebar.classList.remove('mobile-open');
        }
        if (overlay) {
            overlay.classList.remove('active');
        }
        document.body.style.overflow = ''; // Restore scrolling
    }
    
    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
    }
    
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }
    
    // Close sidebar when clicking on a link (mobile)
    if (sidebar) {
        const links = sidebar.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
    }
}

/**
 * Initialize mobile navigation menu
 */
function initMobileNav() {
    const toggleBtn = document.getElementById('mobileNavToggle');
    const mobileNav = document.getElementById('mobileNav');
    
    if (toggleBtn && mobileNav) {
        toggleBtn.addEventListener('click', function() {
            mobileNav.classList.toggle('active');
            
            // Toggle icon
            const icon = toggleBtn.querySelector('i');
            if (icon) {
                if (mobileNav.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
        
        // Close mobile nav when clicking outside
        document.addEventListener('click', function(event) {
            if (!toggleBtn.contains(event.target) && !mobileNav.contains(event.target)) {
                mobileNav.classList.remove('active');
                const icon = toggleBtn.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
        
        // Close mobile nav when clicking on a link
        const links = mobileNav.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function() {
                mobileNav.classList.remove('active');
                const icon = toggleBtn.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        });
    }
}

/**
 * Handle window resize for responsive behavior
 */
function handleResize() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    // Close mobile sidebar on resize to desktop
    if (window.innerWidth > 768) {
        if (sidebar) {
            sidebar.classList.remove('mobile-open');
        }
        if (overlay) {
            overlay.classList.remove('active');
        }
        document.body.style.overflow = '';
    }
}

// ==================== SEARCH FUNCTIONALITY ====================

/**
 * Initialize patient search functionality
 */
function initPatientSearch() {
    const searchInput = document.getElementById('searchPatients');
    const tableBody = document.getElementById('patientsTableBody');
    const patientCount = document.getElementById('patientCount');
    
    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const rows = tableBody.querySelectorAll('.patient-row');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name') || '';
                const email = row.getAttribute('data-email') || '';
                const phone = row.getAttribute('data-phone') || '';
                
                if (name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update count
            if (patientCount) {
                patientCount.textContent = visibleCount;
            }
        });
    }
}

/**
 * Initialize appointment search functionality
 */
function initAppointmentSearch() {
    const searchInput = document.getElementById('searchAppointments');
    const tableBody = document.getElementById('appointmentsTableBody');
    const appointmentCount = document.getElementById('appointmentCount');
    
    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const rows = tableBody.querySelectorAll('.appointment-row');
            let visibleCount = 0;
            
            rows.forEach(row => {
                const patient = row.getAttribute('data-patient') || '';
                const phone = row.getAttribute('data-phone') || '';
                const type = row.getAttribute('data-type') || '';
                const status = row.getAttribute('data-status') || '';
                
                if (patient.includes(searchTerm) || phone.includes(searchTerm) || 
                    type.includes(searchTerm) || status.includes(searchTerm)) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update count
            if (appointmentCount) {
                appointmentCount.textContent = visibleCount;
            }
        });
    }
}

// ==================== INITIALIZATION ====================

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initModals();
    initMobileSidebar();
    initMobileNav();
    initPatientSearch();
    initAppointmentSearch();
    
    // Handle window resize
    window.addEventListener('resize', handleResize);
});


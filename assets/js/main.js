// Add to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Active link handling
    const navLinks = document.querySelectorAll('.nav-link:not(.btn)');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});



// Counter JS
// Counter Animation
document.addEventListener('DOMContentLoaded', function() {
    // Function to animate counter
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16); // 60 FPS
        const counter = setInterval(() => {
            start += increment;
            element.textContent = Math.floor(start) + (element.getAttribute('data-suffix') || '+');
            if (start >= target) {
                element.textContent = target + (element.getAttribute('data-suffix') || '+');
                clearInterval(counter);
            }
        }, 16);
    }

    // Intersection Observer for counter animation
    const observerOptions = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = entry.target.querySelectorAll('.counter-number');
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    animateCounter(counter, target);
                });
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe stats section
    const statsSection = document.querySelector('.stats-row');
    if (statsSection) {
        observer.observe(statsSection);
    }
});


// Language Switcher JS
// Add this JavaScript
function googleTranslateElementInit() {
    new google.translate.TranslateElement(
        {
            pageLanguage: 'en',
            includedLanguages: 'en,bn', // Only English and Bengali
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false,
        },
        'google_translate_element'
    );
}

// Clean up Google Translate's automatic styling
document.addEventListener('DOMContentLoaded', function() {
    // Remove the top margin that Google Translate adds
    setTimeout(function() {
        if (document.body.style.top) {
            document.body.style.top = '';
        }
    }, 1000);
});






// JS Codes for Admin Dashboard
// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    // Investment Chart
    const investmentCtx = document.getElementById('investmentChart').getContext('2d');
    new Chart(investmentCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Investment Amount (৳)',
                data: [150000, 300000, 450000, 600000, 750000, 900000],
                borderColor: '#28a745',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '৳' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Project Status Chart
    const statusCtx = document.getElementById('projectStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Pending', 'Completed'],
            datasets: [{
                data: [12, 8, 5],
                backgroundColor: ['#28a745', '#ffc107', '#17a2b8']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Mobile Sidebar Toggle
    const toggleBtn = document.querySelector('.navbar-toggler');
    const sidebar = document.querySelector('.sidebar');
    
    if(toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Active Link Handling
    const currentLocation = window.location.href;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        if(link.href === currentLocation) {
            link.classList.add('active');
        }
    });
});


// JS for Projects Page (Admin)

// Projects Page Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('input[placeholder="Search projects..."]');
    if(searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            // Add your search logic here
            console.log('Searching for:', e.target.value);
        });
    }

    // Filter functionality
    const filterSelects = document.querySelectorAll('.form-select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Add your filter logic here
            console.log('Filter changed:', this.value);
        });
    });

    // Delete confirmation
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if(!confirm('Are you sure you want to delete this project?')) {
                e.preventDefault();
            }
        });
    });

    // Modal form validation
    const editForm = document.querySelector('#editProjectModal form');
    if(editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form validation and submission logic here
            console.log('Form submitted');
        });
    }

    // Status badge color update
    const updateStatusBadgeColor = (select) => {
        const statusBadge = document.querySelector('.badge');
        statusBadge.className = 'badge';
        switch(select.value) {
            case 'active':
                statusBadge.classList.add('bg-success');
                break;
            case 'pending':
                statusBadge.classList.add('bg-warning');
                break;
            case 'completed':
                statusBadge.classList.add('bg-info');
                break;
        }
    };

    // Status select change handler
    const statusSelect = document.querySelector('select[name="status"]');
    if(statusSelect) {
        statusSelect.addEventListener('change', function() {
            updateStatusBadgeColor(this);
        });
    }

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Project data handling functions
const projectHandlers = {
    view: function(projectId) {
        // Add logic to view project
        console.log('Viewing project:', projectId);
    },
    
    edit: function(projectId) {
        // Add logic to edit project
        console.log('Editing project:', projectId);
    },
    
    delete: function(projectId) {
        // Add logic to delete project
        console.log('Deleting project:', projectId);
    }
};

// Form handling functions
const formHandlers = {
    validateProjectForm: function(formData) {
        let isValid = true;
        const required = ['projectName', 'amount', 'duration'];
        
        required.forEach(field => {
            if(!formData.get(field)) {
                isValid = false;
                // Add your error handling here
            }
        });
        
        return isValid;
    },
    
    submitProjectForm: function(formElement) {
        const formData = new FormData(formElement);
        if(this.validateProjectForm(formData)) {
            // Add your form submission logic here
            console.log('Form is valid, submitting...');
            return true;
        }
        return false;
    }
};
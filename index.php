<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AgriFinConnect - Connecting Farmers with Investors</title>

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css" />
    
    <!-- Language Switcher -->
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement(
                {
                    pageLanguage: 'en',
                    includedLanguages: 'en,bn',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                },
                'google_translate_element'
            );
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
  </head>
  <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <span class="notranslate brand-text">AgriFinConnect</span>
                </a>

                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation Items -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#how-it-works">How It Works</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-outline-success rounded-pill px-4" href="auth/login.php">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-success rounded-pill px-4" href="auth/registration.php">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </a>
                        </li>
                        <!-- Language Switcher -->
                        <li class="nav-item ms-lg-2">
                            <div id="google_translate_element"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center pt-100 pb-100">
            <div class="col-lg-5">
                <h1 class="display-4 fw-bold">Connect Farmers with Investors</h1>
                <p class="lead">
                A platform that brings agricultural investment opportunities to
                your fingertips
                </p>
                <div class="d-flex gap-3 mt-4">
                <a href="auth/registration.php?role=farmer" class="btn btn-primary btn-lg"
                    >I'm a Farmer</a>
                <a
                    href="auth/registration.php?role=investor"
                    class="btn btn-success btn-lg"
                    >I'm an Investor</a
                >
                </div>
            </div>
            <div class="col-lg-7">
                <img
                src="assets/images/banner_img.png"
                alt="Farming"
                class="img-fluid mt-20"
                />
            </div>
            </div>
        </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="mt-100 mb-100">
        <div class="container">
            <h2 class="text-center mb-5 display-5 fw-bold">How It Works</h2>
            <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-user-plus fa-3x mb-3 text-primary"></i>
                    <h3 class="card-title">Register</h3>
                    <p class="card-text">
                    Sign up as a farmer or investor to get started
                    </p>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-handshake fa-3x mb-3 text-success"></i>
                    <h3 class="card-title">Connect</h3>
                    <p class="card-text">
                    Create or invest in agricultural projects
                    </p>
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-3x mb-3 text-warning"></i>
                    <h3 class="card-title">Grow</h3>
                    <p class="card-text">Track progress and grow together</p>
                </div>
                </div>
            </div>
            </div>
        </div>
        </section>


        <!-- Features Section with Modals -->
        <section id="features" class="bg-light pt-100 pb-100">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="display-5 fw-bold">Our Features</h2>
                    <p class="text-muted">Connecting farmers and investors with secure and easy-to-use tools</p>
                </div>

                <div class="row g-4">
                    <!-- Feature 1: Easy Investment Process -->
                    <div class="col-md-4">
                        <div class="feature-card text-center p-4">
                            <div class="feature-icon-wrapper mb-4">
                                <div class="feature-icon">
                                    <i class="fas fa-hand-holding-usd fa-3x text-success"></i>
                                </div>
                            </div>
                            <h4 class="feature-title">Easy Investment Process</h4>
                            <div class="feature-details mt-3">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success me-2"></i>Simple project creation</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Flexible payment options</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Low interest rates</li>
                                </ul>
                                <button class="btn btn-outline-success mt-3" data-bs-toggle="modal" data-bs-target="#investmentModal">
                                    Learn More <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2: Secure Transactions -->
                    <div class="col-md-4">
                        <div class="feature-card text-center p-4">
                            <div class="feature-icon-wrapper mb-4">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt fa-3x text-primary"></i>
                                </div>
                            </div>
                            <h4 class="feature-title">Secure Transactions</h4>
                            <div class="feature-details mt-3">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-primary me-2"></i>Verified users only</li>
                                    <li><i class="fas fa-check text-primary me-2"></i>Safe payment system</li>
                                    <li><i class="fas fa-check text-primary me-2"></i>Transaction tracking</li>
                                </ul>
                                <button class="btn btn-outline-primary mt-3" data-bs-toggle="modal" data-bs-target="#securityModal">
                                    Learn More <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3: Project Management -->
                    <div class="col-md-4">
                        <div class="feature-card text-center p-4">
                            <div class="feature-icon-wrapper mb-4">
                                <div class="feature-icon">
                                    <i class="fas fa-tasks fa-3x text-warning"></i>
                                </div>
                            </div>
                            <h4 class="feature-title">Project Management</h4>
                            <div class="feature-details mt-3">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-warning me-2"></i>Progress tracking</li>
                                    <li><i class="fas fa-check text-warning me-2"></i>Regular updates</li>
                                    <li><i class="fas fa-check text-warning me-2"></i>Status reporting</li>
                                </ul>
                                <button class="btn btn-outline-warning mt-3" data-bs-toggle="modal" data-bs-target="#projectModal">
                                    Learn More <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Investment Process Modal -->
        <div class="modal fade" id="investmentModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-hand-holding-usd me-2"></i>
                            Investment Process
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="process-steps">
                            <div class="step-item mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="step-number">1</div>
                                    <h5 class="mb-0 ms-3">Create Account</h5>
                                </div>
                                <p class="text-muted ms-5">Register as a farmer or investor with basic information and verify your identity.</p>
                            </div>

                            <div class="step-item mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="step-number">2</div>
                                    <h5 class="mb-0 ms-3">Project Creation/Selection</h5>
                                </div>
                                <p class="text-muted ms-5">Farmers can create projects, while investors can browse and select projects to invest in.</p>
                            </div>

                            <div class="step-item mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="step-number">3</div>
                                    <h5 class="mb-0 ms-3">Investment Process</h5>
                                </div>
                                <p class="text-muted ms-5">Choose investment amount and duration, review terms, and confirm investment.</p>
                            </div>

                            <div class="step-item">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="step-number">4</div>
                                    <h5 class="mb-0 ms-3">Track & Manage</h5>
                                </div>
                                <p class="text-muted ms-5">Monitor investment progress, receive updates, and track returns.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Modal -->
        <div class="modal fade" id="securityModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-shield-alt me-2"></i>
                            Security Features
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="security-feature p-3 border rounded">
                                    <h6><i class="fas fa-user-check text-primary me-2"></i>User Verification</h6>
                                    <p class="small text-muted mb-0">All users must verify their identity before accessing the platform.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="security-feature p-3 border rounded">
                                    <h6><i class="fas fa-lock text-primary me-2"></i>Secure Transactions</h6>
                                    <p class="small text-muted mb-0">All financial transactions are encrypted and secured.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="security-feature p-3 border rounded">
                                    <h6><i class="fas fa-history text-primary me-2"></i>Transaction History</h6>
                                    <p class="small text-muted mb-0">Complete transaction history and documentation available.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="security-feature p-3 border rounded">
                                    <h6><i class="fas fa-file-contract text-primary me-2"></i>Legal Compliance</h6>
                                    <p class="small text-muted mb-0">All processes comply with local financial regulations.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Management Modal -->
        <div class="modal fade" id="projectModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <i class="fas fa-tasks me-2"></i>
                            Project Management
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="project-feature">
                                    <h5 class="mb-3">For Farmers</h5>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Create detailed project proposals
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Upload progress updates
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Manage repayment schedule
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Track investment usage
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="project-feature">
                                    <h5 class="mb-3">For Investors</h5>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            View detailed project information
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Track investment performance
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Receive progress updates
                                        </li>
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            Monitor return on investment
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Us Section -->
        <section id="about" class="about-section py-5">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Column: Image -->
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="about-image position-relative">
                            <img src="assets/images/about.png" alt="Farming Community" class="img-fluid rounded-3 shadow">
                        </div>
                    </div>
                    
                    <!-- Right Column: Content -->
                    <div class="col-lg-6">
                        <div class="about-content">
                            <h6 class="text-success text-uppercase fw-bold mb-2">About Us</h6>
                            <h2 class="display-6 mb-4">Bridging the Gap Between Farmers and Investors</h2>
                            
                            <p class="lead text-muted mb-4">
                                AgriFinConnect is dedicated to revolutionizing agricultural financing in Bangladesh by connecting farmers with potential investors through a secure and transparent platform.
                            </p>

                            <div class="row g-4 mb-4">
                                <!-- Key Point 1 -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="icon-box bg-success-light rounded-circle p-3 me-3">
                                            <i class="fas fa-handshake text-success"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-2">Our Mission</h5>
                                            <p class="text-muted mb-0">To empower farmers with accessible financing options</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Key Point 2 -->
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="icon-box bg-success-light rounded-circle p-3 me-3">
                                            <i class="fas fa-eye text-success"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-2">Our Vision</h5>
                                            <p class="text-muted mb-0">To create a sustainable agricultural financing ecosystem</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Statistics Row -->
                            <div class="row g-4 stats-row">
                                <div class="col-4">
                                    <div class="stat-item text-center">
                                        <h3 class="text-success mb-2">
                                            <span class="counter-number" data-target="500">0</span>
                                        </h3>
                                        <p class="text-muted mb-0">Farmers</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item text-center">
                                        <h3 class="text-success mb-2">
                                            <span class="counter-number" data-target="200">0</span>
                                        </h3>
                                        <p class="text-muted mb-0">Investors</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item text-center">
                                        <h3 class="text-success mb-2">
                                            <span class="counter-number" data-target="50" data-suffix="M+">0</span>
                                        </h3>
                                        <p class="text-muted mb-0">Invested</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-light pt-100 pb-100">
        <div class="container">
            <div class="row">
            <div class="col-md-4">
                <h5>AgriFinConnect</h5>
                <p>Connecting farmers with investors for a better future.</p>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                <li><a href="#" class="text-light">About Us</a></li>
                <li><a href="#" class="text-light">Contact</a></li>
                <li><a href="#" class="text-light">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact Us</h5>
                <p>Email: info@agrifinconnect.com</p>
                <p>Phone: +880 1234567890</p>
            </div>
            </div>
        </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom JS -->
        <script src="assets/js/main.js"></script>




        
  </body>
</html>

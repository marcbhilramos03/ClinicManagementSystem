<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Clinic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary-color: #0d6efd;
      --secondary-color: #20c997;
      --dark-color: #212529;
      --light-color: #f8f9fa;
      --text-color: #495057;
      --heading-color: #343a40;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      line-height: 1.6;
      color: var(--text-color);
      background-color: var(--light-color);
    }

    h1, h2, h3, h4, h5, h6 {
      color: var(--heading-color);
      font-weight: 600;
    }

    .navbar {
      transition: all 0.3s ease-in-out;
    }

    .navbar.scrolled {
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .navbar-brand img {
      height: 40px; /* Adjust logo size */
    }

    .nav-link {
      color: var(--heading-color) !important;
      font-weight: 500;
      margin: 0 10px;
      transition: color 0.3s ease;
    }
    .nav-link:hover {
      color: var(--primary-color) !important;
    }
    .nav-link.active {
        color: var(--primary-color) !important;
        border-bottom: 2px solid var(--primary-color);
    }

    .hero {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      padding: 120px 20px; /* Increased padding */
      border-bottom-left-radius: 70px; /* Larger radius */
      border-bottom-right-radius: 70px; /* Larger radius */
      position: relative;
      overflow: hidden; /* For potential background effects */
    }
    .hero h1 {
      font-size: 3.2rem; /* Larger font size */
      font-weight: bold;
      line-height: 1.2;
    }
    .hero p.lead {
      font-size: 1.15rem;
      max-width: 600px; /* Constrain width for readability */
      margin-top: 20px;
      opacity: 0.9;
    }
    .hero .btn-outline-light {
      border-width: 2px;
      padding: 10px 30px;
      font-weight: 500;
      transition: background-color 0.3s, color 0.3s;
    }
    .hero .btn-outline-light:hover {
      background-color: white;
      color: var(--primary-color) !important;
    }

    .auth-card {
      background: #fff;
      border-radius: 16px; /* Slightly larger radius */
      padding: 40px; /* Increased padding */
      box-shadow: 0 8px 25px rgba(0,0,0,0.1); /* Stronger, softer shadow */
      animation: fadeIn 0.5s ease-out; /* Fade-in animation */
    }
    .auth-card h4 {
      color: var(--primary-color);
      font-weight: bold;
      margin-bottom: 30px; /* Increased margin */
      text-align: center;
      font-size: 1.8rem;
    }
    .auth-card .form-control, .auth-card .form-select {
      margin-bottom: 20px; /* Increased margin */
      border-radius: 8px; /* Rounded inputs */
      padding: 12px 15px; /* Better padding */
      border: 1px solid #ced4da;
      transition: border-color 0.3s, box-shadow 0.3s;
    }
    .auth-card .form-control:focus, .auth-card .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .auth-card .btn-primary {
      width: 100%;
      padding: 12px;
      font-size: 1.1rem;
      border-radius: 8px;
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      transition: background-color 0.3s ease;
    }
    .auth-card .btn-primary:hover {
        background-color: #0a58ca;
        border-color: #0a58ca;
    }
    .auth-card .toggle-link {
      text-align: center;
      margin-top: 20px;
      font-size: 0.95rem;
      color: var(--text-color);
    }
    .auth-card .toggle-link a {
      color: var(--primary-color);
      cursor: pointer;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    .auth-card .toggle-link a:hover {
      text-decoration: underline;
      color: #0a58ca; /* Slightly darker primary on hover */
    }
    .hidden {
      display: none;
    }

    .features-section {
        padding: 80px 0;
        background-color: #ffffff;
    }
    .features-section h2 {
        font-size: 2.5rem;
        margin-bottom: 60px;
        color: var(--heading-color);
    }

    .feature-card {
      background: #ffffff;
      border-radius: 16px; /* Match auth card radius */
      padding: 30px; /* Increased padding */
      text-align: center;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08); /* Softer shadow */
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%; /* Ensure cards are same height */
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .feature-card:hover {
      transform: translateY(-8px); /* More pronounced lift */
      box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }
    .feature-card i { /* Font Awesome icon styling */
        font-size: 3rem;
        color: var(--secondary-color);
        margin-bottom: 20px;
    }
    .feature-card h5 {
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 10px;
        color: var(--heading-color);
    }
    .feature-card p {
        font-size: 0.95rem;
        color: var(--text-color);
    }

    .about-header {
      background-color: var(--light-color); /* Lighter background for distinction */
      color: var(--heading-color);
      padding: 80px 20px;
      text-align: center;
    }
    .about-header h1 {
      font-weight: bold;
      font-size: 3rem; /* Larger for impact */
      margin-bottom: 15px;
    }
    .about-header p {
        font-size: 1.1rem;
        max-width: 800px;
        margin: 0 auto;
        color: var(--text-color);
    }

    .about-section {
      padding: 60px 20px;
      background-color: #ffffff; /* White background for content */
    }
    .about-section h2 {
      font-weight: bold;
      margin-bottom: 25px;
      color: var(--primary-color); /* Use primary color for section headings */
      font-size: 2rem;
    }
    .about-section p {
        margin-bottom: 20px;
        font-size: 1rem;
        line-height: 1.7;
    }

    .footer {
      background: var(--dark-color);
      color: #dee2e6;
      padding: 60px 20px; /* Increased padding */
      margin-top: 50px;
    }
    .footer h5, .footer h6 {
      color: #fff;
      margin-bottom: 20px; /* Increased margin */
      font-weight: 600;
    }
    .footer a {
      color: #adb5bd;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    .footer a:hover {
      color: #fff;
      text-decoration: underline;
    }
    .footer .list-unstyled li {
        margin-bottom: 8px;
    }
    .footer p {
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
      .hero {
        padding: 80px 20px;
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
      }
      .hero h1 {
        font-size: 2.8rem;
      }
      .hero p.lead {
        font-size: 1rem;
      }
      .auth-card {
        margin-top: 40px;
        padding: 30px;
      }
      .about-header h1 {
        font-size: 2.5rem;
      }
      .features-section h2, .about-section h2 {
        font-size: 2rem;
        margin-bottom: 40px;
      }
    }

    @media (max-width: 767px) {
      .hero h1 {
        font-size: 2.2rem;
      }
      .hero p.lead {
        font-size: 0.95rem;
      }
      .auth-card {
        padding: 25px;
      }
      .feature-card {
        margin-bottom: 20px;
      }
      .footer {
        padding: 40px 20px;
      }
      .footer h5, .footer h6 {
        margin-bottom: 15px;
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#hero">
        <!-- Assuming logo.png is in public/images/ -->
        <img src="{{ asset('images/logo.png') }}" alt="Smart Clinic Logo" class="me-2">
        <span class="fw-bold fs-5 text-dark">SmartClinic</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link active" href="#hero">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section with Forms -->
  <section class="hero" id="hero">
    <div class="container">
      <div class="row align-items-center justify-content-between">
        <!-- Hero Text -->
        <div class="col-lg-6 mb-4 mb-lg-0 text-center text-lg-start">
          <h1>Effortless School Healthcare Management</h1>
          <p class="lead mt-3">
            SmartClinic is here to make your school healthcare experience simple and stress-free. Whether you need to check your medical records, schedule a checkup, or follow up on a treatment, everything you need is just a few clicks away.
            Our goal is to help students and staff stay healthy and informed, with fast access to care and real-time updates. By bringing technology and care together, SmartClinic ensures you get the attention you need, when you need it. Take control of your health and enjoy a safer, healthier school life with SmartClinic.
          </p>
          <div class="mt-5">
            <a href="#about" class="btn btn-outline-light btn-lg">Discover More</a>
          </div>
        </div>

        <!-- Auth Forms -->
        <div class="col-lg-5">
          <!-- Login Card -->
          <div class="auth-card" id="login-card">
            <h4>Login to Your Account</h4>
            <form action="{{ route('login') }}" method="POST">
              @csrf
              <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required>
              <input type="password" class="form-control" name="password" placeholder="Password" required>
              <button type="submit" class="btn btn-primary">Login</button>
              <div class="toggle-link">
                Don't have an account? <a onclick="toggleForm('register')">Register Now</a>
              </div>
            </form>
          </div>

          <!-- Register Card (hidden initially) -->
          <div class="auth-card hidden" id="register-card">
            <h4>Create an Account</h4>
            <form action="{{ route('register') }}" method="POST">
              @csrf
              <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required>
              <input type="password" class="form-control" name="password" placeholder="Password" required>
              <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
              <button type="submit" class="btn btn-primary">Register</button>
              <div class="toggle-link">
                Already have an account? <a onclick="toggleForm('login')">Login Here</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
{{-- 
  <!-- Features Section -->
  <section class="features-section" id="features">
    <div class="container text-center">
      <h2 class="fw-bold mb-5">Powerful Features for Seamless Management</h2>
      <div class="row g-4 justify-content-center">
        <div class="col-lg-3 col-md-6">
          <div class="feature-card">
            <i class="fas fa-file-medical"></i>
            <h5>Electronic Health Records</h5>
            <p>Securely store and access student health information with ease.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="feature-card">
            <i class="fas fa-calendar-check"></i>
            <h5>Appointment Scheduling</h5>
            <p>Efficiently book, manage, and track all clinic appointments.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="feature-card">
            <i class="fas fa-pills"></i>
            <h5>Medication Management</h5>
            <p>Monitor medications, set reminders, and manage dosages.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="feature-card">
            <i class="fas fa-bell"></i>
            <h5>Smart Alert System</h5>
            <p>Receive instant notifications for emergencies and critical updates.</p>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!-- Footer -->
  <footer class="footer" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
          <h5>SmartClinic</h5>
          <p>Innovating school healthcare management for a healthier tomorrow. Dedicated to student and staff well-being.</p>
          <div class="social-icons mt-4">
              <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
              <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
              <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
              <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <h6>Quick Links</h6>
          <ul class="list-unstyled">
            <li><a href="#hero">Home</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#">Team</a></li>
          </ul>
        </div>
        <div class="col-md-2 col-6">
          <h6>Support</h6>
          <ul class="list-unstyled">
            <li><a href="#">Help Center</a></li>
            <li><a href="#">User Guide</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h6>Contact Us</h6>
          <p><i class="fas fa-map-marker-alt me-2"></i>123 Education Ave, Boston, MA 02108</p>
          <p><i class="fas fa-phone me-2"></i>(555) 123-4567</p>
          <p><i class="fas fa-envelope me-2"></i>info@smartclinic.com</p>
        </div>
      </div>
      <hr class="my-4 border-secondary">
      <div class="text-center">
          <p class="mb-0 text-muted">&copy; 2023 SmartClinic. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    function toggleForm(form) {
      const loginCard = document.getElementById('login-card');
      const registerCard = document.getElementById('register-card');
      if (form === 'register') {
        loginCard.classList.add('hidden');
        registerCard.classList.remove('hidden');
      } else {
        registerCard.classList.add('hidden');
        loginCard.classList.remove('hidden');
      }
    }

    // Navbar active state and scroll effect
    document.addEventListener("DOMContentLoaded", function() {
      const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
      const sections = document.querySelectorAll('section');
      const navbar = document.querySelector('.navbar');

      function activateNavLink() {
        let currentActive = '';
        sections.forEach(section => {
          const sectionTop = section.offsetTop - navbar.offsetHeight - 50; // Offset for sticky nav
          const sectionHeight = section.clientHeight;
          if (pageYOffset >= sectionTop && pageYOffset < sectionTop + sectionHeight) {
            currentActive = section.getAttribute('id');
          }
        });

        navLinks.forEach(link => {
          link.classList.remove('active');
          if (link.getAttribute('href').includes(currentActive)) {
            link.classList.add('active');
          }
        });
      }

      function handleScroll() {
        if (window.scrollY > 50) { // Add shadow after scrolling 50px
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
        activateNavLink();
      }

      window.addEventListener('scroll', handleScroll);
      handleScroll(); // Call on load to set initial state

      // Smooth scroll for nav links
      navLinks.forEach(link => {
          link.addEventListener('click', function (e) {
              e.preventDefault();
              document.querySelector(this.getAttribute('href')).scrollIntoView({
                  behavior: 'smooth'
              });
          });
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
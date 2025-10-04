<!-- resources/views/homepage.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Clinic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .hero {
      background: linear-gradient(135deg, #0d6efd, #20c997);
      color: white;
      padding: 100px 20px;
      border-bottom-left-radius: 50px;
      border-bottom-right-radius: 50px;
    }
    .hero h1 {
      font-size: 2.5rem;
      font-weight: bold;
    }
    .auth-card {
      background: #fff;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    .auth-card h4 {
      color: #0d6efd;
      font-weight: bold;
      margin-bottom: 20px;
      text-align: center;
    }
    .auth-card .form-control, .auth-card .form-select {
      margin-bottom: 15px;
    }
    .auth-card button {
      width: 100%;
    }
    .auth-card .toggle-link {
      text-align: center;
      margin-top: 10px;
      font-size: 14px;
    }
    .auth-card .toggle-link a {
      color: #0d6efd;
      cursor: pointer;
      text-decoration: none;
    }
    .auth-card .toggle-link a:hover {
      text-decoration: underline;
      color: #0d6efd;
    }
    .feature-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 25px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      transition: transform 0.3s;
    }
    .feature-card:hover {
      transform: translateY(-5px);
    }
    .footer {
      background: #212529;
      color: #dee2e6;
      padding: 50px 20px;
      margin-top: 50px;
    }
    .footer h5, .footer h6 {
      color: #fff;
      margin-bottom: 15px;
    }
    .footer a {
      color: #adb5bd;
      text-decoration: none;
    }
    .footer a:hover {
      color: #fff;
      text-decoration: underline;
    }
    .hidden {
      display: none;
    }
    h6{
      color: black; 
    } 
      .about-header {
      color:black;
      padding: 80px 20px;
      text-align: center;
    }
    .about-header h1 {
      font-weight: bold;
      font-size: 2.5rem;
    }
    .about-section {
      padding: 60px 20px;
    }
    .about-section h2 {
      font-weight: bold;
      margin-bottom: 20px;
    }
    .footer {
      background: #212529;
      color: #dee2e6;
      padding: 40px 20px;
      margin-top: 40px;
    }
    .footer a {
      color: #adb5bd;
      text-decoration: none;
    }
    .footer a:hover {
      color: #fff;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
    <img src="{{ asset('images/logo.png') }}" alt="Smart Clinic Logo" width="50">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav" >
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section with Forms -->
  <section class="hero" id="hero">
    <div class="container">
      <div class="row align-items-center">
        <!-- Hero Text -->
        <div class="col-lg-6 mb-4">
          <h1>Smart Clinic</h1>
          <p class="lead mt-3">"Smart Clinic is here to make your school healthcare experience simple and stress-free. Whether you need to check your medical records, schedule a checkup, or follow up on a treatment, everything you need is just a few clicks away. 
            <br>
            Our goal is to help students and staff stay healthy and informed, with fast access to care and real-time updates. By bringing technology and care together, Smart Clinic ensures you get the attention you need, when you need it. Take control of your health and enjoy a safer, healthier school life with Smart Clinic."
          </p>
          <div class="mt-4">
            <a href="#about" class="btn btn-outline-light">Learn More</a>
          </div>
        </div>

        <!-- Auth Forms -->
        <div class="col-lg-5 offset-lg-1">
          <!-- Login Card -->
          <div class="auth-card" id="login-card">
            <h4>Login</h4>
            <form action="{{ route('login') }}" method="POST">
              @csrf
              <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required>
              <input type="password" class="form-control" name="password" placeholder="Password" required>
              <button type="submit" class="btn btn-primary">Login</button>
              <div class="toggle-link">
                <h6>Don't have an account? <a onclick="toggleForm('register')">Register</a></h6>
              </div>
            </form>
          </div>

          <!-- Register Card (hidden initially) -->
          <div class="auth-card hidden" id="register-card">
            <h4>Register</h4>
            <form action="{{ route('register') }}" method="POST">
              @csrf
              <input type="text" class="form-control" name="username" placeholder="Username" value="{{ old('username') }}" required>
              <input type="password" class="form-control" name="password" placeholder="Password" required>
              <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
              <button type="submit" class="btn btn-primary">Register</button>
              <div class="toggle-link" >
                <h6>Already have an account? <a onclick="toggleForm('login')">Login</a></h6>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="container text-center my-5" id="features">
    <h2 class="fw-bold mb-5">Key Features</h2>
    <div class="row g-4">
      <div class="col-md-3"><div class="feature-card">📑 <h5>Electronic Health Records</h5><p>Securely store and access student health info.</p></div></div>
      <div class="col-md-3"><div class="feature-card">📅 <h5>Appointment Scheduling</h5><p>Book, manage, and track clinic appointments.</p></div></div>
      <div class="col-md-3"><div class="feature-card">💊 <h5>Medication Management</h5><p>Track medications with reminders and dosage.</p></div></div>
      <div class="col-md-3"><div class="feature-card">🔔 <h5>Alert System</h5><p>Instant notifications for emergencies and updates.</p></div></div>
    </div>
  </section>

  <!-- About Content -->
  <section class="about-section container" id="about">

    <h1 class="text text-center">About Us</h1>
    <h2>Who We Are</h2>
    <p>
      SmartClinic is a school clinic management system designed to improve healthcare services within schools. 
      Our goal is to make clinic operations faster, safer, and more efficient by using modern digital tools.
    </p>

    <h2>Our Mission</h2>
    <p>
      To provide schools with an easy-to-use platform that ensures accurate medical record-keeping, quick access 
      to health data, and streamlined clinic services for students and staff.
    </p>

    <h2>Our Vision</h2>
    <p>
      A future where every school clinic is digitally empowered to deliver excellent healthcare services 
      and support the well-being of the school community.
    </p>
  </section>

  <!-- Footer -->
  <footer class="footer" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h5>SmartClinic</h5>
          <p>Providing healthcare management solutions for schools.</p>
        </div>
        <div class="col-md-3">
          <h6>Quick Links</h6>
          <ul class="list-unstyled">
            <li><a href="#">Home</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="#">Pricing</a></li>
            <li><a href="#">Testimonials</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6>Resources</h6>
          <ul class="list-unstyled">
            <li><a href="#">Help Center</a></li>
            <li><a href="#">User Guide</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6>Contact Us</h6>
          <p>123 Education Ave<br>Boston, MA 02108</p>
          <p>(555) 123-4567<br>info@smartclinic.com</p>
        </div>
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
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

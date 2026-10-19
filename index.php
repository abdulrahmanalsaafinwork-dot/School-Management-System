<?php

include __DIR__ . '/DB_connection.php';
include __DIR__ . '/data/setting.php';
// removed include "data/news.php" because that file lives under admin/data in the repo
$setting = getSetting($conn);

function getAllNews($conn, $limit = null) {
    $sql = "SELECT * FROM news ORDER BY created_at DESC";
    if ($limit) {
        $sql .= " LIMIT ?";
    }

    $stmt = $conn->prepare($sql);

    if ($limit) {
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}

function getNewsById($conn, $id) {
    $sql = "SELECT * FROM news WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch();
}

if ($setting != 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to <?=$setting['school_name']?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/school-management-system/testing/ai_style.css?v=<?= time(); ?>">
    <link rel="icon" href="data_logo-removebg-preview.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded"/>
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            scroll-behavior: smooth;
        }
        .welcome-text {
            background: url('bggg.jpg') no-repeat center center/cover;
            color: #fff;
            min-height: 100vh;
            position: relative;
            text-align: center;
            padding-top: 140px;
        }
        .welcome-text::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.45);
            z-index: 1;
        }
        .hero-content { position: relative; z-index: 2; }
        .hero-logo { max-width: 130px; filter: drop-shadow(0 0 6px rgba(0,0,0,0.4)); }
        .btn-learn { background: #fff; color: #000; border: 2px solid #fff; transition: all 0.3s ease; }
        .btn-learn:hover { background: #800000; color: #fff; border: 2px solid #800000; box-shadow: 0 0 10px rgba(128,0,0,0.3); }
        .about-container, .contact-container { background: #fff; border-radius: 15px; border: 2px solid #ddd; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        footer { padding: 20px 0; background-color: #fff; color: #888; border-top: 1px solid #eee; }
        iframe { width: 100%; height: 400px; border: none; border-radius: 10px; }
        .nav-link.active { color: #800000 !important; font-weight: 600; }
        .card { transition: transform 0.2s; border: 1px solid #eee; }
        .card:hover { transform: translateY(-5px); }
/* ===== News Card Layout ===== */
.news-card {
  display: flex;
  gap: 1rem;
  align-items: stretch;
}

.news-image {
  width: 200px;
  flex: 0 0 200px;
  max-width: 200px;
  height: 140px;
  overflow: hidden;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f5f5f5;
}

.news-image img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  display: block;
}

/* ===== News Body ===== */
.news-body {
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
}

/* ===== Smooth Read More / Read Less Animation ===== */
.news-content {
  overflow: hidden;
  position: relative;
  line-height: 1.6em;
  transition: max-height 0.45s ease-in-out, opacity 0.4s ease;
  max-height: 4.8em; /* about 3 lines default */
}

/* subtle fade overlay when collapsed */
.news-content:not(.expanded)::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 2.4em;
  background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, #fff 100%);
  pointer-events: none;
}

/* expanded state */
.news-content.expanded {
  max-height: 1000px; /* large enough to fit full content */
}

.news-content.expanded::after {
  display: none;
}

/* ===== Read Toggle Button ===== */
.read-toggle {
  background: none;
  border: none;
  color: #007bff;
  font-weight: 600;
  cursor: pointer;
  padding: 0.4rem 0.75rem;
  border-radius: 6px;
  transition: background 0.2s ease, color 0.2s ease;
}

.read-toggle:hover {
  background: rgba(0, 123, 255, 0.1);
  color: #0056b3;
}

/* ===== Clickable Image Hover Effect ===== */
.clickable-image {
  transition: transform 0.25s ease;
  cursor: zoom-in;
}

.clickable-image:hover {
  transform: scale(1.03);
}

/* ===== Image Modal Styling ===== */
.modal,
.modal-backdrop {
  overflow: visible;
}

.modal-dialog {
  max-width: 100vw;
  margin: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
}

.modal-content {
  background: rgba(0, 0, 0, 0.9);
  border: none;
  box-shadow: none;
}

.modal-body {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  margin: 0;
  padding: 0;
  overflow-y: auto;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* ===== Scrollbar Styling (stick to screen edge) ===== */
.modal-body::-webkit-scrollbar {
  width: 12px;
}

.modal-body::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.5);
  border-radius: 8px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.8);
}

/* ===== Centered Image Animation ===== */
#modalImage {
  max-width: 95vw;
  max-height: 95vh;
  border-radius: 8px;
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
  opacity: 0;
  transform: scale(0.95);
  transition: opacity 0.35s ease, transform 0.35s ease;
}

.modal.show #modalImage {
  opacity: 1;
  transform: scale(1);
}

/* ===== Responsive Layout ===== */
@media (max-width: 767.98px) {
  .news-card {
    flex-direction: column;
  }
  .news-image {
    max-width: 100%;
    width: 100%;
    height: 200px;
  }
}

/* ====== FOOTER SECTION ====== */
.footer-section {
  background-color: #e0e0e0; /* slightly darker background */
  color: #333;
  padding: 50px 20px 20px;
  font-family: 'Poppins', sans-serif;
}

/* ====== CONTAINER ====== */
.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-evenly; /* equal spacing for all columns */
  align-items: flex-start; /* align all columns at the top */
  gap: 40px;
  margin-bottom: 30px;
}

/* ====== COLUMNS ====== */
.footer-container .col {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-bottom: 20px;
  width: 220px;
}

/* ====== HEADINGS ====== */
.footer-container h4 {
  font-size: 14px;
  font-weight: 600;
  text-transform: uppercase;
  margin-bottom: 15px;
  color: #111;
}

/* ====== PARAGRAPHS ====== */
.footer-container p {
  font-size: 13px;
  color: #555;
  margin: 0 0 8px 0;
  line-height: 1.6;
}

/* ====== LINKS ====== */
.footer-container a {
  text-decoration: none;
  font-size: 13px;
  color: #222;
  margin-bottom: 10px;
  transition: color 0.3s ease;
}

.footer-container a:hover {
  color: #800000; /* maroon hover */
  text-decoration: underline;
}

/* ====== FOLLOW US SECTION ====== */
.follow {
  margin-top: 10px; /* slightly reduced gap from title */
  display: flex;
  gap: 14px; /* equal spacing between icons */
}

.follow i {
  font-size: 18px;
  color: #465b52;
  cursor: pointer;
  transition: color 0.3s ease;
}

.follow i:hover {
  color: #800000; /* maroon hover */
}

/* ====== FOOTER BOTTOM ====== */
.footer-bottom {
  border-top: 1px solid #ccc;
  text-align: center;
  padding-top: 15px;
  font-size: 13px;
  color: #777;
}

/* ====== RESPONSIVE DESIGN ====== */
@media (max-width: 768px) {
  .footer-container {
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 30px;
  }

  .footer-container .col {
    align-items: center;
    width: 100%;
  }

  .follow {
    justify-content: center;
  }
}



    </style>
</head>

<body class="body-home">

<?php
// include chatbot markup (file lives in testing/)
if (file_exists(__DIR__ . '/testing/index.php')) {
    include_once __DIR__ . '/testing/index.php';
}
?>

<!-- ===== Navbar ===== -->
<nav class="navbar navbar-expand-lg bg-light fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#home">
            <img src="data_logo-removebg-preview.png" width="40" alt="Logo" class="me-2">
            <span class="fw-semibold"><?=$setting['school_name']?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#news">News</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#programs">Programs</a></li>
                <li class="nav-item"><a class="nav-link" href="#admission">Admission</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ===== Hero Section ===== -->
<section id="home" class="welcome-text d-flex flex-column justify-content-center align-items-center text-center">
    <div class="hero-content">
        <img src="data_logo-removebg-preview.png" class="hero-logo mb-3" alt="School Logo">
        <h1 class="fw-bold"><?=$setting['school_name']?></h1>
        <p class="text-light"><?=$setting['slogan']?></p>
        <a href="#about" class="btn btn-learn mt-3 px-4 py-2 rounded-3 shadow">Learn More</a>
    </div>
</section>

<!-- ===== Features Section ===== -->
<section class="py-5 fade-in">
    <div class="container text-center">
        <h2 class="fw-semibold mb-3">Why Choose Us</h2>
        <p class="text-secondary mb-5">Empowering students and teachers through innovation and simplicity.</p>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 feature-card">
                    <i class="bi bi-laptop fs-1 text-danger mb-3"></i>
                    <h5 class="fw-semibold mb-2">Smart Learning</h5>
                    <p class="text-muted">Access educational resources anytime with a user-friendly platform.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 feature-card">
                    <i class="bi bi-people fs-1 text-primary mb-3"></i>
                    <h5 class="fw-semibold mb-2">Community Driven</h5>
                    <p class="text-muted">Built for collaboration between teachers, students, and administrators.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 p-4 feature-card">
                    <i class="bi bi-bar-chart-line fs-1 text-success mb-3"></i>
                    <h5 class="fw-semibold mb-2">Progress Tracking</h5>
                    <p class="text-muted">Monitor performance and achievements with advanced analytics.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== News Section ===== -->
<section id="news" class="py-5 fade-in">
  <div class="container">
    <h2 class="fw-semibold text-center mb-4">Latest News</h2>

    <?php
    $newsItems = getAllNews($conn, 5);
    if (empty($newsItems)): ?>
      <div class="alert alert-info">No news available at the moment.</div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($newsItems as $news):
          $imagePath = __DIR__ . '/uploads/news/' . ($news['image'] ?? '');
          $hasImage = !empty($news['image']) && file_exists($imagePath);
        ?>
        <div class="col-12">
          <div class="card p-3 shadow-sm border-0">
            <div class="news-card d-flex flex-column flex-md-row gap-3 align-items-start">
              
              <?php if ($hasImage): ?>
                <div class="news-image flex-shrink-0">
                  <img src="uploads/news/<?= htmlspecialchars($news['image']) ?>" 
                       alt="News image" 
                       class="img-fluid rounded clickable-image"
                       style="max-width: 250px;">
                </div>
              <?php endif; ?>

              <div class="news-body flex-grow-1">
                <h5 class="mb-2"><?= htmlspecialchars($news['title']) ?></h5>
                <div class="small text-muted mb-2"><?= date('F j, Y', strtotime($news['created_at'])) ?></div>

                <div class="news-content">
                  <?= nl2br(htmlspecialchars($news['content'])) ?>
                </div>

                <button type="button" class="btn btn-link read-toggle" aria-expanded="false">Read more</button>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- ===== Image Modal ===== -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center">
        <img src="" id="modalImage" class="img-fluid rounded shadow-lg" alt="Full view">
      </div>
    </div>
  </div>
</div>

<!-- ===== About Section ===== -->
<section id="about" class="py-5 fade-in">
    <div class="container">
        <div class="about-container bg-white shadow-sm rounded-4 p-4">
            <div class="text-center mb-4">
                <h3 class="fw-semibold text-primary">About Us</h3>
            </div>
            <p class="text-secondary">
                Sample School is a place where students thrive academically and socially. 
                We focus on developing the whole person, nurturing intellectual curiosity, 
                and fostering a love for learning.
            </p>
            <h5 class="fw-semibold text-dark mt-4">Mission</h5>
            <p class="text-secondary">
                To provide quality education through mentor-focused staff, 
                reliable facilities, and efficient processes anchored on integrity, innovation, and excellence.
            </p>
            <h5 class="fw-semibold text-dark mt-4">Vision</h5>
            <p class="text-secondary mb-0">
                To become one of the most prestigious college centers in the Philippines, 
                providing personalized and compassionate instruction of the highest standard.
            </p>
        </div>
    </div>
</section>

<!-- ===== Programs Section ===== -->
<section id="programs" class="py-5 fade-in">
  <div class="container">
    <h2 class="fw-semibold text-center mb-5">Our Programs</h2>

    <div class="accordion" id="programAccordion">

      <!-- ===== Basic Education ===== -->
      <div class="accordion-item mb-3 shadow-sm">
        <h2 class="accordion-header" id="headingBasic">
          <button class="accordion-button collapsed fw-semibold text-primary" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseBasic" aria-expanded="false" aria-controls="collapseBasic">
            Basic Education Program
          </button>
        </h2>
        <div id="collapseBasic" class="accordion-collapse collapse" aria-labelledby="headingBasic" data-bs-parent="#programAccordion">
          <div class="accordion-body">
            <p>
              The Basic Education Program at Datamex College of Saint Adeline is committed to providing a strong educational foundation to young learners. 
              We aim to nurture students with the knowledge, skills, and values they need to excel academically and personally in their formative years.
            </p>

            <h5 class="fw-semibold mt-4">Program Levels</h5>
            <ul>
              <li><strong>Preschool:</strong> Early childhood education fostering social, emotional, and cognitive development.</li>
              <li><strong>Elementary:</strong> Comprehensive learning in core subjects such as Mathematics, Science, and Language.</li>
              <li><strong>Junior High School:</strong> Advanced learning focused on critical thinking and problem-solving skills.</li>
              <li><strong>Senior High School:</strong> Specialized tracks including Academic, TVL, Sports, and Arts & Design.</li>
            </ul>

            <h5 class="fw-semibold mt-4">Why Choose Us?</h5>
            <ul>
              <li>Experienced and dedicated teaching staff.</li>
              <li>Modern classrooms and facilities for effective learning.</li>
              <li>Emphasis on holistic development through extracurricular activities and values education.</li>
              <li>Strong partnership with parents to ensure student success.</li>
            </ul>

            <h5 class="fw-semibold mt-4">Enrollment Requirements</h5>
            <ul>
              <li>Photocopy of Birth Certificate (NSO/PSA)</li>
              <li>Report Card (Form 138)</li>
              <li>Certificate of Good Moral Character</li>
              <li>2x2 ID Picture</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- ===== Senior High School ===== -->
      <div class="accordion-item mb-3 shadow-sm">
        <h2 class="accordion-header" id="headingSHS">
          <button class="accordion-button collapsed fw-semibold text-primary" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseSHS" aria-expanded="false" aria-controls="collapseSHS">
            Senior High School Programs
          </button>
        </h2>
        <div id="collapseSHS" class="accordion-collapse collapse" aria-labelledby="headingSHS" data-bs-parent="#programAccordion">
          <div class="accordion-body">
            <p>
              Datamex College of Saint Adeline offers comprehensive Senior High School programs designed to prepare students for their future academic and career pursuits. 
              Our strands provide specialized education tailored to different interests and career paths.
            </p>

            <h5 class="fw-semibold mt-4">Academic Strands</h5>
            <ul>
              <li><strong>Accountancy, Business, and Management (ABM):</strong> Focuses on business, finance, and entrepreneurship.</li>
              <li><strong>Humanities and Social Sciences (HUMSS):</strong> Ideal for students passionate about communication, culture, and education.</li>
              <li><strong>General Academic Strand (GAS):</strong> Offers flexibility and a well-rounded academic foundation for various college programs.</li>
            </ul>

            <h5 class="fw-semibold mt-4">Why Choose Us?</h5>
            <ul>
              <li>State-of-the-art facilities and experienced faculty.</li>
              <li>Specialized programs aligned with your career goals.</li>
              <li>Internship and real-world exposure opportunities.</li>
              <li>Supportive learning environment that fosters academic excellence.</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- ===== Online Education ===== -->
      <div class="accordion-item mb-3 shadow-sm">
        <h2 class="accordion-header" id="headingOnline">
          <button class="accordion-button collapsed fw-semibold text-primary" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseOnline" aria-expanded="false" aria-controls="collapseOnline">
            Online Education
          </button>
        </h2>
        <div id="collapseOnline" class="accordion-collapse collapse" aria-labelledby="headingOnline" data-bs-parent="#programAccordion">
          <div class="accordion-body">
            <p>
              At Datamex College of Saint Adeline, we are committed to providing flexible and accessible learning opportunities through our online education programs. 
              Whether you're a working professional or prefer remote learning, our platform lets you achieve your goals at your own pace.
            </p>

            <h5 class="fw-semibold mt-4">Why Choose Online Education?</h5>
            <ul>
              <li>Flexible schedules to fit your lifestyle.</li>
              <li>Interactive virtual classrooms and live sessions.</li>
              <li>Access to e-books, video lectures, and discussion forums.</li>
              <li>Affordable tuition with the same quality as on-campus programs.</li>
            </ul>

            <h5 class="fw-semibold mt-4">Programs Available Online</h5>
            <ul>
              <li>Bachelor of Science in Information Technology (BSIT)</li>
              <li>Bachelor of Science in Business Administration (BSBA)</li>
              <li>Short-term Certificate Courses (e.g., Web Development, Graphic Design, Digital Marketing)</li>
            </ul>

            <h5 class="fw-semibold mt-4">How It Works</h5>
            <ol>
              <li>Enroll through our online portal.</li>
              <li>Access materials and lectures anytime.</li>
              <li>Join live virtual classes and discussions.</li>
              <li>Submit assignments and take exams online.</li>
              <li>Receive guidance from our dedicated support team.</li>
            </ol>
          </div>
        </div>
      </div>

      <!-- ===== College Programs ===== -->
      <div class="accordion-item shadow-sm">
        <h2 class="accordion-header" id="headingCollege">
          <button class="accordion-button collapsed fw-semibold text-primary" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseCollege" aria-expanded="false" aria-controls="collapseCollege">
            College Programs
          </button>
        </h2>
        <div id="collapseCollege" class="accordion-collapse collapse" aria-labelledby="headingCollege" data-bs-parent="#programAccordion">
          <div class="accordion-body">
            <p>
              Datamex College of Saint Adeline offers a range of degree programs designed to prepare students for success in their chosen careers through quality education and hands-on experience.
            </p>

            <div class="mt-4">
              <h5 class="fw-semibold text-secondary">Bachelor of Science in Information Technology (BSIT)</h5>
              <p>
                The BSIT program equips students with the technical and practical knowledge required to excel in information technology. 
                Through theoretical instruction and hands-on practice, graduates become skilled in software development, networking, and web technologies.
              </p>
              <ul>
                <li>Comprehensive curriculum in programming and system design.</li>
                <li>Industry-aligned training and internship opportunities.</li>
                <li>Expert faculty with real-world IT experience.</li>
              </ul>
            </div>

            <div class="mt-4">
              <h5 class="fw-semibold text-secondary">Bachelor of Science in Hospitality Management (BSHM)</h5>
              <p>
                The BSHM program prepares students for a dynamic career in hospitality and tourism. 
                It focuses on hotel operations, food and beverage management, and customer service excellence.
              </p>
              <ul>
                <li>Hands-on training in hotel and restaurant management.</li>
                <li>Exposure to industry-standard hospitality practices.</li>
                <li>Internship opportunities with partner hotels and resorts.</li>
              </ul>
            </div>

            <div class="mt-4">
              <h5 class="fw-semibold text-secondary">Bachelor of Science in Tourism Management (BST)</h5>
              <p>
                The BST program provides students with the knowledge and skills to excel in the tourism industry. 
                It covers areas such as travel management, tour operations, and event planning.
              </p>
              <ul>
                <li>Curriculum focusing on global tourism trends and sustainable travel.</li>
                <li>Training in tourism marketing and tour planning.</li>
                <li>Internship placements in travel agencies and tourism offices.</li>
              </ul>
            </div>

            <div class="mt-4">
              <h5 class="fw-semibold text-secondary">Bachelor of Science in Criminology (BSCRIM)</h5>
              <p>
                The BS Criminology program trains students in law enforcement, criminal investigation, and forensic science. 
                It aims to develop professionals who uphold justice, integrity, and public safety.
              </p>
              <ul>
                <li>Courses in criminal law, investigation, and forensic science.</li>
                <li>Field exposure through training with law enforcement agencies.</li>
                <li>Preparation for government licensure and public service careers.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===== Admission Section ===== -->
<section id="admission" class="py-5 fade-in">
  <div class="container">
    <h2 class="fw-semibold text-center mb-5">Admission Information</h2>

    <div class="accordion" id="admissionAccordion">

      <!-- ===== Basic Education Admission ===== -->
      <div class="accordion-item mb-3 shadow-sm">
        <h2 class="accordion-header" id="headingBasicAdmission">
          <button class="accordion-button collapsed fw-semibold text-primary" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseBasicAdmission" aria-expanded="false" aria-controls="collapseBasicAdmission">
            Basic Education Admission Info
          </button>
        </h2>
        <div id="collapseBasicAdmission" class="accordion-collapse collapse" aria-labelledby="headingBasicAdmission"
          data-bs-parent="#admissionAccordion">
          <div class="accordion-body">
            <h5 class="fw-semibold mb-3">Application Requirements for Basic Education</h5>

            <h6 class="fw-semibold text-secondary mt-3">Freshmen (New Enrollees)</h6>
            <ul>
              <li>Accomplished Application Form</li>
              <li>High School Report Card (Form 138)</li>
              <li>High School Transcript (Form 137a)</li>
              <li>Certificate of Good Moral Character</li>
              <li>2x2 picture (for 201 file)</li>
              <li>1x1 picture (for ID)</li>
            </ul>

            <h6 class="fw-semibold text-secondary mt-3">Transferees</h6>
            <ul>
              <li>Accomplished Application Form</li>
              <li>Honorable Dismissal/Transfer Credentials</li>
              <li>Temporary Transcript/Certificate of Grades for evaluation purposes</li>
              <li>Official Transcript of Records to be sent by the previous school with a notation</li>
              <li>Subject description taken from the previous school</li>
              <li>1x1 picture (for ID)</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- ===== Senior High Admission ===== -->
      <div class="accordion-item mb-3 shadow-sm">
        <h2 class="accordion-header" id="headingSHAdmission">
          <button class="accordion-button collapsed fw-semibold text-primary" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseSHAdmission" aria-expanded="false" aria-controls="collapseSHAdmission">
            Senior High School Admission Info
          </button>
        </h2>
        <div id="collapseSHAdmission" class="accordion-collapse collapse" aria-labelledby="headingSHAdmission"
          data-bs-parent="#admissionAccordion">
          <div class="accordion-body">
            <h5 class="fw-semibold mb-3">Application Requirements for Senior High School</h5>
            <ul>
              <li>Form 137 or Grade 10 report card and copy of certificate of Grade 10 completion</li>
              <li>Copy of NSO birth certificate</li>
              <li>Certificate of good moral character from previous school</li>
              <li>2 pcs. 2×2 picture</li>
              <li>1 long brown envelope</li>
              <li>Voucher/Payment of tuition fees (for students from private schools who did not avail of DepEd voucher subsidy)</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- ===== College Admission ===== -->
      <div class="accordion-item shadow-sm">
        <h2 class="accordion-header" id="headingCollegeAdmission">
          <button class="accordion-button collapsed fw-semibold text-primary" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseCollegeAdmission" aria-expanded="false" aria-controls="collapseCollegeAdmission">
            College Admission Info
          </button>
        </h2>
        <div id="collapseCollegeAdmission" class="accordion-collapse collapse" aria-labelledby="headingCollegeAdmission"
          data-bs-parent="#admissionAccordion">
          <div class="accordion-body">
            <h5 class="fw-semibold mb-3">Application Requirements for College Programs</h5>

            <h6 class="fw-semibold text-secondary mt-3">Freshmen (New Enrollees)</h6>
            <ul>
              <li>Accomplished Application Form</li>
              <li>High School Report Card (Form 138)</li>
              <li>High School Transcript (Form 137a)</li>
              <li>Certificate of Good Moral Character</li>
              <li>2x2 picture (for 201 file)</li>
              <li>1x1 picture (for ID)</li>
            </ul>

            <h6 class="fw-semibold text-secondary mt-3">Transferees</h6>
            <ul>
              <li>Accomplished Application Form</li>
              <li>Honorable Dismissal/Transfer Credentials</li>
              <li>Temporary Transcript/Certificate of Grades for evaluation purposes</li>
              <li>Official Transcript of Records to be sent by the previous school with a notation</li>
              <li>Subject description taken from the previous school</li>
              <li>1x1 picture (for ID)</li>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- Contact Section -->
<section id="contact" class="py-5 fade-in">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-md-6">
                <div class="contact-container shadow-sm p-4 h-100">
                    <h3 class="fw-semibold text-primary mb-4 text-center">Contact Us</h3>
                    <form method="post" action="req/contact.php">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Message</label>
                            <textarea class="form-control" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Send</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-container shadow-sm p-3 h-100">
                    <h4 class="fw-semibold text-primary text-center mb-3">Our Location</h4>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d30905.368878969883!2d121.008197!3d14.474862000000002!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ce64b6df27e1%3A0x251b5780c5fb79dd!2sDatamex!5e0!3m2!1sen!2sph!4v1761070596383!5m2!1sen!2sph" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="footer-section">
  <div class="footer-container">
    
    <!-- CONTACT -->
    <div class="col">
      <h4>Contact</h4>
      <p><strong>Address:</strong> FXHX+4VM, Dr Arcadio Santos Ave, Parañaque, 1700 Metro Manila</p>
      <p><strong>Phone:</strong> (+63) 906 - 8614 - 002</p>
      <p><strong>Email:</strong> dcsa@gmail.com</p>
      <p><strong>Hours:</strong> Mon - Fri: 8AM - 5PM</p>
    </div>

    <!-- SCHOOL PORTAL -->
    <div class="col">
      <h4>School Portal</h4>
      <a href="login.php">Student Login</a>
      <a href="login.php">Faculty Login</a>
      <a href="#news">Announcements</a>
    </div>

<!-- QUICK LINKS -->
<div class="col">
  <h4>Quick Links</h4>
  <a href="#about">About Datamex</a>
  <a href="#programs">Programs Offered</a>
  <a href="#admission">Admissions</a>
  <a href="#home">Campus Life</a>
  <a href="#contact">Contact Us</a>
</div>

    <!-- FOLLOW US -->
    <div class="col">
      <h4>Follow Us</h4>
<div class="follow">
  <a href="https://www.facebook.com/CollegeofStAdelineParanaque" target="_blank" aria-label="Facebook">
    <i class="fa fa-facebook"></i>
  </a>
    <i class="fa fa-twitter"></i>
  </a>
    <i class="fa fa-instagram"></i>
  </a>
  <a href="https://www.youtube.com/@dcsasucatbranch" target="_blank" aria-label="YouTube">
    <i class="fa fa-youtube-play"></i>
  </a>
</div>

    </div>

  </div>

  <div class="footer-bottom">
    <p>© 2025 Datamex College of Saint Adeline. All Rights Reserved.</p>
  </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/school-management-system/testing/ai_script.js?v=<?= time(); ?>"></script>
<script>
    // nav active on scroll
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll(".nav-link");
    window.addEventListener("scroll", () => {
        let current = "";
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 150;
            if (pageYOffset >= sectionTop) current = section.getAttribute("id");
        });
        navLinks.forEach(link => {
            link.classList.remove("active");
            if (link.getAttribute("href").includes(current)) link.classList.add("active");
        });
    });

// ===== Read more / Read less toggle + Image Modal Enhancements =====
// ===== Read more / Read less toggle + Image Modal =====
document.addEventListener("click", function (e) {
  // Toggle Read More / Read Less
  if (e.target && e.target.classList.contains("read-toggle")) {
    const btn = e.target;
    const body = btn.closest(".news-body");
    if (!body) return;

    const content = body.querySelector(".news-content");
    const expanded = btn.getAttribute("aria-expanded") === "true";

    if (expanded) {
      // Collapse
      const previewHeight = 4.8 * 16; // 4.8em in px (approx)
      content.style.maxHeight = content.scrollHeight + "px";
      requestAnimationFrame(() => {
        content.classList.remove("expanded");
        content.style.maxHeight = previewHeight + "px";
      });

      btn.textContent = "Read more";
      btn.setAttribute("aria-expanded", "false");
    } else {
      // Expand
      content.style.maxHeight = content.scrollHeight + "px";
      content.classList.add("expanded");

      btn.textContent = "Read less";
      btn.setAttribute("aria-expanded", "true");

      // allow full open state to settle
      setTimeout(() => {
        content.style.maxHeight = content.scrollHeight + "px";
      }, 300);
    }
  }

  // ===== Image click -> open modal =====
  if (e.target && e.target.classList.contains("clickable-image")) {
    const src = e.target.getAttribute("src");
    const modalImg = document.getElementById("modalImage");
    modalImg.setAttribute("src", src);

    const modal = new bootstrap.Modal(document.getElementById("imageModal"));
    modal.show();
  }
});

// ===== Close modal when clicking outside image =====
document
  .getElementById("imageModal")
  .addEventListener("click", function (e) {
    const modalImg = document.getElementById("modalImage");
    if (!modalImg.contains(e.target)) {
      const modal = bootstrap.Modal.getInstance(this);
      modal.hide();
    }
  });

</script>
</body>
</html>
<?php 
} else {
    header("Location: login.php");
    exit;
}
?>
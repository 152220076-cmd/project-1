<?php
$page_title = "Home";
include 'includes/config.php';
include 'includes/header.php';
include 'includes/hero-background.php';

$hero = new HeroBackground();
$background = $hero->getRandomBackground();
?>

    <!-- Hero Section -->
    <section class="hero" <?php if ($background['type'] === 'image') echo 'style="' . $hero->getBackgroundStyle($background) . '"'; ?>>
        <?php echo $hero->getVideoMarkup($background); ?>
        
        <div class="hero-content">
            <h1 data-aos="fade-up" data-aos-duration="1000">We Guide Your Journey</h1>
            <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                Your journey is different from others. A special guide for your brand, 
                a customized map to your needs for achieving your goals. Let us help you 
                navigate the digital landscape with confidence.
            </p>
            <div class="hero-buttons" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <a href="#contact" class="hero-btn primary">Start Your Journey</a>
                <a href="/portfolio" class="hero-btn secondary">View Our Work</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-mouse"></div>
            <p>Scroll Down</p>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio">
        <div class="container">
            <div class="portfolio-header" data-aos="fade-up">
                <h2>Our Amazing Work</h2>
                <p>Discover how we've helped brands achieve their goals through creative solutions and strategic thinking.</p>
            </div>

            <div class="portfolio-filters" data-aos="fade-up" data-aos-delay="200">
                <button class="filter-btn active" data-filter="all">All</button>
                <?php
                include 'includes/portfolio.php';
                $portfolio = new Portfolio($conn);
                
                // Insert sample data if portfolio is empty
                if (count($portfolio->getPortfolioItems()) === 0) {
                    $portfolio->insertSampleData();
                }

                $categories = $portfolio->getCategories();
                foreach ($categories as $category) {
                    echo '<button class="filter-btn" data-filter="' . strtolower(str_replace(' ', '-', $category)) . '">' . $category . '</button>';
                }
                ?>
            </div>

            <div class="portfolio-grid" data-aos="fade-up" data-aos-delay="400">
                <?php
                $items = $portfolio->getPortfolioItems();
                foreach ($items as $item) {
                    $categoryClass = strtolower(str_replace(' ', '-', $item['category']));
                    echo '
                    <div class="portfolio-item" data-category="' . $categoryClass . '">
                        <img src="' . $item['image_url'] . '" alt="' . $item['title'] . '">
                        <div class="portfolio-overlay">
                            <h3>' . $item['title'] . '</h3>
                            <p>' . $item['description'] . '</p>
                            <a href="/portfolio/' . $categoryClass . '" class="view-project">View Project</a>
                        </div>
                    </div>';
                }
                ?>
            </div>

            <div class="portfolio-loader">
                <div class="loader-dots">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Clients Section -->
    <section class="clients">
        <div class="container">
            <div class="clients-header" data-aos="fade-up">
                <h2>Our Amazing Clients</h2>
                <p>We're proud to work with industry leaders who trust us to deliver exceptional creative solutions.</p>
            </div>

            <div class="clients-grid" data-aos="fade-up" data-aos-delay="200">
                <?php
                include_once 'includes/clients.php';
                $clientsManager = new Clients($conn);
                
                // Create clients table if not exists
                $clientsManager->setupClientsTable();
                
                // Insert sample clients if none exist
                if (count($clientsManager->getClients()) === 0) {
                    $clientsManager->insertSampleClients();
                }

                // Display clients
                $clients = $clientsManager->getClients();
                foreach ($clients as $client) {
                    echo '
                    <div class="client-item" data-aos="fade-up" data-aos-delay="300">
                        <img src="' . $client['logo_url'] . '" alt="' . $client['name'] . ' logo">
                        <div class="client-info">
                            ' . $client['name'] . ' - ' . $client['industry'] . '
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>

        <!-- Client Counter Section -->
        <div class="client-counter">
            <div class="container">
                <div class="counter-grid">
                    <div class="counter-item" data-aos="fade-up">
                        <h3><span class="counter-value" data-target="150">0</span>+</h3>
                        <p>Projects Completed</p>
                    </div>
                    <div class="counter-item" data-aos="fade-up" data-aos-delay="100">
                        <h3><span class="counter-value" data-target="50">0</span>+</h3>
                        <p>Happy Clients</p>
                    </div>
                    <div class="counter-item" data-aos="fade-up" data-aos-delay="200">
                        <h3><span class="counter-value" data-target="10">0</span>+</h3>
                        <p>Years Experience</p>
                    </div>
                    <div class="counter-item" data-aos="fade-up" data-aos-delay="300">
                        <h3><span class="counter-value" data-target="25">0</span>+</h3>
                        <p>Team Members</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="contact-header" data-aos="fade-up">
                <h2>Let's Talk with Us</h2>
                <p>Ready to grow your brand? Fill out the form and our team will get in touch with you soon.</p>
            </div>
            <div class="contact-wrapper">
                <form action="includes/process_contact.php" method="POST" class="contact-form">
                    <div class="form-message" id="form-message"></div>
                    <div class="form-group">
                        <input type="text" name="name" required placeholder="Your name">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" required placeholder="Your email">
                    </div>
                    <div class="form-group">
                        <select name="service" required>
                            <option value="">Select Service</option>
                            <option value="digital">Digital Services</option>
                            <option value="photo">Photo & Video</option>
                            <option value="branding">Branding</option>
                            <option value="design">Graphic Design</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" required placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <textarea name="message" required placeholder="Your message"></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Submit</button>
                </form>

                <div class="contact-info" data-aos="fade-up" data-aos-delay="200">
                    <h4>Our Address</h4>
                    <p>Mall of Indonesia, Ruko ItalianWalk<br>Jalan Boulevard Barat Raya Blok B No.43</p>
                    <h4>Connect with Us</h4>
                    <a href="mailto:albertfelamon@northkreatif.com">albertfelamon@northkreatif.com</a>
                    <a href="mailto:andry@northkreatif.com">andry@northkreatif.com</a>
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="https://www.facebook.com/northkreatif" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.instagram.com/northkreatif" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://id.linkedin.com/company/north-creative-agency" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>
                    <h4>Call Us</h4>
                    <a href="https://api.whatsapp.com/send?phone=6282110118031" target="_blank">+62 821 1011 8031</a>
                    <a href="tel:+622145869825">+62 21 458 698 25</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>Our Address</h4>
                    <p>Your Address Here</p>
                </div>
                <div class="footer-col">
                    <h4>Connect with Us</h4>
                    <p>email@yourdomain.com</p>
                </div>
                <div class="footer-col">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Call Us</h4>
                    <p>+1234567890</p>
                </div>
            </div>
        </div>
    </footer>

<?php include 'includes/footer.php'; ?>
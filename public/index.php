<?php 
$app = include __DIR__.'/../src/App/bootstrap.php';
$app->run();
?>
<?php include_once('./layout/header.php') ?>
    <main>
        <section class="hero" aria-label="Welcome">
            <div class="image-container">
                <h1><span>WELCOME</span> TO ABUAD ONLINE HOSPITAL</h1>
                <p>Your Health, Our Priority</p>
            </div>
        </section>

        <section id="about" class="about" aria-labelledby="about-heading">
            <div class="about-container">
                <div class="about-image">
                    <img src="./img/Screenshot 2025-09-19 073304.png" alt="Exterior view of ABUAD Hospital building"
                        loading="lazy">
                </div>
                <div class="about-text">
                    <h2 id="about-heading">About Us</h2>
                    <p>
                        At <strong>ABUAD Online Hospital</strong>, we believe healthcare should be as close as your
                        fingertips. Our platform is designed to connect patients with licensed doctors, making
                        consultations, prescriptions, and health records accessible anytime, anywhere.
                    </p>
                    <p>
                        With a focus on <em>innovation and care</em>, we combine the expertise of Afe Babalola
                        University's medical professionals with modern digital technology to provide a safe,
                        fast, and reliable healthcare experience.
                    </p>
                    <p>
                        Whether you need an urgent consultation, a routine check-up, or access to your medical history,
                        ABUAD Online Hospital is your trusted health partner—ensuring that <strong>your health remains
                            our top priority.</strong>
                    </p>
                </div>
            </div>
        </section>

        <section class="gallery" aria-labelledby="specialists-heading">
            <h2 id="specialists-heading">Meet Our Specialists</h2>
            <div class="gallery-container">

                <article class="gallery-item">
                    <div class="card">
                        <div class="card-header">
                            <img src="./img/photo 5.jpg" alt="Portrait of Dr. Mary Okoro" loading="lazy">
                            <a href="book.php" class="book-btn"
                                aria-label="Book appointment with Dr. Mary Okoro">Book</a>
                        </div>
                        <div class="card-body">
                            <h3>Dr. Mary Okoro</h3>
                            <p class="card-class">Neurologist</p>
                        </div>
                    </div>
                </article>

                <article class="gallery-item">
                    <div class="card">
                        <div class="card-header">
                            <img src="./img/photo 2.jpg" alt="Portrait of Dr. John Adewale" loading="lazy">
                            <a href="book.php" class="book-btn"
                                aria-label="Book appointment with Dr. John Adewale">Book</a>
                        </div>
                        <div class="card-body">
                            <h3>Dr. John Adewale</h3>
                            <p class="card-class">Orthopedist</p>
                        </div>
                    </div>
                </article>

                <article class="gallery-item">
                    <div class="card">
                        <div class="card-header">
                            <img src="./img/photo 4.jpg" alt="Portrait of Dr. Grace Oladipo" loading="lazy">
                            <a href="book.php" class="book-btn"
                                aria-label="Book appointment with Dr. Grace Oladipo">Book</a>
                        </div>
                        <div class="card-body">
                            <h3>Dr. Grace Oladipo</h3>
                            <p class="card-class">Ophthalmologist</p>
                        </div>
                    </div>
                </article>

            </div>
        </section>

        <section class="testimonials" aria-labelledby="testimonials-heading">
            <h2 id="testimonials-heading">What Our Patients Say</h2>
            <div class="testimonials-container">
                <div class="testimonials-wrapper">

                    <div class="testimonials-card active" aria-live="polite">
                        <p>"Booking a doctor online saved me hours of waiting. The consultation was smooth and
                            professional."</p>
                        <h4>— Sarah A.</h4>
                    </div>

                    <div class="testimonials-card" aria-live="polite">
                        <p>"I got my prescription immediately after the video call. Excellent service, very reliable."
                        </p>
                        <h4>— Joseph O.</h4>
                    </div>

                    <div class="testimonials-card" aria-live="polite">
                        <p>"The doctors were friendly and attentive. I felt like I was in safe hands without leaving
                            home."</p>
                        <h4>— Abdullahi B.</h4>
                    </div>

                </div>

                <button class="slider-btn prev-btn" onclick="changeSlide(-1)"
                    aria-label="Previous testimonial">&#8249;</button>
                <button class="slider-btn next-btn" onclick="changeSlide(1)"
                    aria-label="Next testimonial">&#8250;</button>

                <div class="slider-dots" role="tablist">
                    <button class="dot active" onclick="currentSlide(1)" role="tab" aria-label="Testimonial 1"></button>
                    <button class="dot" onclick="currentSlide(2)" role="tab" aria-label="Testimonial 2"></button>
                    <button class="dot" onclick="currentSlide(3)" role="tab" aria-label="Testimonial 3"></button>
                </div>
            </div>
        </section>

        <section id="contact" class="contact" aria-labelledby="contact-heading">
            <div class="contact-container">
                <h2 id="contact-heading">Contact Us</h2>
                <p id="need">Need Help? Our team is here for you 24/7. Reach out through the details below or send us a
                    message.</p>

                <div class="grp">
                    <div class="contact-content">
                        <div class="contact-info">
                            <h3>Get in Touch</h3>
                            <p><strong>Phone:</strong> <a href="tel:+2349061112684"
                                    style="color: inherit; text-decoration: none;">+234 906 111 2684</a></p>
                            <p><strong>Email:</strong> <a href="mailto:support@abuadoh.org"
                                    style="color: inherit; text-decoration: none;">support@abuadoh.org</a></p>
                            <p><strong>Address:</strong> Abuad Teaching Hospital, Ado-Ekiti, Nigeria</p>
                        </div>
                    </div>

                    <div class="contact-form">
                        <h3>Send a Message</h3>
                        <form action="#" method="POST">
                            <div class="form-group">
                                <label for="userName" style="display: none;">Your Name</label>
                                <input type="text" id="userName" name="userName" placeholder="Your Name" required>
                            </div>

                            <div class="form-group">
                                <label for="userEmail" style="display: none;">Your Email</label>
                                <input type="email" id="userEmail" name="userEmail" placeholder="Your Email" required>
                            </div>

                            <div class="form-group">
                                <label for="userMessage" style="display: none;">Your Message</label>
                                <textarea id="userMessage" name="userMessage" placeholder="Your Message" rows="4"
                                    required></textarea>
                            </div>

                            <button type="submit">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>

<?php include_once('./layout/footer.php') ?>
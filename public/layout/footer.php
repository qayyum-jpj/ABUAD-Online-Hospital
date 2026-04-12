 <footer>
        <div class="footer-container">
            <p>&copy; 2025 ABUAD Online Hospital. All Rights Reserved.</p>
            <p>Developed by <strong>Abdul-Qayyum Olarinde</strong></p>
        </div>
    </footer>

    <script>
        // Best practice: Wrap in an IIFE or ensure variables don't pollute global scope if scaling up
        document.addEventListener('DOMContentLoaded', () => {
            let slideIndex = 0;
            const slides = document.querySelectorAll('.testimonials-card');
            const dots = document.querySelectorAll('.dot');
            const totalSlides = slides.length;
            let autoSlideInterval;

            function initSlider() {
                if (totalSlides === 0) return;
                showSlide(slideIndex);
                startAutoSlide();
            }

            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));

                slides[index].classList.add('active');
                dots[index].classList.add('active');
            }

            // Expose these to the window object since they are called directly from HTML inline handlers
            window.changeSlide = function (direction) {
                slideIndex += direction;
                if (slideIndex >= totalSlides) slideIndex = 0;
                else if (slideIndex < 0) slideIndex = totalSlides - 1;
                showSlide(slideIndex);
            };

            window.currentSlide = function (index) {
                slideIndex = index - 1;
                showSlide(slideIndex);
            };

            function autoSlide() {
                slideIndex++;
                if (slideIndex >= totalSlides) slideIndex = 0;
                showSlide(slideIndex);
            }

            function startAutoSlide() {
                autoSlideInterval = setInterval(autoSlide, 5000);
            }

            // Pause auto-slide on hover
            const testimonialContainer = document.querySelector('.testimonials-container');
            if (testimonialContainer) {
                testimonialContainer.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
                testimonialContainer.addEventListener('mouseleave', startAutoSlide);
            }

            initSlider();
        });
    </script>
    
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>
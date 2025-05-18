@include("frontPage.header")
<!-- Spinner Start -->
<div id="spinner"
    class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->


<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0 ">
    <a href="#" class="navbar-brand px-4 px-lg-5">
        <h2 class="m-0 text-primary">
            <span>
                <img height="70" src="{{asset("altImages/Horizon Tech.jpg")}}" class="mr-2" alt="logo" />
                Horizon Tech
            </span>
        </h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="#aboutus" class="nav-item nav-link">About Us</a>
            <a href="#programs" class="nav-item nav-link">Our Programs</a>
            <a href="#faculty" class="nav-item nav-link">Our Faculty</a>
            <a href="#contactus" class="nav-item nav-link">Contact Us</a>
        </div>
        <a href="{{route("loginPage")}}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login Now<i
                class="fa fa-arrow-right ms-3"></i></a>
    </div>
</nav>
<!-- Navbar End -->


<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div class="owl-carousel header-carousel position-relative">
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="{{ asset('fontPage/img/carousel-1.jpg')}}" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                style="background: rgba(24, 29, 56, .7);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-sm-10 col-lg-8">
                            <h5 class="text-primary text-uppercase text-white mb-3 animated slideInDown">Leading Nursing Education
                            </h5>
                            <h1 class="display-3 text-white animated slideInDown">Empowering Future Healthcare Heroes
                            </h1>
                            <p class="fs-5 text-white mb-4 pb-2">Join a community committed to excellence in nursing
                                education. Gain the skills, knowledge, and confidence to make a difference in patient
                                care worldwide.</p>
                            <a href="#programs" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Explore
                                Programs</a>
                            <a href="{{ route('register.page') }}"
                                class="btn btn-light py-md-3 px-md-5 animated slideInRight">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="{{ asset('fontPage/img/carousel-2.jpg')}}" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center"
                style="background: rgba(24, 29, 56, .7);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-sm-10 col-lg-8">
                            <h5 class="text-primary text-uppercase text-white mb-3 animated slideInDown">Start Your Nursing Journey
                            </h5>
                            <h1 class="display-3 text-white animated slideInDown">Learn. Care. Lead the Future of
                                Healthcare</h1>
                            <p class="fs-5 text-white mb-4 pb-2">Our accredited programs provide hands-on training,
                                experienced faculty, and a supportive environment to launch your nursing career with
                                confidence and purpose.</p>
                            <a href="#aboutus" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Discover
                                More</a>
                            <a href="{{ route('register.page') }}"
                                class="btn btn-light py-md-3 px-md-5 animated slideInRight">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* HERO SECTION IMPROVEMENTS - BLACK OVERLAY */
.header-carousel .owl-carousel-item .position-absolute {
    background: rgba(0, 0, 0, 0.75) !important; /* Strong black overlay */
}
.header-carousel .container .row .col-sm-10.col-lg-8 {
    background: rgba(0,0,0,0.10); /* Subtle black overlay for text clarity */
    border-radius: 1rem;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
    padding: 2rem 2.5rem;
}
.header-carousel h5.text-primary,
.header-carousel h1.display-3,
.header-carousel p.fs-5 {
    color: #fff !important;
    text-shadow: 0 2px 8px rgba(0,0,0,0.25);
}
.header-carousel h5.text-primary {
    background: rgba(0,0,0,0.3);
    display: inline-block;
    padding: 0.25rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 1rem;
}
.header-carousel .btn-primary {
    background: #0d6efd !important;
    color: #fff !important;
    border: none;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(13,110,253,0.10);
    transition: background 0.2s, color 0.2s;
}
.header-carousel .btn-primary:hover {
    background: #084298 !important;
    color: #fff !important;
}
.header-carousel .btn-light {
    background: #fff !important;
    color: #0d6efd !important;
    border: none;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(13,110,253,0.10);
    transition: background 0.2s, color 0.2s;
}
.header-carousel .btn-light:hover {
    background: #0d6efd !important;
    color: #fff !important;
}
.header-carousel .owl-carousel-item img {
    max-height: 560px;
    width: 100%;
    object-fit: cover;
}
.header-carousel .owl-carousel-item .position-absolute {
    min-height: 380px;
    max-height: 560px;
    height: 70vh;
    display: flex;
    align-items: center;
}
@media (max-width: 768px) {
    .header-carousel .owl-carousel-item img,
    .header-carousel .owl-carousel-item .position-absolute {
        max-height: 380px;
        height: 50vh;
    }
}
</style>

<!-- Carousel End -->


<!-- Service Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-user-md text-primary mb-4"></i>
                        <h5 class="mb-3">Experienced Faculty</h5>
                        <p>Learn from highly qualified nursing professionals with years of clinical and teaching
                            experience.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-laptop-medical text-primary mb-4"></i>
                        <h5 class="mb-3">Virtual Learning</h5>
                        <p>Access lectures, resources, and simulations online for flexible, on-the-go learning
                            opportunities.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-briefcase-medical text-primary mb-4"></i>
                        <h5 class="mb-3">Clinical Training</h5>
                        <p>Hands-on hospital training and real-world case studies to prepare you for your nursing
                            career.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="service-item text-center pt-3">
                    <div class="p-4">
                        <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                        <h5 class="mb-3">Resourceful Library</h5>
                        <p>Extensive library with the latest textbooks, journals, and research materials in nursing and
                            healthcare.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service End -->

<!-- Interactive Cards Section Start -->
<div class="container-xxl py-5" id="programs">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="section-title bg-white text-center text-primary px-3">Apply Now</h6>
            <h1 class="mb-4">Join Our Programs</h1>
        </div>
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm border-0 hover-shadow" style="transition: transform 0.3s;">
                    <img src="{{asset("altImages/C4.jpg")}}" class="card-img-top" alt="Program 1">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">BS Diet & Nutrition</h5>
                        <p class="card-text">Transportation and hostel facilities available.</p>
                        <a href="{{ route('register.page') }}" class="btn btn-primary mt-2">Apply Now</a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm border-0 hover-shadow" style="transition: transform 0.3s;">
                    <img src="{{asset("altImages/C3.jpg")}}" class="card-img-top" alt="Program 2">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">BS Nursing</h5>
                        <p class="card-text">Transportation and hostel facilities available.</p>
                        <a href="{{ route('register.page') }}" class="btn btn-primary mt-2">Apply Now</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm border-0 hover-shadow" style="transition: transform 0.3s;">
                    <img src="{{asset("altImages/C2.jpg")}}" class="card-img-top" alt="Program 3">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">BS Medical Laboratory Technology</h5>
                        <p class="card-text">Transportation and hostel facilities available.</p>
                        <a href="{{ route('register.page') }}" class="btn btn-primary mt-2">Apply Now</a>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm border-0 hover-shadow" style="transition: transform 0.3s;">
                    <img src="{{asset("altImages/C1.jpg")}}" class="card-img-top" alt="Program 4">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Doctor of Physical Therapy</h5>
                        <p class="card-text">Transportation and hostel facilities available.</p>
                        <a href="{{ route('register.page') }}" class="btn btn-primary mt-2">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .team-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        display: block;
    }
</style>




<!-- About Start -->
<div class="container-xxl py-5" id="aboutus">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('fontPage/img/newImage.jpg') }}"
                        alt="Nursing College Image" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                <h1 class="mb-4">Welcome to Our Nursing College</h1>
                <p class="mb-4">At our esteemed Nursing College, we are dedicated to empowering future healthcare
                    leaders.
                    Through a blend of academic excellence and hands-on clinical experience, we nurture compassionate,
                    skilled, and ethical nursing professionals ready to serve globally.
                </p>
                <p class="mb-4">Our curriculum combines the latest in medical education, research-driven practices, and
                    real-world hospital exposure, ensuring our graduates are ready to meet the evolving needs of the
                    healthcare industry.</p>
                <div class="row gy-2 gx-4 mb-4">
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Qualified Faculty</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Advanced Laboratories</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Clinical Training Programs
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Global Certifications</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Student-Centered Learning</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Modern Library Resources</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s" id="faculty">
            <h6 class="section-title bg-white text-center text-primary px-3">Meet Our Faculty</h6>
            <h1 class="mb-5">Our Esteemed Nursing Educators</h1>
        </div>
        <div class="row g-4">
            <!-- Instructor 1 -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item bg-light">
                    <div class="overflow-hidden">
                        <img class="img-fluid" src="{{ asset('fontPage/img/team-1.jpg') }}" alt="Instructor 1">
                    </div>
                    <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                        <div class="bg-light d-flex justify-content-center pt-2 px-1">
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="text-center p-4">
                        <h5 class="mb-0">Dr. Ali Abbass</h5>
                        <small>Professor of Nursing Sciences</small>
                    </div>
                </div>
            </div>
            <!-- Instructor 2 -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="team-item bg-light">
                    <div class="overflow-hidden">
                        <img class="img-fluid" src="{{ asset('fontPage/img/team-2.jpg') }}" alt="Instructor 2">
                    </div>
                    <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                        <div class="bg-light d-flex justify-content-center pt-2 px-1">
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-linkedin"></i></a>
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="text-center p-4">
                        <h5 class="mb-0">Ms. Alishba Khan</h5>
                        <small>Clinical Nursing Instructor</small>
                    </div>
                </div>
            </div>
            <!-- Instructor 3 -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="team-item bg-light">
                    <div class="overflow-hidden">
                        <img class="img-fluid" src="{{ asset('fontPage/img/team-3.jpg') }}" alt="Instructor 3">
                    </div>
                    <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                        <div class="bg-light d-flex justify-content-center pt-2 px-1">
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-linkedin"></i></a>
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="text-center p-4">
                        <h5 class="mb-0">Mr. Muzammil Nawaz</h5>
                        <small>Community Health Specialist</small>
                    </div>
                </div>
            </div>
            <!-- Instructor 4 -->
            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="team-item bg-light">
                    <div class="overflow-hidden">
                        <img class="img-fluid" src="{{ asset('fontPage/img/team-4.jpg') }}" alt="Instructor 4">
                    </div>
                    <div class="position-relative d-flex justify-content-center" style="margin-top: -23px;">
                        <div class="bg-light d-flex justify-content-center pt-2 px-1">
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-linkedin"></i></a>
                            <a class="btn btn-sm-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="text-center p-4">
                        <h5 class="mb-0">Prof. Sophia Ali</h5>
                        <small>Head of Nursing Department</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Team End -->


<!-- Testimonial Start -->
<!-- <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="text-center">
            <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
            <h1 class="mb-5">What Our Nursing Students Say!</h1>
        </div>
        <div class="owl-carousel testimonial-carousel position-relative">
            
            <div class="testimonial-item text-center">
                <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('fontPage/img/testimonial-1.jpg') }}"
                    style="width: 80px; height: 80px;">
                <h5 class="mb-0">Sarah Johnson</h5>
                <p>B.Sc Nursing Graduate</p>
                <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">"The faculty here provided me with incredible guidance and support throughout my
                        journey. I feel fully prepared to start my nursing career."</p>
                </div>
            </div>
            
            <div class="testimonial-item text-center">
                <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('fontPage/img/testimonial-2.jpg') }}"
                    style="width: 80px; height: 80px;">
                <h5 class="mb-0">Daniel White</h5>
                <p>Diploma in Nursing</p>
                <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">"Hands-on clinical training and knowledgeable instructors made learning here an
                        amazing experience. Highly recommend this college!"</p>
                </div>
            </div>
            
            <div class="testimonial-item text-center">
                <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('fontPage/img/testimonial-3.jpg') }}"
                    style="width: 80px; height: 80px;">
                <h5 class="mb-0">Emily Brown</h5>
                <p>Post Basic B.Sc Nursing</p>
                <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">"The supportive environment and modern facilities made a huge difference in my
                        learning. Proud to be part of this institution."</p>
                </div>
            </div>
            
            <div class="testimonial-item text-center">
                <img class="border rounded-circle p-2 mx-auto mb-3" src="{{ asset('fontPage/img/testimonial-4.jpg') }}"
                    style="width: 80px; height: 80px;">
                <h5 class="mb-0">James Anderson</h5>
                <p>M.Sc Nursing Student</p>
                <div class="testimonial-text bg-light text-center p-4">
                    <p class="mb-0">"Advanced curriculum and experienced professors helped me deepen my knowledge in
                        specialized nursing fields. A great place to study!"</p>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Testimonial End -->


<!-- Footer Start -->
<div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3">Quick Link</h4>
                <a class="btn btn-link" href="#aboutus">About Us</a>
                <a class="btn btn-link" href="#contactus">Contact Us</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="text-white mb-3" id="contactus">Contact</h4>
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Main GT-Road Hassanabdal, Near Sage Leather Point, Hassanabdal, Punjab, Hassanabad, Pakistan</p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>0326 0011888</p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i>hihs.hc2017@gmail.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href="https://www.facebook.com/p/Horizon-Institute-of-Health-Sciences-Hassanabdal-Chapter-100089866801262/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://www.instagram.com/hihs_edu.pk?igsh=MXAxcmljbGVkeG1qdQ=="><i class="fab fa-instagram" target="_blank"></i></a>
                    <a class="btn btn-outline-light btn-social" href="https://www.linkedin.com/company/horizon-school-of-nursing-health-sciences/?originalSubdomain=pk" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <h4 class="text-white mb-3">Our Location</h4>
                <div class="map-container" style="height: 300px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3314.6027163989493!2d72.6707413!3d33.82256410000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38df0717a74bc913%3A0x37570e2004138dbe!2sHorizon%20Institute%20of%20Health%20Sciences%20HC!5e0!3m2!1sen!2s!4v1747068224693!5m2!1sen!2s" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="copyright">
            <div class="row">

                <div class="col-md-12 text-center ">
                    <div class="footer-menu">
                        <!-- <a href="">Home</a>
                        <a href="">Cookies</a>
                        <a href="">Help</a>
                        <a href="">FQAs</a> -->
                        ©️copyright Horizon Institute | Developed by Abdullah and Zainab
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


{{-- @include("frontPageInclude.footer") --}}
@include("frontPage.footer")
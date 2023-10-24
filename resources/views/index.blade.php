<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZYNN</title>
    <meta name="description"
        content="Stream live sports events online at Fotliv Sports. Enjoy real-time coverage of your favorite games. Join us now for the action!">
    <meta name="keywords"
        content="live sports streaming, watch sports online, live game coverage, sports events streaming">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://myintmyat.dev">
    <link rel="alternate" href="https://myintmyat.dev" hreflang="en">

    <!-- Open Graph (OG) Tags for Social Media Sharing -->
    <meta property="og:title" content="ZYNN">
    <meta property="og:description"
        content="Stream live sports events online at Fotliv Sports. Enjoy real-time coverage of your favorite games. Join us now for the action!">
    <meta property="og:image" content="https://myintmyat.dev/your-image.jpg">
    <meta property="og:url" content="https://myintmyat.dev">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/portfolio.css">
    <script src="https://kit.fontawesome.com/f0be33b496.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fa-solid fa-circle-check me-2" style="color: #07ed2e;"></i>
                <strong class="me-auto">Success</strong>

                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="success_text"></div>
        </div>
    </div>
    <main class="container">

        <nav id="navbar-example2" class="navbar navbar-expand-lg bg-white fixed-top" data-aos="fade-down"
            data-aos-duration="1000" data-aos-easing="ease-out-cubic" data-aos-once="true">
            <div class="container">
                <a class="navbar-brand title_icon" href="#">
                    MMA
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-lg-end" id="navbarNav">
                    <ul class="nav flex-lg-row flex-column nav_style font-Lato">
                        <li class="nav-item">
                            <a id="check_for_ani" class="nav-link px-0 px-lg-3 active" aria-current="page"
                                href="#scrollspyHome">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-0 px-lg-3" href="#scrollspyProjects">PROJECTS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-0 px-lg-3" href="#scrollspyServices">SERVICES</a>
                        </li>
                        {{-- <li class="nav-item">
                        <a class="nav-link px-0 px-lg-3" href="/shop">SHOP</a>
                    </li> --}}
                        <li class="nav-item">
                            <a class="nav-link px-0 px-lg-3" href="#scrollspyCONTACT">CONTACT</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%"
            data-bs-smooth-scroll="true" class="scrollspy-example p-1 rounded-2" tabindex="0">

            <section style="margin-top: 60px;" class="row row-cols-1 row-cols-lg-2 scrollspy mb-5" id="scrollspyHome">
                <div class="col d-flex justify-content-center align-items-center">
                    <div class="">
                        <div data-aos="fade-right" data-aos-easing="ease-out-cubic" data-aos-duration="1000"
                            data-aos-once="true">
                            <h1 class="text-blue fw-bolder" id="MMA">
                                <div class="mb-0 text-brow" id="hello">Hello, I’m</div>
                                Myint Myat Aung
                            </h1>
                        </div>
                        <div class="rounded-circle d-flex justify-content-center align-items-center d-lg-none text-center my-4"
                            data-aos="zoom-in" data-aos-duration="1100" data-aos-easing="ease-out-cubic"
                            data-aos-once="true">
                            <div class="home_img_sm d-flex align-items-center p-0">
                                <img src="/img/mma.jpg" class="rounded-circle w-100" alt="err">
                            </div>
                        </div>
                        <div class="">
                            <h5 class="font" data-aos="fade-right" data-aos-duration="1200" data-aos-once="true"
                                data-aos-easing="ease-out-cubic">A <span class="text-blue">Web Developer </span> from
                                <span class="text-blue">Myanmar</span>
                            </h5>
                            <div class="intro-content fw-medium">
                                <div class="col-md-8 col-12 text-brown auto_animate" style="font-size: 1rem;"
                                    data-aos="fade-right" data-aos-duration="1300" data-aos-easing="ease-out-cubic"
                                    data-aos-once="true">
                                    I'm a passionate web developer based in Myanmar. With a strong
                                    foundation in web
                                    development,
                                    I bring a creative and solution-oriented approach to every project.
                                    <div class="collapse mt-2" id="collapseExample">
                                        My skills and experience include:
                                        <div class="m-2">
                                            <span class="d-flex">
                                                - <p class="ms-1">Front-end development using HTML, CSS, Bootstrap,
                                                    JavaScript and
                                                    Jquery</p>
                                            </span>
                                            <span class="d-flex">
                                                - <p class="ms-1">Back-end development with PHP, Laravel, NodeJs and
                                                    MySQL
                                                </p>
                                            </span>
                                            <span class="d-flex">
                                                - <p class="ms-1">Responsive web design </p>
                                            </span>
                                            <span class="d-flex">
                                                - <p class="ms-1">Building web applications and websites </p>
                                            </span>
                                            <span class="d-flex">
                                                - <p class="ms-1">Integration of third-party APIs </p>
                                            </span>
                                            <span class="d-flex">
                                                - <p class="ms-1">Collaborating with cross-functional teams </p>
                                            </span>
                                            <span class="d-flex">
                                                - <p class="ms-1">Problem-solving and debugging </p>
                                            </span>
                                        </div>
                                        I'm dedicated to creating interactive and user-friendly web experiences that
                                        meet
                                        the unique needs of clients and users. My portfolio includes a variety of
                                        projects
                                        that showcase my expertise, from e-commerce websites to dynamic web
                                        applications.
                                        <br><br>
                                        Let's work together to bring your ideas to life. Feel free to reach out to
                                        discuss
                                        potential collaborations or if you have any questions about my work.
                                    </div>
                                    <a id="see_more" onclick="toggleText(event)" class="text-dark"
                                        data-bs-toggle="collapse" href="#collapseExample" role="button"
                                        aria-expanded="false" aria-controls="collapseExample">See more</a>
                                </div>
                            </div>
                        </div>
                        <div class="btn-home mt-3 auto_animate" data-aos="fade-right" data-aos-duration="1000"
                            data-aos-easing="ease-out-cubic" data-aos-once="true">
                            <a href="#scrollspyServices"
                                class="btn btn-info text-white rounded-pill bg_style-blue p-2 px-3 font-Lato">SERVICES</a>
                            <a href="#scrollspyCONTACT"
                                class="btn rounded-pill p-2 px-3 ms-3 text-blue font-Lato">CONTACT</a>
                        </div>
                    </div>
                </div>
                <div style="height: 90vh;" class="col d-lg-flex justify-content-center align-items-center d-none">
                    <div class="rounded-circle home_img text-center" data-aos="zoom-in" data-aos-duration="1100"
                        data-aos-easing="ease-out-cubic">
                        <img src="/img/mma.jpg" class="rounded-circle h-100" alt="err">
                    </div>
                </div>
            </section>

            <section class="mb-5" id="scrollspyProjects">
                <div class="d-flex flex-column align-items-center mb-4">
                    <h2 class="" data-aos="zoom-in-down">PROJECTS</h2>
                    <div style="height: 3px; width: 310px; opacity: 0.3;" class="bg_style-blue" data-aos="zoom-in">
                    </div>
                </div>
                <div class="card-group row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                    <div class="col" data-aos="fade-up">
                        <div class="card shadow-sm h-100 m-lg-3 border-0">
                            <iframe class="card-img-top w-100" style="min-height: 200px;"
                                src="https://www.youtube.com/embed/4s9BFiCKRNA"
                                title="E-commerce Website with Laravel" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                            <div class="card-body">
                                <h5 class="card-title">E-commerce</h5>
                                <p class="card-text">
                                    I crafted this e-commerce website using a powerful tech stack, including HTML, CSS,
                                    Bootstrap, jQuery, Laravel,
                                    <span class="collapse" id="e-commerce">
                                        and MySQL. This online shopping platform is designed to offer a seamless and feature-rich
                                        shopping experience. Customers can browse a wide range of products, add items to
                                        their cart, and securely complete their purchases.
                                    </span>
                                    <a id="see_more" onclick="toggleText(event)" class="text-dark"
                                        data-bs-toggle="collapse" href="#e-commerce" role="button"
                                        aria-expanded="false" aria-controls="e-commerce">See more</a>
                                </p>
                                <a href="#scrollspyCONTACT"
                                    class="btn btn-info text-white bg_style-blue p-2 px-3 font-Lato">CONTACT ME</a>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-aos="fade-up">
                        <div class="card shadow-sm h-100 m-lg-3 border-0">
                                <iframe class="card-img-top w-100" style="min-height: 200px;" src="https://www.youtube.com/embed/SdG_Nmt5r-g" title="Football Admin Panel" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            <div class="card-body">
                                <h5 class="card-title">Football AdminPanel</h5>
                                <p class="card-text">
                                    The Football Admin Panel plays a crucial role in our live football app. As part of a
                                    dedicated team effort,
                                    <span class="collapse" id="ftadminpanel">
                                        we've created this dynamic admin panel to manage various aspects of live
                                        football events. With features like match scheduling, live score updates, and
                                        real-time statistics, it empowers users to stay informed and engaged during live
                                        matches. If you're looking to enhance the live football experience, this admin
                                        panel is your go-to solution. If you're interested in a football app, you can <a
                                            href="#" data-bs-toggle="modal"
                                            data-bs-target="#contact-him">contact him</a>.
                                    </span>
                                    <a id="see_more" onclick="toggleText(event)" class="text-dark"
                                        data-bs-toggle="collapse" href="#ftadminpanel" role="button"
                                        aria-expanded="false" aria-controls="ftadminpanel">See more</a>
                                </p>
                                </p>
                                <a href="#scrollspyCONTACT"
                                    class="btn btn-info text-white bg_style-blue p-2 px-3 font-Lato">CONTACT ME</a>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-aos="fade-up">
                        <div class="card shadow-sm h-100 m-lg-3 border-0">

                                <iframe class="card-img-top w-100" style="min-height: 200px;" src="https://www.youtube.com/embed/_F6BLt8-sqc" title="Quiz game" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

                            <div class="card-body">
                                <h5 class="card-title">Quiz game</h5>
                                <p class="card-text">
                                    The Quiz Game is a collaborative effort between my cousin and me. He focused on
                                    frontend development,

                                    <span class="collapse" id="quiz-game">
                                        while I handled the backend. This project was built using HTML, CSS, Bootstrap,
                                        jQuery, NodeJs, and MySQL. Now I am writing admin panel.
                                        The result is an interactive and educational quiz game that challenges your
                                        knowledge across various topics. Test your wits and have fun while learning!
                                    </span>
                                    <a id="see_more" onclick="toggleText(event)" class="text-dark"
                                        data-bs-toggle="collapse" href="#quiz-game" role="button"
                                        aria-expanded="false" aria-controls="quiz-game">See more</a>
                                </p>
                                <a href="#scrollspyCONTACT"
                                    class="btn btn-info text-white bg_style-blue p-2 px-3 font-Lato">CONTACT ME</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-5" id="scrollspyServices">
                <div class="d-flex flex-column align-items-center mb-4">
                    <h2 class="" data-aos="zoom-in-down">SERVICES</h2>
                    <div style="height: 3px; width: 310px; opacity: 0.3;" class="bg_style-blue" data-aos="zoom-in">
                    </div>
                </div>
                <div class="card-group row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                    <div class="col" data-aos="fade-up">
                        <div class="card shadow-sm h-100 m-lg-3 border-0 py-4">
                            <div class="d-flex justify-content-center">
                                <div class="circle-div">
                                    <img src="/img/web.png" alt="">
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <h3 class="card-title text-center fw-medium">WEBSITES</h3>
                                <p class="card-text text-center fw-medium">
                                    Crafting visually stunning and functional websites for a seamless user experience.
                                    From personal blogs to e-commerce sites, we've got you covered.
                                </p>
                                <div class="d-flex justify-content-center">
                                    <a href="#scrollspyCONTACT"
                                        class="btn btn-info text-white bg_style-blue p-2 px-3 font-Lato">CONTACT ME</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-aos="fade-up">
                        <div class="card shadow-sm h-100 m-lg-3 border-0 py-4">
                            <div class="d-flex justify-content-center">
                                <div class="circle-div">
                                    <img src="/img/mobile.png" alt="">
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <h3 class="card-title text-center fw-medium">APPLICATIONS</h3>
                                <p class="card-text text-center fw-medium">
                                    Building intuitive and efficient applications to meet your specific needs. We
                                    specialize in creating user-friendly mobile apps that deliver exceptional results.
                                </p>
                                <div class="d-flex justify-content-center">
                                    <button type="button"
                                        class="btn btn-info text-white bg_style-blue p-2 px-3 font-Lato"
                                        data-bs-toggle="modal" data-bs-target="#contact-him">
                                        CONTACT HIM
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" data-aos="fade-up">
                        <div class="card shadow-sm h-100 m-lg-3 border-0 py-4">
                            <div class="d-flex justify-content-center">
                                <div class="circle-div">
                                    <img src="/img/web.png" alt="">
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <h3 class="card-title text-center fw-medium">NULL</h3>
                                <p class="card-text text-center fw-medium">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, sint tenetur saepe nemo eum officia unde voluptates itaque suscipit architecto consectetur </p>
                                <div class="d-flex justify-content-center">
                                    <a href="#scrollspyCONTACT"
                                        class="btn btn-info text-white bg_style-blue p-2 px-3 font-Lato">CONTACT ME</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="" id="scrollspyCONTACT">
                <div class="title d-flex flex-row align-items-center">
                    <div style="height: 3px;" class="col-md-2 col-1 bg_style-blue d-lg-block d-none"
                        data-aos="flip-right" data-aos-duration="1100"></div>
                    <h1 class="px-2" data-aos="zoom-in" data-aos-duration="1100">Content Me</h1>
                    <div style="height: 3px;" class="col-md-7 col-8 bg_style-blue d-lg-block d-none"
                        data-aos="flip-left" data-aos-duration="1100"></div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 my-4">
                    <div class="col text-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom"
                        data-aos-duration="1100">
                        <div class="d-flex justify-content-center">
                            <div class="rounded-circle shadow-lg">
                                <i class="fa-solid fa-phone-flip p-3 text-blue"></i>
                            </div>
                        </div>
                        <h3 class="mt-2">Phone Number</h3>
                        <div class="d-flex flex-column">
                            <span class="fw-semibold">+09 451825950</span>
                            <span class="fw-semibold">+09 451825950</span>
                        </div>
                    </div>
                    <div class="col text-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom"
                        data-aos-duration="1100">
                        <div class="d-flex justify-content-center">
                            <div class="rounded-circle shadow-lg">
                                <i class="fa-solid p-3 text-blue fa-envelope"></i>
                            </div>
                        </div>
                        <h3 class="mt-2">Mail Address</h3>
                        <div class="d-flex flex-column">
                            <span class="fw-semibold">myam6552@gmail.com</span>
                            <span class="fw-semibold">mr.myintmyat.dev@gmail.com</span>
                        </div>
                    </div>
                    <div class="col text-center" data-aos="fade-up" data-aos-anchor-placement="top-bottom"
                        data-aos-duration="1100">
                        <div class="d-flex justify-content-center">
                            <div class="rounded-circle shadow-lg">
                                <i class="fa-solid p-3 text-blue fa-user"></i>
                            </div>
                        </div>
                        <h3 class="mt-2">Accounts</h3>
                        <div class="d-flex flex-column">
                            <a href="https://t.me/zynn_80" class="fw-semibold text-black">Telegram Account</a>
                            <a href="https://www.facebook.com/profile.php?id=100046213381464"
                                class="fw-semibold text-black">Facebook Account</a>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column align-items-center mb-4" data-aos="zoom-in-up">
                    <h3 class="fw-normal">Send Message</h3>
                    <div style="height: 2px; width: 250px; opacity: 0.3;" class="bg_style-blue">
                    </div>
                </div>

                <div>
                    <form id="messageForm" class="row g-3">
                        @csrf
                        <div class="col-md-6" data-aos="fade-right" data-aos-duration="1100">
                            <input type="text" name="name" required
                                class="form-control rounded-pill p-2 px-4 text-blue" id="sed_msg_input"
                                placeholder="Your Full Name" aria-label="Your Full Name">
                        </div>
                        <div class="col-md-6" data-aos="zoom-in-left" data-aos-duration="1100">
                            <input type="text" name="email_or_phone" required
                                class="form-control rounded-pill p-2 px-4 text-blue" id="sed_msg_input"
                                placeholder="Your Email Address Or Phone Number"
                                aria-label="Your Email Address Or Phone Number">
                        </div>
                        <div class="col-12" data-aos="fade-right" data-aos-duration="1100">
                            <input type="text" name="subject" required
                                class="form-control rounded-pill p-3 px-4 text-blue" id="sed_msg_input"
                                placeholder="Subject..." aria-label="Subject...">
                        </div>
                        <div class="col-12" data-aos="zoom-in-left" data-aos-duration="1100">
                            <textarea required name="message" class="form-control rounded-4 p-3 px-4 text-blue" id="sed_msg_input"
                                placeholder="Message..." aria-label="Message..." rows="4"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" data-aos="zoom-in-right" data-aos-duration="1100"
                                class="btn btn-primary bg_style-blue rounded-3 p-2 px-3 border-0">Send
                                Message</button>
                        </div>
                    </form>
                </div>
            </section>

        </div>

        <footer class="mt-5">
            <h2 class="fs-6 mb-0">Copyright © <span class="text-blue">2023</span></h2>
        </footer>
    </main>
    <div class="modal fade" id="contact-him" tabindex="-1" aria-labelledby="contact-himLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="contact-himLabel">Contact Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column p-1">
                    <a href="https://www.facebook.com/ht3tmyat.dev" class="shadow-sm p-3 col-12 text-decoration-none">
                        <i class="fab fa-facebook text-primary"></i> Contact from Facebook
                    </a>
                    <a href="https://t.me/htetmyat1288" class="shadow-sm p-3 col-12 text-decoration-none">
                        <i class="fab fa-telegram text-primary"></i> Contact from Telegram
                    </a>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleText(event) {
            const link = event.target;
            if (link.textContent === "See more") {
                link.textContent = "See less";
            } else {
                link.textContent = "See more";
            }
        }
        $(document).ready(function() {


            function toast_show(text) {
                const toastTrigger = document.getElementById('liveToastBtn')
                const toastLiveExample = document.getElementById('liveToast')
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                $("#success_text").text(text)
                toastBootstrap.show()
            }
            // if (toastTrigger) {

            //   toastTrigger.addEventListener('click', () => {
            //   })
            // }
            $("#messageForm").submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Serialize the form data
                var formData = $(this).serialize();

                // Send a POST request
                $.ajax({
                    type: "POST",
                    url: "{{ route('send_message') }}",
                    data: formData,
                    success: function(response) {
                        toast_show(response.Done);
                        $("#messageForm")[0].reset();
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
            });
            // const firstScrollSpyEl = document.querySelector('[data-bs-spy="scroll"]')
            // firstScrollSpyEl.addEventListener('activate.bs.scrollspy', () => {
            //     const checkForAni = document.getElementById("check_for_ani");
            //     const isActive = checkForAni.classList.contains("active");

            //     if (isActive) {
            //         setTimeout(() => {
            //             console.log("ll")
            //             $("#auto_animate").addClass("aos-animate");
            //         }, 500);
            //     }
            // })


            var autoani = $(".auto_animate");
            for (let i = 0; i < autoani.length; i++) {
                autoani.eq(i).addClass("aos-animate");
            }

            var isContentVisible = false;

            // $("#toggleButton").click(function() {
            //     isContentVisible = !isContentVisible;

            //     if (isContentVisible) {
            //         $(".intro-content p:nth-child(1)").hide();
            //         $(".intro-content div").show();
            //         $(this).text("Read Less");
            //     } else {
            //         $(".intro-content p:nth-child(1)").show();
            //         $(".intro-content div").hide();
            //         $(this).text("See More");
            //     }
            // });
        });
    </script>
</body>

</html>

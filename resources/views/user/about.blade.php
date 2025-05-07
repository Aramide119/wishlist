@extends('partials.home')
@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <a href="" class="cta-button">Get to know about mywishlist</a>
            <h1 class="section-title mt-4">Our Story</h1>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <p class="text-muted">
                        At mywishlist.ng, we’re passionate about making birthdays unforgettable. Frustrated by the hassle of duplicate gifts and the 
                        stress of planning the perfect celebration, we created a platform that puts the power back in your hands. Our mission is simple: 
                        to simplify the gifting process so you can focus on celebrating what matters most.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="mission-vision-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="section-badge">Our Vision & Values </div>
                    <h2 class="section-text">Our Mission</h2>
                    <ul class="list-unstyled">
                        <li>
                          <strong>Innovation:</strong> We continuously enhance our platform to provide the best user experience.
                        </li>
                        <li>
                          <strong>Simplicity:</strong> Easy-to-use tools mean you spend less time planning and more time celebrating.
                        </li>
                        <li>
                          <strong>Community:</strong> We foster a supportive community where users and partners come together for memorable celebrations.
                        </li>
                      </ul>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset ('images/Our-Mission.png')}}" alt="Target with arrows" class="target-image">
                </div>
            </div>
        </div>
    </section>


    <!-- FAQ Section -->
<section class="faq-section">
    <h2 class="faq-title">Got Questions? We've Got Answers</h2>
    <p class="faq-intro">Have questions? We're here to help! In this section, we've compiled answers to some of the most frequently asked questions to provide you with the information you need.</p>
    
    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    What is my Wishlist.ng?
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p>mywishlist.ng is an online platform dedicated to helping you create and share your birthday wish list, making the gift-giving process simple and stress-free.</p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    How do i create a wishlist?
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p>Simply sign up, click ‘Create New List,’ and start adding items from your favorite stores or local vendors. Our user-friendly interface guides you every step of the way.</p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    How can i share my wishlist?
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p>After creating your list, use our built-in sharing tools to send it via email, WhatsApp, or directly on social media. You control who sees your list and when.</p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    How can i share my wishlist?
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p>After creating your list, use our built-in sharing tools to send it via email, WhatsApp, or directly on social media. You control who sees your list and when.</p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    What if someone purchases a gift?
                </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p>“Our real-time tracking feature marks the purchased items, ensuring that you don’t receive duplicate gifts. You and your loved ones will always know what’s been fulfilled.”</p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    Is there a cost to use platform?
                </button>
            </h2>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p>We offer a free version with essential features. For enhanced customization, advanced tracking, and an ad-free experience, check out our premium subscription options.</p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSeven">
                <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                    How do i get support?
                </button>
            </h2>
            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p>Visit our Contact page or click on the support icon for assistance. We’re here to help you every step of the way.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="free-banner">
    <div class="container">
        <h2 class="free-title">Totally free - and it always will be</h2>
        <p class="free-description">Your Ultimate Wishlist, Made Simple Building the perfect gift list has never been easier! With mywishlist, you can add items from any store, big or small, and create a wishlist that's as unique as you are.</p>
        <button class="btn btn-second" id="btn-second">Create Wishlist <i class="fas fa-arrow-circle-right"></i></button>

        <div class="row mt-5">
            <div class="col-12">
                <div class="second-section-image-wrapper">
                    <img src="{{ asset('images/Group-1.png')}}" alt="Birthday celebration with family and friends" class="second-section-image">
                </div>
            </div>
        </div>
    </div>
    
</section>

@endsection
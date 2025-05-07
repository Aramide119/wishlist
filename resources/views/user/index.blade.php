@extends('partials.home')
@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <h1 class="hero-title">Make <span>Birthdays</span> Extra Special! </h1>
                <p class="hero-subtitle">Create, Share and Enjoy your Personalized Birthday Wishlist. Stress-free gifting at your fingertips!</p>
                <a href="{{ route('create.wishlist')}}" class="btn btn-primary" id="btn">Create Wishlist</a>
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/banner.png')}}" alt="Wishlist Illustration">
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <h2 class="section-title">Key Benefits</h2>
            <div class="steps-container">
                <div class="step-card">
                    <div class="step-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <h3 class="step-title">1. Effortless List Creation</h3>
                    <p class="step-desc">Quickly add items from your favorite retailer.</p>
                </div>
                <div class="step-card">
                    <div class="step-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <h3 class="step-title">2. Seamless Sharing</h3>
                    <p class="step-desc">Easily send your list via email, social media or messaging</p>
                </div>
                <div class="step-card">
                    <div class="step-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h3 class="step-title">3. Duplicating Free Gifting</h3>
                    <p class="step-desc">Track purchase to avoid receiving the same gift, twice.</p>
                </div>
                <div class="step-card">
                    <div class="step-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h3 class="step-title">4. Personalized Experience</h3>
                    <p class="step-desc">Customize your list with themes and photos that reflect you</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Section -->
<section class="second-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="second-section-title">Your Ultimate Wishlist, Made Simple</h1>
            </div>
            <div class="col-lg-6">
                <p class="second-section-text">
                    At my Wishlist.ng, we believe every birthday should be memorable. Our 
                    platform helps you build wish list with ease. Share it with friends and family, 
                    and ensure you get exactly what you truly desire- without the guess work.
                </p>
                <a href="{{ route('create.wishlist')}}" class="btn btn-second" id="btn-second">Create Wishlist <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-12">
                <div class="second-section-image-wrapper">
                    <img src="{{ asset('images/ultimate-banner.png')}}" alt="Birthday celebration with family and friends" class="second-section-image">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="highlighted-section">
    <div class="container">
        <h2 class="section-title">Highlighted Features</h2>
        <p class="section-description">
            These features are designed to enhance user convenience, streamline interactions, and offer a personalized
            touch, ensuring a seamless and enjoyable journey.
        </p>
        
        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <h3 class="feature-title">Personalized Wish Lists</h3>
                    <p class="feature-description">
                        Create a customized list that reflects your style and interests. Add images, descriptions,
                        and priorities for each item.
                    </p>
                </div>
            </div>
            
            <!-- Feature 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-share-nodes"></i>
                    </div>
                    <h3 class="feature-title">Easy Sharing & Social Integration</h3>
                    <p class="feature-description">
                        Share your list with a simple link or through social media integrations. Our platform makes
                        it effortless for friends and family to see what you truly want.
                    </p>
                </div>
            </div>
            
            <!-- Feature 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                    <h3 class="feature-title">Real-Time Gift Tracking</h3>
                    <p class="feature-description">
                        Avoid duplicate gifts with our live tracking system that updates as items are purchased.
                    </p>
                </div>
            </div>
            
            <!-- Feature 4 -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <h3 class="feature-title">Affiliate & Retail Integration</h3>
                    <p class="feature-description">
                        Seamlessly add items from popular online stores. Our partnerships ensure a smooth
                        purchasing experience.
                    </p>
                </div>
            </div>
            
            <!-- Feature 5 -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-palette"></i>
                    </div>
                    <h3 class="feature-title">Customizable Themes</h3>
                    <p class="feature-description">
                        Personalize your wish list with different layouts and themes to match your personality
                        and celebration style.
                    </p>
                </div>
            </div>
            
            <!-- Feature 6 -->
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </div>
                    <h3 class="feature-title">Mobile Friendly</h3>
                    <p class="feature-description">
                        Access and update your wish list on any device—whether you're at home or on the go.
                    </p>
                </div>
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
        <a href="{{ route('create.wishlist')}}" class="btn btn-second" id="btn-second">Create Wishlist <i class="fas fa-arrow-circle-right"></i></a>

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
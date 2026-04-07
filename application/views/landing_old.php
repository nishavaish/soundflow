<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SoundFlow - Digital Music Distribution</title>

    <!-- Tailwind via CDN (remove if you're using your own compiled CSS) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Optional: tweak scroll behavior for older browsers */
        html {
            scroll-behavior: smooth;
        }
    </style>
	
	<style>
    .text-primary-custom { color: #ff531a !important; }
    .bg-primary-custom { background-color: #ff531a !important; }
    .bg-primary-custom:hover { background-color: #e64611 !important; } /* darker hover */
    .border-primary-custom { border-color: #ff531a !important; }
</style>

</head>
<body class="min-h-screen bg-black text-white">
    <!-- Header -->
    <header class="border-b border-zinc-800/30 backdrop-blur-sm sticky top-0 z-50 bg-black/95">
        <div class="container mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <!-- Music Icon -->
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-custom/20 text-primary-custom">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18V5l12-2v13" />
                        <circle cx="6" cy="18" r="3" />
                        <circle cx="18" cy="16" r="3" />
                    </svg>
                </span>
                <span class="text-2xl font-bold">
                    SoundFlow
                </span>
            </div>
            <nav class="hidden md:flex items-center gap-8 text-sm">
                <a 
                    href="#why-soundflow"
                    class="hover:text-primary-custom transition-colors cursor-pointer"
                >
                    WHY SOUNDFLOW
                </a>
                <a 
                    href="#music-publishing"
                    class="hover:text-primary-custom transition-colors cursor-pointer"
                >
                    MUSIC PUBLISHING
                </a>
                <a 
                    href="#artist-services"
                    class="hover:text-primary-custom transition-colors cursor-pointer"
                >
                    ARTIST SERVICES
                </a>
                <a  href="#resources"
                    class="hover:text-primary-custom transition-colors cursor-pointer"
                >
                    RESOURCES
                </a>
            </nav>
            <div class="flex items-center gap-3">
                <a href="<?php echo site_url('login') ?>">
                    <button class="px-4 py-2 rounded-full text-sm border border-transparent hover:border-zinc-700 text-white hover:text-primary-custom transition-colors">
                        Login
                    </button>
                </a>
                <a href="<?php echo site_url('register') ?>">
                    <button class="bg-primary-custom text-white hover:bg-primary-custom rounded-full px-6 py-2 text-sm font-medium transition-colors">
                        Get Started
                    </button>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="container mx-auto px-4 py-20 text-center">
        <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
            Digital <span class="text-primary-custom">Music Distribution</span> Services
        </h1>
        <p class="text-lg md:text-xl text-gray-400 mb-8 max-w-3xl mx-auto">
            Sell your music online &amp; keep 100% of your rights. Distribute your music to over 150+ digital stores including Spotify, Apple Music, TikTok, YouTube and more. Starting at $22.99/year.
        </p>
        <a href="/register">
            <button class="bg-primary-custom text-white hover:bg-primary-custom rounded-full text-lg px-10 py-4 md:py-6 font-semibold transition-colors">
                Get Started For Artists
            </button>
        </a>
    </section>

    <!-- Unlimited Distribution -->
    <section class="bg-zinc-900/50 py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                <span class="text-primary-custom">Unlimited Distribution</span> Starting at $22.99/year
            </h2>
            <p class="text-lg text-gray-400 mb-8 max-w-3xl mx-auto">
                Get your music on all major streaming platforms and digital stores worldwide. Keep 100% of your sales revenue, 100% of your rights, and 100% control of your music career.
            </p>
            
            <!-- Platform Logos -->
            <div class="flex flex-wrap justify-center items-center gap-8 mb-8 opacity-80">
                <div class="text-2xl font-bold">Spotify</div>
                <div class="text-2xl font-bold">Apple Music</div>
                <div class="text-2xl font-bold">YouTube</div>
                <div class="text-2xl font-bold">Amazon</div>
                <div class="text-2xl font-bold">Tidal</div>
                <div class="text-2xl font-bold">Beatport</div>
            </div>

            <a href="/register">
                <button class="bg-primary-custom text-white hover:bg-primary-custom rounded-full px-8 py-3 text-sm md:text-base font-medium transition-colors">
                    Start Distribution
                </button>
            </a>
        </div>
    </section>

    <!-- What is SoundFlow -->
    <section class="container mx-auto px-4 py-20 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">
            What is <span class="text-primary-custom">SoundFlow</span>?
        </h2>
        <p class="text-xl text-primary-custom mb-6">Your Independent Music Distribution Company</p>
        <p class="text-lg text-gray-400 mb-8 max-w-4xl mx-auto">
            We offer a suite of features to help content creators distribute, monetize and market their work through cutting-edge video subscription, pay-per-view, digital downloads, rentals and more. We help empower independent artists take control of their own careers without compromising their creative control or sacrificing a share of their revenues to major labels.
        </p>
        <p class="text-lg text-gray-400 mb-8 max-w-4xl mx-auto">
            As a pioneer in independent music distribution, SoundFlow helps artists, labels and managers sell their music online while retaining 100% of their sales revenue and rights for a low annual flat fee.
        </p>
        <a href="/register">
            <button class="bg-primary-custom text-white hover:bg-primary-custom rounded-full px-8 py-3 text-sm md:text-base font-medium transition-colors">
                Get Started For Artists
            </button>
        </a>
    </section>

    <!-- Why Choose SoundFlow -->
    <section id="why-soundflow" class="bg-zinc-900/50 py-20">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
                <div class="flex justify-center">
                    <div class="bg-gradient-to-br from-blue-500/20 to-purple-500/20 p-8 rounded-2xl">
                        <div class="bg-zinc-900 rounded-xl p-6 w-64">
                            <div class="aspect-square bg-gradient-to-br from-blue-600 to-purple-500 rounded-lg mb-4 flex items-center justify-center">
                                <!-- Play Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-black" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </div>
                            <div class="space-y-2 text-left">
                                <div class="h-2 bg-zinc-800 rounded w-3/4"></div>
                                <div class="h-2 bg-zinc-800 rounded w-1/2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-left">
                    <h2 class="text-4xl md:text-5xl font-bold mb-4">
                        Why <span class="text-primary-custom">Choose SoundFlow</span>
                    </h2>
                    <p class="text-xl text-primary-custom mb-6">Best Choice of Music Distribution Companies</p>
                    <ul class="space-y-3 mb-8">
                        <!-- Each feature -->
                        <li class="flex items-start gap-3">
                            <!-- Check Icon -->
                            <span class="mt-0.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary-custom/20 text-primary-custom flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                            </span>
                            <span class="text-gray-400">No upfront cost - 100% of royalties earned</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary-custom/20 text-primary-custom flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                            </span>
                            <span class="text-gray-400">Distribute as much music as you want per year for one low annual fee</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary-custom/20 text-primary-custom flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                            </span>
                            <span class="text-gray-400">Get on 150+ stores around the world including Spotify, Apple Music, TikTok and more</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary-custom/20 text-primary-custom flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                            </span>
                            <span class="text-gray-400">Keep 100% control and 100% of your music rights</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary-custom/20 text-primary-custom flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                            </span>
                            <span class="text-gray-400">Eligible to collect YouTube's Content ID and YouTube Music earnings</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary-custom/20 text-primary-custom flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                            </span>
                            <span class="text-gray-400">Covers, remixes and audio samples (more options than our competitors)</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary-custom/20 text-primary-custom flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6L9 17l-5-5" />
                                </svg>
                            </span>
                            <span class="text-gray-400">Live customer support from music industry pros</span>
                        </li>
                    </ul>
                    <a href="/register">
                        <button class="bg-primary-custom text-white hover:bg-primary-custom rounded-full px-8 py-3 text-sm md:text-base font-medium transition-colors">
                            Get Started
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stream & Distribute -->
    <section id="music-publishing" class="container mx-auto px-4 py-20 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">
            Stream &amp; Distribute <span class="text-primary-custom">Your Music</span> Without a Label
        </h2>
        <p class="text-xl mb-6">Sell Your Music. Online Worldwide.</p>
        <p class="text-lg text-gray-400 mb-8 max-w-4xl mx-auto">
            Whether it's Spotify, Apple Music, Amazon Music, Tidal, iTunes, Deezer or any of 150+ stores around the world, we'll get your music heard. As a digital music distribution service, SoundFlow allows artists to get music on Spotify, Apple Music, Amazon Music and stream &amp; sell your music online. Release singles, EPs &amp; albums to the world's leading digital platforms, keep 100% of your sales revenue. Get music on TikTok and YouTube to maximize your exposure &amp; earnings.
        </p>
        <a href="/pricing">
            <button class="bg-primary-custom text-white hover:bg-primary-custom rounded-full px-8 py-3 text-sm md:text-base font-medium transition-colors">
                View Pricing
            </button>
        </a>
    </section>

    <!-- Features Grid -->
    <section id="features" class="bg-zinc-900/50 py-20">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <!-- Feature 1 -->
                <div class="bg-black/50 border border-zinc-800 rounded-lg p-6 hover:border-primary-custom/50 transition-all">
                    <!-- Globe Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="2" y1="12" x2="22" y2="12" />
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Global Distribution</h3>
                    <p class="text-gray-400">Reach 150+ streaming platforms worldwide</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-black/50 border border-zinc-800 rounded-lg p-6 hover:border-primary-custom/50 transition-all">
                    <!-- Dollar Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a2.5 2.5 0 0 0 0 5H14a2.5 2.5 0 0 1 0 5H6" />
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Keep 100% Earnings</h3>
                    <p class="text-gray-400">All royalties go directly to you</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-black/50 border border-zinc-800 rounded-lg p-6 hover:border-primary-custom/50 transition-all">
                    <!-- Trending Up Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                        <polyline points="17 6 23 6 23 12" />
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Real-Time Analytics</h3>
                    <p class="text-gray-400">Track your music performance live</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-black/50 border border-zinc-800 rounded-lg p-6 hover:border-primary-custom/50 transition-all">
                    <!-- Music Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18V5l12-2v13" />
                        <circle cx="6" cy="18" r="3" />
                        <circle cx="18" cy="16" r="3" />
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Unlimited Uploads</h3>
                    <p class="text-gray-400">Release as much music as you want</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Artist Services -->
    <section id="artist-services" class="bg-black py-20">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-16">
                <h2 class="text-5xl md:text-6xl font-bold mb-4">Artist Services</h2>
                <p class="text-lg text-gray-400 max-w-3xl mx-auto">
                    Whichever stage you're at in your music career, we've got the tools you need to better connect with new listeners and existing fans.
                </p>
            </div>

            <!-- Release Tracker -->
            <div class="grid md:grid-cols-2 gap-12 items-center max-w-6xl mx-auto mb-20">
                <div class="flex justify-center">
                    <div class="bg-gradient-to-br from-blue-500/20 to-purple-500/20 p-8 rounded-3xl">
                        <div class="bg-zinc-900 rounded-2xl p-6 w-72">
                            <div class="aspect-[3/4] bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                <!-- Music Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-black" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 18V5l12-2v13" />
                                    <circle cx="6" cy="18" r="3" />
                                    <circle cx="18" cy="16" r="3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-left">
                    <h3 class="text-4xl md:text-5xl font-bold mb-4">
                        Track Your Release Status with SoundFlow <span class="text-primary-custom">Release Tracker</span>
                    </h3>
                    <p class="text-gray-400 mb-4">
                        You pour your blood, sweat, and tears into writing and recording a song. You upload it to streaming services. You wait for it to appear online with little to no feedback, until now.
                    </p>
                    <p class="text-gray-400 mb-6">
                        Introducing SoundFlow Release Tracker
                    </p>
                    <button class="bg-primary-custom text-white hover:bg-primary-custom rounded-full px-8 py-3 text-sm md:text-base font-medium transition-colors">
                        HERE'S HOW IT WORKS
                    </button>
                </div>
            </div>

            <!-- Collaboration -->
            <div class="grid md:grid-cols-2 gap-12 items-center max-w-6xl mx-auto mb-20">
                <div class="text-left">
                    <h3 class="text-4xl md:text-5xl font-bold mb-4">
                        The Power of <span class="text-primary-custom">Collaboration</span>
                    </h3>
                    <p class="text-xl font-semibold mb-4">with SoundFlow Splits</p>
                    <p class="text-gray-400 mb-4">
                        It's time for all of your collaborators to get paid easily. Split streaming &amp; download royalties between all contributors on any track or album.
                    </p>
                    <p class="text-gray-400 mb-6">
                        Bredda! Artists, Rising Artists, and Pro get Splits free, with no commission fees.
                    </p>
                    <button class="bg-primary-custom text-white hover:bg-primary-custom rounded-full px-8 py-3 text-sm md:text-base font-medium transition-colors">
                        REGISTER YOUR SPLITS
                    </button>
                </div>
                <div class="flex justify-center">
                    <div class="grid grid-cols-2 gap-4 w-full max-w-xs">
                        <div class="aspect-square bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg"></div>
                        <div class="aspect-square bg-gradient-to-br from-indigo-500 to-green-500 rounded-lg"></div>
                        <div class="aspect-square bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg"></div>
                        <div class="aspect-square bg-gradient-to-br from-green-500 to-blue-500 rounded-lg"></div>
                    </div>
                </div>
            </div>

            <!-- Prepare Your Music -->
            <div class="mb-20">
                <h3 class="text-4xl md:text-5xl font-bold text-center mb-4">Prepare Your Music</h3>
                <p class="text-center text-gray-400 mb-12 max-w-4xl mx-auto">
                    Take all of the steps you need to succeed before you send your next release to stores. If you need feedback, mastering and more, we've got you covered.
                </p>
                <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <!-- Card 1 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Music Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18V5l12-2v13" />
                                <circle cx="6" cy="18" r="3" />
                                <circle cx="18" cy="16" r="3" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">Studio One</h4>
                        <p class="text-gray-400 text-sm">
                            An easy-to-use creative toolbox with a platform for artists to record, mixing, and mastering music.
                        </p>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Check Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">Cover Song Licensing</h4>
                        <p class="text-gray-400 text-sm">
                            Get cover song licensing in just over 24hrs! (typically) Release covers you've already distributed all at once.
                        </p>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Trending Up Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                                <polyline points="17 6 23 6 23 12" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">SoundFlow Mastering</h4>
                        <p class="text-gray-400 text-sm">
                            Instantly master your tracks with AI-powered mastering technology.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Get Ready To Sell -->
            <div class="mb-20">
                <h3 class="text-4xl md:text-5xl font-bold text-center mb-4">Get Ready To Sell Your Music</h3>
                <p class="text-center text-gray-400 mb-12 max-w-4xl mx-auto">
                    Make sure you're covered before your next release goes live - stock up on merch for your live shows, design your artist website, and start collecting money when your music is played on YouTube.
                </p>
                <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <!-- Card 1 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Play Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">YouTube</h4>
                        <p class="text-gray-400 text-sm">
                            Collect money every time someone uses your music on YouTube.
                        </p>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Globe Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">Meta</h4>
                        <p class="text-gray-400 text-sm">
                            Get your music on the world's two most popular social media platforms. Each as Facebook and Instagram.
                        </p>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Music Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18V5l12-2v13" />
                                <circle cx="6" cy="18" r="3" />
                                <circle cx="18" cy="16" r="3" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">CD Duplication</h4>
                        <p class="text-gray-400 text-sm">
                            Have physical copies of your music to sell at your next live show.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Promote Your Music -->
            <div>
                <h3 class="text-4xl md:text-5xl font-bold text-center mb-4">Promote Your Music</h3>
                <p class="text-center text-gray-400 mb-12 max-w-4xl mx-auto">
                    Make sure your music gets heard once it's live in stores. Promote your music to new listeners, get your songs spinning on internet radio, and connect with fans on social media.
                </p>
                <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <!-- Card 1 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Trending Up Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                                <polyline points="17 6 23 6 23 12" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">Feature.fm</h4>
                        <p class="text-gray-400 text-sm">
                            Get customized fan landing pages on your website from your fanbase links. Get listed w/ license coverage &amp; get guaranteed feedback.
                        </p>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Music Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18V5l12-2v13" />
                                <circle cx="6" cy="18" r="3" />
                                <circle cx="18" cy="16" r="3" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">Radio airplay</h4>
                        <p class="text-gray-400 text-sm">
                            Promote your songs on advertised short-paid posts and stories to reach your people!
                        </p>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Play Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">Rotor</h4>
                        <p class="text-gray-400 text-sm">
                            Create amazing videos, ads, &amp; promo videos in minutes, not to great music videos you need!
                        </p>
                    </div>
                    <!-- Card 4 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Music Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18V5l12-2v13" />
                                <circle cx="6" cy="18" r="3" />
                                <circle cx="18" cy="16" r="3" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">Groover</h4>
                        <p class="text-gray-400 text-sm">
                            Provide your music to radio, blogs, record labels, playlist curators &amp; magazines. Get listed w/ license coverage &amp; get guaranteed feedback.
                        </p>
                    </div>
                    <!-- Card 5 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Globe Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="2" y1="12" x2="22" y2="12" />
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">Bandsintown For Artists</h4>
                        <p class="text-gray-400 text-sm">
                            Your portal to the world's best fans on live music's largest discovery platform with RSVP, venue &amp; publish tour dates across your fans.
                        </p>
                    </div>
                    <!-- Card 6 -->
                    <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-6 text-center">
                        <div class="h-16 flex items-center justify-center mb-4">
                            <!-- Trending Up Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary-custom" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                                <polyline points="17 6 23 6 23 12" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold mb-3">Playlist Push</h4>
                        <p class="text-gray-400 text-sm">
                            Grow your audience with its guest playlist campaign to Spotify.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="container mx-auto px-4 py-20">
        <h2 class="text-4xl md:text-5xl font-bold text-center mb-16">
            What Are <span class="text-primary-custom">Artists</span> Saying About SoundFlow?
        </h2>
        <div class="max-w-4xl mx-auto">
            <div class="bg-zinc-900 border border-zinc-800 rounded-2xl p-8 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full mx-auto mb-6"></div>
                <p class="text-lg text-gray-400 mb-4 italic">
                    "SoundFlow helped me manage my content online the way I wanted and it's been instrumental in supporting my streaming platforms, concert ticket sales, merchandise and more. SoundFlow can work for you no matter where you're at in your music career"
                </p>
                <p class="font-bold text-xl">Independent Artist</p>
                <p class="text-primary-custom">Verified User</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="resources" class="bg-gradient-to-r from-blue-500/20 to-purple-500/20 py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">
                Ready to <span class="text-primary-custom">Start Your Music Career</span>?
            </h2>
            <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                Join thousands of independent artists who trust SoundFlow to distribute their music worldwide.
            </p>
            <a href="/register">
                <button class="bg-primary-custom text-white hover:bg-primary-custom rounded-full text-lg px-10 py-4 md:py-6 font-semibold transition-colors">
                    Get Started Now
                </button>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-zinc-800/30 py-12 bg-zinc-900/30">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold mb-4">About</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-primary-custom transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Press</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Support</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Services</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Music Distribution</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Music Publishing</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Artist Services</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold mb-4">Legal</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-primary-custom transition-colors">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-gray-500 text-sm pt-8 border-t border-zinc-800/30">
                <p>&copy; 2025 SoundFlow. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll Script (for older browsers that don't support CSS scroll-behavior well) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('a[href^="#"]');
            links.forEach(function (link) {
                link.addEventListener('click', function (e) {
                    const targetId = this.getAttribute('href').substring(1);
                    const target = document.getElementById(targetId);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>

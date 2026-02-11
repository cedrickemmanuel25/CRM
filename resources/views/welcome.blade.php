<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ company_name() }} - CRM Professionnel</title>
    <link rel="icon" type="image/png" href="{{ company_logo() }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=3">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com/css2">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .gradient-primary {
            background: linear-gradient(135deg, #2563EB 0%, #1E40AF 100%);
        }
        
        .gradient-accent {
            background: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%);
        }
        
        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.15);
        }
        
        .nav-glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        .blob {
            background: linear-gradient(180deg, #2563EB 0%, #1E40AF 100%);
            opacity: 0.08;
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
            animation: blob-animation 12s ease-in-out infinite;
        }
        
        @keyframes blob-animation {
            0%, 100% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
            25% { border-radius: 60% 40% 50% 70% / 60% 30% 70% 40%; }
            50% { border-radius: 70% 30% 40% 60% / 50% 60% 30% 60%; }
            75% { border-radius: 40% 60% 60% 40% / 70% 30% 50% 60%; }
        }
    </style>
</head>
<body class="bg-gray-50" x-data="{ mobileMenuOpen: false }">
    <!-- Navigation -->
    <nav class="fixed w-full top-0 z-50 transition-all duration-300 nav-glass shadow-sm" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2 sm:space-x-3">
                        <img src="{{ company_logo() }}" alt="{{ company_name() }} Logo" class="h-8 sm:h-10 w-auto">
                        <span class="text-lg sm:text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">{{ company_name() }}</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#fonctionnalites" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Fonctionnalités</a>
                    <a href="#avantages" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Avantages</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Contact</a>
                </div>
                
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 sm:px-6 py-2 sm:py-2.5 gradient-primary text-white rounded-lg font-semibold hover:shadow-lg transition-all transform hover:-translate-y-0.5 text-sm sm:text-base">
                            Mon Espace
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-semibold transition-colors text-sm sm:text-base">Connexion</a>
                        <a href="{{ route('access.request') }}" class="px-4 sm:px-6 py-2 sm:py-2.5 gradient-primary text-white rounded-lg font-semibold hover:shadow-lg transition-all transform hover:-translate-y-0.5 text-sm sm:text-base">
                            Créer un compte
                        </a>
                    @endauth
                </div>
                
                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="md:hidden bg-white border-t border-gray-200 shadow-lg">
                <div class="py-3 px-4 space-y-2">
                    <a href="#fonctionnalites" @click="mobileMenuOpen = false" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors">Fonctionnalités</a>
                    <a href="#avantages" @click="mobileMenuOpen = false" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors">Avantages</a>
                    <a href="#contact" @click="mobileMenuOpen = false" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors">Contact</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-4 py-2.5 gradient-primary text-white rounded-lg font-semibold text-center shadow-sm">Mon Espace</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 rounded-lg font-semibold transition-colors">Connexion</a>
                        <a href="{{ route('access.request') }}" class="block px-4 py-2.5 gradient-primary text-white rounded-lg font-semibold text-center shadow-sm">Créer un compte</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 sm:pt-32 pb-12 sm:pb-20 px-4 relative overflow-hidden">
        <div class="blob absolute top-0 right-0 w-64 sm:w-96 h-64 sm:h-96"></div>
        <div class="blob absolute bottom-0 left-0 w-56 sm:w-80 h-56 sm:h-80" style="animation-delay: -6s;"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid lg:grid-cols-2 gap-8 sm:gap-12 items-center">
                <div class="space-y-6 sm:space-y-8">
                    <div class="inline-flex items-center space-x-2 bg-blue-50 border border-blue-200 rounded-full px-3 sm:px-4 py-1.5 sm:py-2">
                        <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                        <span class="text-xs sm:text-sm font-semibold text-blue-700">Solution CRM Professionnelle</span>
                    </div>
                    
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-black text-gray-900 leading-tight">
                        Gérez votre entreprise
                        <span class="bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">intelligemment</span>
                    </h1>
                    
                    <p class="text-base sm:text-lg lg:text-xl text-gray-600 leading-relaxed">
                        Une plateforme complète pour piloter votre activité commerciale, gérer vos contacts et optimiser vos processus de vente.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="group px-6 sm:px-8 py-3 sm:py-4 gradient-primary text-white rounded-xl text-base sm:text-lg font-bold hover:shadow-2xl transition-all transform hover:-translate-y-1 inline-flex items-center justify-center">
                                Accéder à mon espace
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('access.request') }}" class="group px-6 sm:px-8 py-3 sm:py-4 gradient-primary text-white rounded-xl text-base sm:text-lg font-bold hover:shadow-2xl transition-all transform hover:-translate-y-1 inline-flex items-center justify-center">
                                Commencer gratuitement
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                            <a href="{{ route('login') }}" class="px-6 sm:px-8 py-3 sm:py-4 bg-white border-2 border-gray-200 text-gray-700 rounded-xl text-base sm:text-lg font-bold hover:border-blue-600 hover:text-blue-600 transition-all inline-flex items-center justify-center">
                                Se connecter
                            </a>
                        @endauth
                    </div>
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-6 pt-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-xs sm:text-sm text-gray-600 font-medium">Sans engagement</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-xs sm:text-sm text-gray-600 font-medium">Configuration rapide</span>
                        </div>
                    </div>
                </div>
                
                <div class="relative float-animation hidden lg:block">
                    <div class="gradient-primary rounded-3xl p-8 shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-500">
                        <div class="bg-white rounded-2xl p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="h-4 bg-blue-200 rounded w-1/3"></div>
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                                </div>
                            </div>
                            <div class="h-40 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl flex items-center justify-center">
                                <svg class="w-20 h-20 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div class="space-y-3">
                                <div class="h-3 bg-gray-200 rounded w-full"></div>
                                <div class="h-3 bg-gray-200 rounded w-4/5"></div>
                                <div class="h-3 bg-gray-200 rounded w-3/5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent mb-2">98%</div>
                    <div class="text-gray-600 font-medium">Satisfaction client</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent mb-2">5k+</div>
                    <div class="text-gray-600 font-medium">Entreprises actives</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent mb-2">-70%</div>
                    <div class="text-gray-600 font-medium">Temps de gestion</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-black bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent mb-2">24/7</div>
                    <div class="text-gray-600 font-medium">Support disponible</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fonctionnalites" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16 space-y-4">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900">Tout ce dont vous avez besoin</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Des fonctionnalités puissantes et intuitives pour développer votre activité</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Gestion des Contacts</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Centralisez tous vos contacts, suivez l'historique des interactions et segmentez votre base clients efficacement.
                    </p>
                </div>

                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="w-14 h-14 gradient-accent rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Pipeline Commercial</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Visualisez vos opportunités, suivez leur progression et optimisez votre taux de conversion avec des outils avancés.
                    </p>
                </div>

                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Rapports & Analytics</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Prenez des décisions éclairées grâce à des tableaux de bord personnalisables et des rapports détaillés en temps réel.
                    </p>
                </div>

                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="w-14 h-14 gradient-accent rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Gestion des Tâches</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Organisez votre travail, assignez des tâches à votre équipe et ne manquez plus jamais une échéance importante.
                    </p>
                </div>

                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Notifications Intelligentes</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Restez informé en temps réel des événements importants et personnalisez vos préférences de notification.
                    </p>
                </div>

                <div class="feature-card bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                    <div class="w-14 h-14 gradient-accent rounded-xl flex items-center justify-center mb-6 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Sécurité Avancée</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Vos données sont protégées avec un chiffrement de niveau entreprise et des contrôles d'accès granulaires.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="avantages" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900">Pourquoi choisir notre CRM ?</h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 gradient-primary rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Interface Intuitive</h3>
                                <p class="text-gray-600 leading-relaxed">Prise en main immédiate sans formation complexe. Design moderne et ergonomique pensé pour la productivité.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 gradient-accent rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Performance Optimale</h3>
                                <p class="text-gray-600 leading-relaxed">Temps de chargement ultra-rapides et synchronisation en temps réel pour une expérience fluide.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 gradient-primary rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Support Dédié</h3>
                                <p class="text-gray-600 leading-relaxed">Une équipe d'experts disponible 24/7 pour vous accompagner et répondre à toutes vos questions.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="gradient-primary rounded-3xl p-8 shadow-2xl">
                        <div class="bg-white rounded-2xl p-6 space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 text-center">
                                    <div class="text-4xl font-black text-blue-600 mb-2">+45%</div>
                                    <div class="text-sm text-gray-600 font-medium">Productivité</div>
                                </div>
                                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 text-center">
                                    <div class="text-4xl font-black text-blue-600 mb-2">-60%</div>
                                    <div class="text-sm text-gray-600 font-medium">Temps admin</div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-700">Contacts gérés</span>
                                    <span class="text-sm font-bold text-blue-600">12,450</span>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-700">Opportunités actives</span>
                                    <span class="text-sm font-bold text-cyan-600">847</span>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <span class="text-sm font-medium text-gray-700">Taux de conversion</span>
                                    <span class="text-sm font-bold text-green-600">68%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 gradient-primary relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-5"></div>
        <div class="max-w-4xl mx-auto text-center px-4 relative z-10">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Prêt à transformer votre gestion commerciale ?
            </h2>
            <p class="text-xl text-blue-100 mb-10 leading-relaxed">
                Rejoignez des milliers d'entreprises qui optimisent leur performance avec notre solution
            </p>
            @auth
                <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-10 py-5 bg-white text-blue-600 rounded-xl text-lg font-bold hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    Accéder au tableau de bord
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('access.request') }}" class="inline-flex items-center px-10 py-5 bg-white text-blue-600 rounded-xl text-lg font-bold hover:shadow-2xl transition-all transform hover:-translate-y-1">
                    Créer mon compte maintenant
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">{{ company_name() }}</span>
                    </div>
                    <p class="text-sm leading-relaxed">La solution CRM complète pour gérer et développer votre activité commerciale efficacement.</p>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-4">Produit</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#fonctionnalites" class="hover:text-white transition-colors">Fonctionnalités</a></li>
                        <li><a href="#avantages" class="hover:text-white transition-colors">Avantages</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tarifs</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Sécurité</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-4">Entreprise</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">À propos</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Carrières</a></li>
                        <li><a href="#contact" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-4">Support</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tutoriels</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-sm">&copy; 2026 {{ company_name() }}. Tous droits réservés.</p>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="hover:text-white transition-colors">Mentions légales</a>
                    <a href="#" class="hover:text-white transition-colors">Confidentialité</a>
                    <a href="#" class="hover:text-white transition-colors">CGU</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- iOS Install Guide Modal -->
    <div id="ios-install-modal" class="fixed inset-0 z-[60] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                    <div>
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                            <img src="{{ company_logo() }}" alt="App Icon" class="h-8 w-8 rounded-lg">
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Installer {{ company_name() }} sur iPhone</h3>
                            <div class="mt-2 text-left">
                                <p class="text-sm text-gray-500 mb-4">Suivez ces étapes simples :</p>
                                <ol class="text-sm text-gray-600 list-decimal pl-5 space-y-3">
                                    <li>Appuyez sur le bouton <strong>Partager</strong> <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Apple_Share_Icon.png/1200px-Apple_Share_Icon.png" class="inline h-5 w-5 mx-1 align-baseline" alt="Share"> en bas de votre écran.</li>
                                    <li>Faites défiler vers le bas et appuyez sur <strong>"Sur l'écran d'accueil"</strong> <svg class="inline h-5 w-5 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>.</li>
                                    <li>Appuyez sur <strong>Ajouter</strong> en haut à droite.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="button" onclick="document.getElementById('ios-install-modal').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Compris</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Android/Generic Install Guide Modal -->
    <div id="android-install-modal" class="fixed inset-0 z-[60] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                    <div>
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                            <img src="{{ company_logo() }}" alt="App Icon" class="h-8 w-8 rounded-lg">
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Installer {{ company_name() }}</h3>
                            <div class="mt-2 text-left">
                                <p class="text-sm text-gray-500 mb-4">Si l'installation automatique ne démarre pas :</p>
                                <ol class="text-sm text-gray-600 list-decimal pl-5 space-y-3">
                                    <li>Appuyez sur le menu du navigateur (<strong>⋮</strong> ou <strong>☰</strong>).</li>
                                    <li>Cherchez l'option <strong>"Installer l'application"</strong> ou <strong>"Ajouter à l'écran d'accueil"</strong>.</li>
                                    <li>Suivez les instructions à l'écran.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="button" onclick="document.getElementById('android-install-modal').classList.add('hidden')" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Compris</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PWA Install Button Mobile (Welcome Page Specific) -->
    <div id="pwa-install-btn-mobile-welcome" class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-50 hidden md:hidden">
        <button onclick="installPWAWithModal()" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-full shadow-xl text-base font-bold transition-transform hover:scale-105 animate-bounce">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Installer l'App
        </button>
    </div>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('nav-glass', 'shadow-lg');
            } else {
                navbar.classList.remove('nav-glass', 'shadow-lg');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register("{{ asset('service-worker.js') }}");
            });
        }

        // PWA Robust Install Logic (Welcome Page)
        let deferredPrompt;
        const installBtnWelcome = document.getElementById('pwa-install-btn-mobile-welcome');
        const iosModal = document.getElementById('ios-install-modal');
        const androidModal = document.getElementById('android-install-modal');

        const isIos = () => /iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
        const isMobile = () => /android|iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
        const isInStandaloneMode = () => ('standalone' in window.navigator && window.navigator.standalone) || (window.matchMedia('(display-mode: standalone)').matches);

        function installPWAWithModal() {
            if (isIos()) {
                iosModal.classList.remove('hidden');
            } else {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        deferredPrompt = null;
                        if(installBtnWelcome) installBtnWelcome.style.display = 'none';
                    });
                } else {
                    androidModal.classList.remove('hidden');
                }
            }
        }

        // Always show button on mobile if not standalone
        if (isMobile() && !isInStandaloneMode() && installBtnWelcome) {
            installBtnWelcome.style.display = 'flex';
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
        });
    </script>
</body>
</html>


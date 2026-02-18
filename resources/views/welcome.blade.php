<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ company_name() }} | CRM Professionnel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;500;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root { --accent: #3b82f6; --neon: #00f2ff; --bg: #030712; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg); color: white; overflow-x: hidden; }

        .glass {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        @media (max-width: 380px) {
            .xs\:inline { display: none; }
        }

        .bento-card {
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
            border-radius: 2rem;
        }

        .bento-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
            background: rgba(59, 130, 246, 0.08);
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, var(--bg) 0%, transparent 100%);
            opacity: 0.7;
            z-index: 1;
        }

        #bg-canvas { position: fixed; top: 0; left: 0; z-index: -1; }
    </style>
</head>
<body class="selection:bg-cyan-500 selection:text-white">

    <canvas id="bg-canvas"></canvas>

    <nav x-data="{ open: false }" class="fixed w-full z-50 transition-all border-b border-white/5 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-10 py-4 sm:py-6 flex justify-between items-center">
            <div class="flex items-center gap-2 sm:gap-4 group cursor-pointer">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-xl flex items-center justify-center rotate-3 group-hover:rotate-12 transition-transform">
                    <img src="{{ company_logo() }}" class="w-6 sm:w-8 brightness-0 invert">
                </div>
                <span class="text-base sm:text-xl font-extrabold tracking-tighter uppercase truncate max-w-[120px] sm:max-w-none">{{ company_name() }}</span>
            </div>
            
            <div class="hidden lg:flex gap-10 text-[11px] font-bold uppercase tracking-widest text-slate-400">
                <a href="#features" class="hover:text-cyan-400 transition-colors">Fonctionnalités</a>
                <a href="#modules" class="hover:text-cyan-400 transition-colors">Modules</a>
                <a href="#security" class="hover:text-cyan-400 transition-colors">Sécurité</a>
            </div>

            <div class="flex items-center gap-2 sm:gap-4 font-bold">
                <!-- PWA Install Button Mobile (Always visible if PWA available) -->
                <button id="pwa-install-btn-mobile" style="display: none;" class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-500/20 transform active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Télécharger
                </button>

                <!-- Desktop Auth Buttons -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-white text-slate-950 rounded-full text-xs uppercase hover:bg-cyan-400 transition-all font-black">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs text-white hover:text-cyan-400 transition-colors">Connexion</a>
                        <a href="{{ route('access.request') }}" class="px-6 py-2.5 bg-white text-slate-950 rounded-full text-xs uppercase hover:bg-cyan-400 transition-all font-black">Demander l'Accès</a>
                    @endauth
                </div>

                <!-- Hamburger Button (Mobile) -->
                <button @click="open = !open" class="md:hidden flex items-center justify-center w-10 h-10 rounded-xl bg-white/5 border border-white/10 text-white hover:bg-white/10 transition-all">
                    <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="md:hidden glass border-t border-white/5 overflow-hidden" style="display: none;">
            <div class="px-6 py-8 space-y-6">
                <div class="flex flex-col gap-4 text-[11px] font-bold uppercase tracking-widest text-slate-400 pb-6 border-b border-white/5">
                    <a href="#features" @click="open = false" class="hover:text-cyan-400 transition-colors">Fonctionnalités</a>
                    <a href="#modules" @click="open = false" class="hover:text-cyan-400 transition-colors">Modules</a>
                    <a href="#security" @click="open = false" class="hover:text-cyan-400 transition-colors">Sécurité</a>
                </div>
                <div class="flex flex-col gap-4 pt-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="w-full py-4 bg-white text-slate-950 rounded-2xl text-center text-xs font-black uppercase tracking-widest shadow-xl">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full py-4 glass text-white rounded-2xl text-center text-xs font-bold uppercase tracking-widest border border-white/10">Connexion</a>
                        <a href="{{ route('access.request') }}" class="w-full py-4 bg-blue-600 text-white rounded-2xl text-center text-xs font-black uppercase tracking-widest shadow-xl shadow-blue-500/20">Demander l'Accès</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-48 pb-20 px-10">
        <div class="max-w-7xl mx-auto flex flex-col items-center text-center">
            <div class="reveal inline-flex items-center gap-2 px-4 py-2 rounded-full glass border-white/10 mb-8">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                </span>
                <span class="text-[10px] font-bold tracking-widest uppercase text-cyan-400">Plateforme Professionnelle</span>
            </div>
            
            <h1 class="reveal text-5xl sm:text-7xl lg:text-[110px] font-extrabold leading-tight lg:leading-none tracking-tighter mb-8">
                CRM <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-cyan-300">Intelligent</span>
            </h1>
            
            <p class="reveal text-sm sm:text-lg text-slate-400 max-w-2xl mb-12 px-4 sm:px-0">
                Gérez vos contacts, opportunités et pipelines de vente avec une plateforme CRM moderne. Centralisez vos données clients et boostez vos performances commerciales.
            </p>

            <div class="reveal flex flex-col sm:flex-row gap-4 w-full sm:w-auto px-10 sm:px-0">
                <a href="{{ route('access.request') }}" class="px-8 sm:px-12 py-4 sm:py-5 bg-blue-600 rounded-2xl font-bold shadow-2xl shadow-blue-500/40 hover:scale-105 transition-transform text-sm sm:text-base">Démarrer Maintenant</a>
                <a href="#features" class="px-8 sm:px-12 py-4 sm:py-5 glass rounded-2xl font-bold hover:bg-white/5 transition-colors text-sm sm:text-base">Découvrir</a>
            </div>
        </div>
    </section>

    <section id="features" class="max-w-7xl mx-auto px-10 py-32">
        <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-6 h-auto md:h-[850px]">
            
            <!-- Gestion des Contacts -->
            <div class="md:col-span-2 md:row-span-2 bento-card glass relative group overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-transparent to-cyan-500/10"></div>
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 400">
                        <circle cx="200" cy="200" r="150" fill="none" stroke="url(#grad1)" stroke-width="2" opacity="0.3"/>
                        <circle cx="200" cy="200" r="100" fill="none" stroke="url(#grad1)" stroke-width="2" opacity="0.5"/>
                        <circle cx="200" cy="200" r="50" fill="url(#grad1)" opacity="0.3"/>
                        <defs>
                            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#06b6d4;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="image-overlay"></div>
                <div class="relative z-10 p-10 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-blue-500/20 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm border border-blue-400/30">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Gestion Contacts 360°</h3>
                        <p class="text-slate-300 max-w-xs">Centralisez toutes les informations de vos clients et prospects. Historique complet des interactions, notes, documents et communications.</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 glass text-[10px] font-bold uppercase rounded-lg">Temps réel</span>
                        <span class="px-3 py-1 glass text-[10px] font-bold uppercase rounded-lg">Historique</span>
                    </div>
                </div>
            </div>

            <!-- Pipeline de Vente -->
            <div class="md:col-span-2 glass bento-card relative group overflow-hidden h-[350px] md:h-auto">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-cyan-500/10 to-transparent"></div>
                <div class="absolute right-0 top-0 w-2/3 h-full opacity-20">
                    <svg class="w-full h-full" viewBox="0 0 300 200">
                        <path d="M 0,100 Q 75,50 150,80 T 300,60" fill="none" stroke="#3b82f6" stroke-width="3" opacity="0.5"/>
                        <path d="M 0,120 Q 75,90 150,110 T 300,100" fill="none" stroke="#06b6d4" stroke-width="3" opacity="0.5"/>
                        <circle cx="75" cy="70" r="8" fill="#3b82f6"/>
                        <circle cx="150" cy="80" r="8" fill="#06b6d4"/>
                        <circle cx="225" cy="60" r="8" fill="#3b82f6"/>
                    </svg>
                </div>
                <div class="absolute inset-0 bg-gradient-to-r from-bg to-transparent z-10"></div>
                <div class="relative z-20 p-10 flex items-center justify-between h-full">
                    <div class="w-2/3">
                        <div class="w-12 h-12 bg-cyan-500/20 rounded-xl flex items-center justify-center mb-4 backdrop-blur-sm border border-cyan-400/30">
                            <svg class="w-7 h-7 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Pipeline de Vente</h3>
                        <p class="text-sm text-slate-400">Suivez vos opportunités à travers chaque étape du cycle commercial. Tableaux Kanban, prévisions et analyses de conversion.</p>
                    </div>
                    <div class="w-24 h-24 bg-cyan-500/10 rounded-full flex items-center justify-center border border-cyan-500/20 backdrop-blur-md">
                        <span class="text-3xl font-black text-cyan-400">+45%</span>
                    </div>
                </div>
            </div>

            <!-- Sécurité -->
            <div class="glass bento-card p-8 flex flex-col justify-center">
                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center mb-4 backdrop-blur-sm border border-blue-400/30">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" stroke-linecap="round"/></svg>
                </div>
                <h4 class="font-bold mb-1">Sécurité Avancée</h4>
                <p class="text-xs text-slate-500">Chiffrement des données et contrôle d'accès par rôles pour protéger vos informations sensibles.</p>
            </div>

            <!-- Rapports -->
            <div class="glass bento-card p-8 flex flex-col justify-center">
                <div class="w-10 h-10 bg-cyan-500/20 rounded-lg flex items-center justify-center mb-4 backdrop-blur-sm border border-cyan-400/30">
                    <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h4 class="font-bold mb-1">Rapports & Analytics</h4>
                <p class="text-xs text-slate-500">Tableaux de bord personnalisables et rapports détaillés pour piloter votre activité.</p>
            </div>

        </div>
    </section>

    <script>
        // --- ANIMATION 3D : Particules ---
        const canvas = document.querySelector('#bg-canvas');
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });

        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);

        const particlesGeometry = new THREE.BufferGeometry();
        const counts = 2500;
        const positions = new Float32Array(counts * 3);

        for(let i = 0; i < counts * 3; i++) {
            positions[i] = (Math.random() - 0.5) * 50;
        }

        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        const particlesMaterial = new THREE.PointsMaterial({
            size: 0.05,
            color: '#3b82f6',
            transparent: true,
            opacity: 0.6
        });

        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);
        camera.position.z = 15;

        let mouseX = 0, mouseY = 0;
        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        function animate() {
            requestAnimationFrame(animate);
            particlesMesh.rotation.y += 0.0008;
            const targetX = (mouseX / window.innerWidth - 0.5) * 2;
            const targetY = (mouseY / window.innerHeight - 0.5) * 2;
            particlesMesh.rotation.x += (targetY - particlesMesh.rotation.x) * 0.02;
            particlesMesh.rotation.y += (targetX - particlesMesh.rotation.y) * 0.02;
            renderer.render(scene, camera);
        }
        animate();

        // --- GSAP REVEAL ---
        gsap.registerPlugin(ScrollTrigger);
        gsap.utils.toArray('.reveal').forEach((el, i) => {
            gsap.from(el, {
                y: 30,
                opacity: 0,
                duration: 1.2,
                delay: i * 0.1,
                ease: "power4.out"
            });
        });

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
    <!-- iOS Install Guide Modal -->
    <div id="ios-install-modal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-[#030712]/90 backdrop-blur-xl transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-[2.5rem] bg-[#0f172a] px-4 pb-4 pt-5 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-8 border border-white/10">
                    <div>
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-600/10 border border-blue-500/20">
                            <img src="{{ company_logo() }}" alt="App Icon" class="h-10 w-10 brightness-0 invert">
                        </div>
                        <div class="mt-6 text-center">
                            <h3 class="text-lg font-black text-white uppercase tracking-tight" id="modal-title">Installer {{ company_name() }} sur iPhone</h3>
                            <div class="mt-4 text-left space-y-4">
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest opacity-60 text-center">Suivez ces étapes simples :</p>
                                <ol class="text-xs text-slate-300 font-medium list-none space-y-4">
                                    <li class="flex items-start gap-3 bg-white/5 p-3 rounded-xl border border-white/5">
                                        <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center font-black text-[10px]">1</span>
                                        <span>Appuyez sur le bouton <strong>Partager</strong> <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Apple_Share_Icon.png/1200px-Apple_Share_Icon.png" class="inline h-5 w-5 mx-1 align-baseline brightness-0 invert opacity-60" alt="Share"> en bas de votre écran.</span>
                                    </li>
                                    <li class="flex items-start gap-3 bg-white/5 p-3 rounded-xl border border-white/5">
                                        <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center font-black text-[10px]">2</span>
                                        <span>Faites défiler vers le bas et appuyez sur <strong>"Sur l'écran d'accueil"</strong> <svg class="inline h-5 w-5 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>.</span>
                                    </li>
                                    <li class="flex items-start gap-3 bg-white/5 p-3 rounded-xl border border-white/5">
                                        <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center font-black text-[10px]">3</span>
                                        <span>Appuyez sur <strong>Ajouter</strong> en haut à droite.</span>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="button" onclick="document.getElementById('ios-install-modal').classList.add('hidden')" class="w-full inline-flex justify-center rounded-xl bg-blue-600 px-4 py-3 text-xs font-black text-white uppercase tracking-[0.2em] shadow-lg shadow-blue-500/20 hover:bg-blue-500 transition-all active:scale-95">Compris</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Android/Generic Install Guide Modal -->
    <div id="android-install-modal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-[#030712]/90 backdrop-blur-xl transition-opacity"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-[2.5rem] bg-[#0f172a] px-4 pb-4 pt-5 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-8 border border-white/10">
                    <div>
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-600/10 border border-blue-500/20">
                            <img src="{{ company_logo() }}" alt="App Icon" class="h-10 w-10 brightness-0 invert">
                        </div>
                        <div class="mt-6 text-center">
                            <h3 class="text-lg font-black text-white uppercase tracking-tight" id="modal-title">Installer {{ company_name() }}</h3>
                            <div class="mt-4 text-left space-y-4">
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest opacity-60 text-center">Si l'installation automatique ne démarre pas :</p>
                                <ol class="text-xs text-slate-300 font-medium list-none space-y-4">
                                    <li class="flex items-start gap-3 bg-white/5 p-3 rounded-xl border border-white/5">
                                        <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center font-black text-[10px]">1</span>
                                        <span>Appuyez sur le menu du navigateur (<strong>⋮</strong> ou <strong>☰</strong>).</span>
                                    </li>
                                    <li class="flex items-start gap-3 bg-white/5 p-3 rounded-xl border border-white/5">
                                        <span class="flex-shrink-0 w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center font-black text-[10px]">2</span>
                                        <span>Cherchez l'option <strong>"Installer l'application"</strong> ou <strong>"Ajouter à l'écran d'accueil"</strong>.</span>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="button" onclick="document.getElementById('android-install-modal').classList.add('hidden')" class="w-full inline-flex justify-center rounded-xl bg-blue-600 px-4 py-3 text-xs font-black text-white uppercase tracking-[0.2em] shadow-lg shadow-blue-500/20 hover:bg-blue-500 transition-all active:scale-95">Compris</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register("{{ asset('service-worker.js') }}");
            });
        }

        // PWA Proactive Install Logic
        let deferredPrompt;
        const installBtnMobile = document.getElementById('pwa-install-btn-mobile');
        const iosModal = document.getElementById('ios-install-modal');
        const androidModal = document.getElementById('android-install-modal');

        const isIos = () => /iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
        const isMobile = () => /android|iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
        const isInStandaloneMode = () => ('standalone' in window.navigator && window.navigator.standalone) || (window.matchMedia('(display-mode: standalone)').matches);

        function triggerInstall() {
            if (isIos()) {
                // iPhone: Show steps guide
                iosModal.classList.remove('hidden');
            } else {
                // Android & Others: Direct native prompt ONLY
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            if (installBtnMobile) installBtnMobile.style.display = 'none';
                        }
                        deferredPrompt = null;
                    });
                } else {
                    // Strictly NO guide for Android as per user request
                    console.log('Installation prompt not yet triggered by browser');
                }
            }
        }

        // Auto-detect standalone and hide
        if (isInStandaloneMode() && installBtnMobile) {
            installBtnMobile.style.display = 'none';
        }

        // Always show button on mobile if not standalone
        if (isMobile() && !isInStandaloneMode() && installBtnMobile) {
            installBtnMobile.style.display = 'flex';
            installBtnMobile.onclick = triggerInstall;
        }

        // Capture event and immediately bind to button for direct action
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (installBtnMobile) {
                installBtnMobile.onclick = triggerInstall;
            }
        });

        // Hide button when installed
        window.addEventListener('appinstalled', (evt) => {
            console.log('App successfully installed');
            if (installBtnMobile) installBtnMobile.style.display = 'none';
        });
    </script>
</body>
</html>
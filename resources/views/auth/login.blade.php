<!DOCTYPE html>
<html lang="fr" class="h-full bg-[#030712]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - {{ company_name() }}</title>
    <link rel="icon" type="image/png" href="{{ company_logo() }}">
    <link rel="apple-touch-icon" href="{{ company_logo() }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        #bg-canvas {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 0;
            pointer-events: none;
        }
        
        body {
            background-color: #030712 !important;
            overflow: hidden;
        }
        
        .relative.z-10 {
            z-index: 10;
        }

        .glass {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .reveal { opacity: 0; }
    </style>
</head>
<body class="h-full relative overflow-x-hidden overflow-y-auto selection:bg-cyan-500 selection:text-white">
    
    <canvas id="bg-canvas"></canvas>

    <div class="min-h-full flex items-center justify-center p-4 relative z-10">
        <div class="w-full max-w-md reveal">

            <!-- Card -->
            <div class="relative glass rounded-3xl shadow-2xl p-8 overflow-hidden group">
                <!-- Decorative Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 via-transparent to-cyan-500/5 pointer-events-none"></div>
                
                <div class="relative z-10">
                    <div class="text-center mb-6">
                        <img src="{{ company_logo() }}" alt="{{ company_name() }} Logo" class="h-16 w-auto mx-auto mb-4 brightness-0 invert">
                        <h2 class="text-2xl font-extrabold text-white mb-1 uppercase tracking-tighter">Connexion</h2>
                        <p class="text-sm text-slate-400">Entrez vos identifiants pour accéder à votre compte</p>
                    </div>

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error') || $errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                        {{ session('error') ?: $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-1.5">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-white/5 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent bg-white/5 text-white placeholder-slate-500 transition-all font-medium"
                            placeholder="votre@email.com"
                            required
                            autofocus
                        >
                    </div>

                    <div x-data="{ show: false }" class="relative">
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-1.5">Mot de passe</label>
                        <div class="relative">
                            <input 
                                :type="show ? 'text' : 'password'" 
                                name="password"
                                class="w-full px-4 py-3 border border-white/5 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent pr-12 bg-white/5 text-white placeholder-slate-500 transition-all font-medium"
                                placeholder="••••••••"
                                required
                            >
                            <button 
                                type="button" 
                                @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-sm leading-5"
                            >
                                <svg x-show="!show" class="h-5 w-5 text-slate-500 hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="h-5 w-5 text-slate-500 hover:text-white transition-colors" style="display: none;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-white/10 rounded bg-white/5 focus:ring-blue-500/50"
                        >
                        <label for="remember" class="ml-2 text-xs font-bold uppercase tracking-widest text-slate-400 cursor-pointer hover:text-white transition-colors">
                            Rester connecté
                        </label>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:scale-[1.02] transition-all shadow-xl shadow-blue-500/25"
                    >
                        Se connecter
                    </button>
                </form>

                <div class="relative my-6 text-center">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/5"></div>
                    </div>
                    <div class="relative inline-block px-4 bg-transparent text-[10px] font-bold uppercase tracking-widest text-slate-500">
                        ou
                    </div>
                </div>

                <p class="text-center text-xs font-medium text-slate-400">
                    Vous n'avez pas de compte ?
                    <a href="{{ route('access.request') }}" class="text-cyan-400 hover:text-white transition-colors ml-1">
                        Créer un compte
                    </a>
                </p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:text-cyan-400 transition-colors">
                    <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à l'accueil
                </a>

                <!-- PWA Install Button Mobile -->
                <button id="pwa-install-btn-mobile" style="display: none;" class="mt-6 mx-auto flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-500/20 transform active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Installer l'App
                </button>
            </div>
        </div>
    </div>

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
        gsap.utils.toArray('.reveal').forEach((el, i) => {
            gsap.to(el, {
                y: 0,
                opacity: 1,
                duration: 1.2,
                delay: i * 0.1,
                ease: "power4.out",
                startAt: { y: 30, opacity: 0 }
            });
        });

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register("{{ asset('service-worker.js') }}");
            });
        }
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
        // PWA Robust Install Logic
        let deferredPrompt;
        const installBtnMobile = document.getElementById('pwa-install-btn-mobile');
        const iosModal = document.getElementById('ios-install-modal');
        const androidModal = document.getElementById('android-install-modal');

        const isIos = () => /iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
        const isMobile = () => /android|iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());
        const isInStandaloneMode = () => ('standalone' in window.navigator && window.navigator.standalone) || (window.matchMedia('(display-mode: standalone)').matches);

        // Always show button on mobile if not standalone
        if (isMobile() && !isInStandaloneMode() && installBtnMobile) {
            installBtnMobile.style.display = 'flex';
            
            installBtnMobile.onclick = function() {
                if (isIos()) {
                    iosModal.classList.remove('hidden');
                } else {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then(() => {
                            deferredPrompt = null;
                        });
                    } else {
                        androidModal.classList.remove('hidden');
                    }
                }
            };
        }

        // Capture event
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (installBtnMobile) {
                installBtnMobile.onclick = function() {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(() => {
                        deferredPrompt = null;
                    });
                };
            }
        });
    </script>
</body>
</html>


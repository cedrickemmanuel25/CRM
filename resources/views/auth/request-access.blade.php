<!DOCTYPE html>
<html lang="fr" class="h-full bg-[#030712]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Demande d'accès - {{ company_name() }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        .iti { 
            width: 100% !important; 
            direction: ltr !important;
        }
        .iti__flag-container { 
            left: 0 !important; 
            right: auto !important;
        }

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
                    <div class="text-center mb-4">
                        <img src="{{ company_logo() }}" alt="{{ company_name() }} Logo" class="h-14 w-auto mx-auto mb-3 brightness-0 invert">
                        <h2 class="text-xl font-extrabold text-white mb-0.5 uppercase tracking-tighter">Créer un compte</h2>
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Remplissez le formulaire pour demander l'accès</p>
                    </div>

                @if ($errors->any())
                    <div class="mb-4 p-2.5 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-xs font-medium text-red-800 mb-0.5">Erreurs de validation</p>
                        <ul class="text-xs text-red-700 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('access.submit') }}" class="space-y-3">
                    @csrf

                    <!-- Name Fields -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">
                                Prénom
                            </label>
                            <input 
                                type="text" 
                                name="prenom" 
                                required 
                                value="{{ old('prenom') }}"
                                class="w-full px-4 py-2.5 border border-white/5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent bg-white/5 text-white transition-all"
                            >
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">
                                Nom
                            </label>
                            <input 
                                type="text" 
                                name="nom" 
                                required 
                                value="{{ old('nom') }}"
                                class="w-full px-4 py-2.5 border border-white/5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent bg-white/5 text-white transition-all"
                            >
                        </div>
                    </div>

                    <!-- Email & Company -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">
                                Email
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                required 
                                value="{{ old('email') }}"
                                class="w-full px-4 py-2.5 border border-white/5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent bg-white/5 text-white transition-all"
                            >
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">
                                Entreprise
                            </label>
                            <input 
                                type="text" 
                                name="entreprise" 
                                value="{{ old('entreprise') }}"
                                class="w-full px-4 py-2.5 border border-white/5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent bg-white/5 text-white transition-all"
                            >
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">
                            Téléphone
                        </label>
                        <input 
                            type="tel" 
                            id="telephone_input" 
                            class="w-full px-4 py-2.5 border border-white/5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent bg-white/5 text-white transition-all"
                        >
                        <input type="hidden" name="telephone" id="telephone">
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">
                            Rôle souhaité
                        </label>
                        <select 
                            name="role" 
                            required
                            class="w-full px-4 py-2.5 border border-white/5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-transparent bg-white/5 text-white transition-all"
                        >
                            <option value="" class="bg-[#030712]">Sélectionnez un rôle</option>
                            <option value="commercial" class="bg-[#030712]" {{ old('role') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="support" class="bg-[#030712]" {{ old('role') == 'support' ? 'selected' : '' }}>Support</option>
                        </select>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:scale-[1.02] transition-all shadow-xl shadow-blue-500/25"
                    >
                        Envoyer ma demande
                    </button>
                </form>

                <div class="relative my-4 text-center">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/5"></div>
                    </div>
                    <div class="relative inline-block px-4 bg-transparent text-[10px] font-bold uppercase tracking-widest text-slate-500">
                        ou
                    </div>
                </div>

                <p class="text-center text-xs font-medium text-slate-400">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="text-cyan-400 hover:text-white transition-colors ml-1">
                        Se connecter
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
            </div>
        </div>
    </div>

    <script>
        const input = document.querySelector("#telephone_input");
        const hiddenInput = document.querySelector("#telephone");
        const iti = window.intlTelInput(input, {
            initialCountry: "ci",
            onlyCountries: ["ci"],
            countrySearch: false,
            allowDropdown: false,
            showSelectedDialCode: true,
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/utils.js",
        });

        document.querySelector('form').addEventListener('submit', function() {
            hiddenInput.value = iti.getNumber();
        });

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
            particlesMesh.rotation.y += (targetX - particlesMesh.rotation.y) * 0.01;
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
    </script>
</body>
</html>



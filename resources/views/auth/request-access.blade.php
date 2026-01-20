<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Demande d'accès - {{ company_name() }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        .iti { width: 100%; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in { animation: fadeInUp 0.6s ease-out; }
    </style>
</head>
<body class="h-full relative overflow-x-hidden overflow-y-auto">
    
    <div class="min-h-full flex items-center justify-center p-4 relative z-10">
        <div class="w-full max-w-md fade-in">


            <!-- Card -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ company_name() }} Logo" class="h-12 w-auto mx-auto mb-3">
                    <h2 class="text-lg font-bold text-gray-900 mb-0.5">Créer un compte</h2>
                    <p class="text-xs text-gray-500">Remplissez le formulaire pour demander l'accès</p>
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
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Prénom
                            </label>
                            <input 
                                type="text" 
                                name="prenom" 
                                required 
                                value="{{ old('prenom') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Nom
                            </label>
                            <input 
                                type="text" 
                                name="nom" 
                                required 
                                value="{{ old('nom') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>
                    </div>

                    <!-- Email & Company -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                required 
                                value="{{ old('email') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Entreprise
                            </label>
                            <input 
                                type="text" 
                                name="entreprise" 
                                value="{{ old('entreprise') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Téléphone
                        </label>
                        <input 
                            type="tel" 
                            id="telephone_input" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <input type="hidden" name="telephone" id="telephone">
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Rôle souhaité
                        </label>
                        <select 
                            name="role" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            <option value="">Sélectionnez un rôle</option>
                            <option value="commercial" {{ old('role') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="support" {{ old('role') == 'support' ? 'selected' : '' }}>Support</option>
                        </select>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Envoyer ma demande
                    </button>
                </form>

                <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-gray-400">ou</span>
                    </div>
                </div>

                <p class="text-center text-xs text-gray-600">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-700">
                        Se connecter
                    </a>
                </p>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-xs text-gray-500 hover:text-gray-700">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/utils.js",
        });

        document.querySelector('form').addEventListener('submit', function() {
            hiddenInput.value = iti.getNumber();
        });
    </script>
</body>
</html>

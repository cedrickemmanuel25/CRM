<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - {{ company_name() }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        * { font-family: 'Inter', sans-serif; }
        
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
            <div class="bg-white rounded-xl shadow-sm p-8">
                <div class="text-center mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ company_name() }} Logo" class="h-16 w-auto mx-auto mb-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-1">Connexion</h2>
                    <p class="text-sm text-gray-500">Entrez vos identifiants pour accéder à votre compte</p>
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
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder=""
                            required
                            autofocus
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe</label>
                        <input 
                            type="password" 
                            name="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder=""
                            required
                        >
                    </div>

                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            {{ old('remember') ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer">
                            Rester connecté
                        </label>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Se connecter
                    </button>
                </form>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-gray-400">ou</span>
                    </div>
                </div>

                <p class="text-center text-sm text-gray-600">
                    Vous n'avez pas de compte ?
                    <a href="{{ route('access.request') }}" class="font-medium text-blue-600 hover:text-blue-700">
                        Créer un compte
                    </a>
                </p>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</body>
</html>

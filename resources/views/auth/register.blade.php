<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Inscription – Gestion des visites</title>

    <!-- Tailwind (CDN pour prototype rapide) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
            font-size: 24px;
        }
    </style>
</head>
<body class="font-display">
<div class="relative flex h-auto min-h-screen w-full flex-col items-center justify-center bg-background-light dark:bg-background-dark group/design-root overflow-x-hidden p-4 sm:p-6" style='font-family: Inter, "Noto Sans", sans-serif;'>

    <div class="layout-container flex h-full grow flex-col w-full max-w-md">
        <div class="flex flex-col items-center justify-center flex-1">

            <div class="layout-content-container flex flex-col w-full bg-white dark:bg-background-dark dark:border dark:border-white/10 shadow-sm rounded-xl p-6 sm:p-8">

                <div class="flex justify-center mb-6">
                    <div class="w-24 h-8 bg-center bg-no-repeat bg-contain"
                         data-alt="Logo"
                         style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA3IyxQ10_JjgZ0nEwh0FcqRx5275FJJJp6OsXEdcVzAFyt9Dw4Yct_hWTAH4-etsjWDyUfWoAcrcPz3wuj1E6hD5dwO3kOF27ISJuUZH0XOkGXpdjFbkhlHSkVMC3hanGk5SpGgtTZehxICc23eCtq7qMUMTMqknGoccMmqc4XnFTf_VbA1R7Y8ODIuk80-xWKAq7Ijb-Fbzj9JGf3wB8Nnegm91satIfbnBXJCQc7sSWq7qZxDR7i8OvUm_nXKPkuRpDbWjQ5qw");'>
                    </div>
                </div>

                <h1 class="text-[#0d121b] dark:text-white tracking-light text-[28px] font-bold leading-tight px-4 text-center pb-3 pt-4">
                    Créer un compte
                </h1>

                <p class="text-[#0d121b] dark:text-white/80 text-sm text-center mb-4 px-4">
                    Choisissez votre rôle : administrateur ou secrétaire.
                </p>

                <div class="flex flex-col gap-4 px-4 py-1">

                    <!-- Errors -->
                    @if ($errors->any())
                        <div class="rounded-md bg-red-50 border border-red-100 p-3 text-sm text-red-700">
                            <ul class="list-disc pl-5 mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.process') }}" method="POST" class="w-full">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex flex-col w-full">
                                <p class="text-[#0d121b] dark:text-white/80 text-sm font-medium pb-2">Nom</p>
                                <input
                                    name="nom"
                                    type="text"
                                    value="{{ old('nom') }}"
                                    class="form-input rounded-lg border border-[#cfd7e7] bg-[#f8f9fc] h-12 p-3 text-base"
                                    required
                                />
                            </label>

                            <label class="flex flex-col w-full">
                                <p class="text-[#0d121b] dark:text-white/80 text-sm font-medium pb-2">Prénom</p>
                                <input
                                    name="prenom"
                                    type="text"
                                    value="{{ old('prenom') }}"
                                    class="form-input rounded-lg border border-[#cfd7e7] bg-[#f8f9fc] h-12 p-3 text-base"
                                    required
                                />
                            </label>
                        </div>

                        <label class="flex flex-col w-full mt-2">
                            <p class="text-[#0d121b] dark:text-white/80 text-sm font-medium pb-2">Adresse email</p>
                            <input
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                class="form-input rounded-lg border border-[#cfd7e7] bg-[#f8f9fc] h-12 p-3 text-base"
                                required
                            />
                        </label>

                        <label class="flex flex-col w-full mt-2">
                            <p class="text-[#0d121b] dark:text-white/80 text-sm font-medium pb-2">Rôle</p>
                            <select name="role" class="form-select rounded-lg border border-[#cfd7e7] bg-[#f8f9fc] h-12 p-3 text-base" required>
                                <option value="">-- Choisir un rôle --</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                                <option value="secretaire" {{ old('role') === 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                            </select>
                        </label>

                        <label class="flex flex-col w-full mt-2">
                            <p class="text-[#0d121b] dark:text-white/80 text-sm font-medium pb-2">Mot de passe</p>
                            <input
                                name="password"
                                type="password"
                                class="form-input rounded-lg border border-[#cfd7e7] bg-[#f8f9fc] h-12 p-3 text-base"
                                required
                            />
                            <small class="text-gray-500 mt-1">Minimum 8 caractères.</small>
                        </label>

                        <label class="flex flex-col w-full mt-2">
                            <p class="text-[#0d121b] dark:text-white/80 text-sm font-medium pb-2">Confirmer le mot de passe</p>
                            <input
                                name="password_confirmation"
                                type="password"
                                class="form-input rounded-lg border border-[#cfd7e7] bg-[#f8f9fc] h-12 p-3 text-base"
                                required
                            />
                        </label>

                        <div class="flex px-4 py-3 mt-4">
                            <button type="submit" class="flex min-w-[84px] w-full cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-5 flex-1 bg-primary hover:bg-primary/90 text-white text-base font-bold leading-normal tracking-[0.015em] transition-colors">
                                <span class="truncate">S'inscrire</span>
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-2">
                        <small class="text-gray-600">
                            Vous avez déjà un compte ?
                            <a href="{{ route('login.form') }}" class="text-primary hover:underline">Se connecter</a>
                        </small>
                    </div>

                </div>
            </div>

            <div class="text-center mt-6">
                <p class="text-xs text-gray-500 dark:text-gray-400">© {{ date('Y') }} Votre Société. Tous droits réservés.</p>
            </div>

        </div>
    </div>
</div>
</body>
</html>
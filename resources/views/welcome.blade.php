<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Arbella</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            /* Slate 900 */
            overflow: hidden;
        }

        /* Abstract animated background blobs */
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.6;
            animation: float 10s ease-in-out infinite;
        }

        .blob-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: #10b981;
            /* Emerald 500 */
            animation-delay: 0s;
        }

        .blob-2 {
            bottom: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: #3b82f6;
            /* Blue 500 */
            animation-delay: -5s;
        }

        .blob-3 {
            top: 40%;
            left: 40%;
            width: 300px;
            height: 300px;
            background: #6366f1;
            /* Indigo 500 */
            transform: translate(-50%, -50%);
            animation-delay: -2s;
            opacity: 0.4;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0, 0) scale(1);
            }
        }

        /* Glass Card Styles */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Grid Pattern Overlay */
        .grid-pattern {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: -1;
            mask-image: radial-gradient(circle at center, black, transparent 80%);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center relative selection:bg-emerald-500 selection:text-white">

    <div class="grid-pattern"></div>
    <div class="blob blob-1 rounded-full"></div>
    <div class="blob blob-2 rounded-full"></div>
    <div class="blob blob-3 rounded-full"></div>

    <div
        class="glass-card rounded-3xl p-10 md:p-12 w-full max-w-md mx-4 transform transition-all duration-500 hover:scale-[1.01]">

        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-blue-600 shadow-lg mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                    </path>
                </svg>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight mb-2">
                New Atlantic Admin Panel
            </h1>
            <p class="text-slate-400 text-sm md:text-base">
                Secure access for administrators only.
            </p>
        </div>

        <div class="space-y-6">
            <a href="{{ route('login') }}"
                class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-emerald-600 hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 focus:ring-offset-slate-900 transition-all duration-200 shadow-lg hover:shadow-emerald-500/30 overflow-hidden">

                <div
                    class="absolute inset-0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent z-10">
                </div>

                <span class="relative z-20 flex items-center gap-2">
                    Proceed to Login
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </span>
            </a>

            <div class="text-center mt-8 border-t border-slate-700/50 pt-4">
                <p class="text-xs text-slate-300 mb-2">
                    &copy; {{ date('Y') }} Arbella Inc. All rights reserved.
                </p>

                <div class="flex items-center justify-center gap-1.5 text-xs text-slate-300">
                    <span>Developed by</span>

                    <a href="https://www.linkedin.com/in/musa-md-obayed-52aa66251/" target="_blank"
                        class="group inline-flex items-center gap-1 font-medium text-slate-200 hover:text-blue-400 transition-colors duration-300">

                        <svg class="w-3 h-3 fill-current transition-transform group-hover:scale-110" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>

                        <span class="group-hover:underline decoration-blue-400/30 underline-offset-2">Musa Md
                            Obayed</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tailwind config extension for the shimmer animation if needed specifically in JS, 
        // but here we use arbitrary values or standard CSS. 
        // Adding keyframes for the button shimmer
        const styleSheet = document.createElement("style");
        styleSheet.innerText = `
            @keyframes shimmer {
                100% { transform: translateX(100%); }
            }
        `;
        document.head.appendChild(styleSheet);
    </script>
</body>

</html>
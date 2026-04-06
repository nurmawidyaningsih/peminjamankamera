<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Peminjaman Kamera</title>
    
    <link rel="icon" type="image/png" href="{{ asset('assets/img/Avatar.png') }}">

    <!-- Font Awesome 6 (Free) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700;900&family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85), rgba(30, 41, 59, 0.9));
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Background Gambar Kamera Full */
        .camera-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            object-fit: cover;
        }
        
        /* Overlay Gelap agar teks terbaca */
        .overlay-dark {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            z-index: -1;
        }
        
        /* Animated Camera Lens Background */
        .camera-lens {
            position: fixed;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.05);
            animation: rotate 20s linear infinite;
            z-index: -1;
        }
        
        .camera-lens::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 60%;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.05);
        }
        
        .camera-lens::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20%;
            height: 20%;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .lens-1 {
            width: 500px;
            height: 500px;
            top: -200px;
            right: -200px;
        }
        
        .lens-2 {
            width: 400px;
            height: 400px;
            bottom: -150px;
            left: -150px;
            animation-direction: reverse;
            animation-duration: 15s;
        }
        
        /* Floating camera icons */
        .float-icon {
            position: fixed;
            color: rgba(255, 255, 255, 0.05);
            font-size: 3rem;
            animation: float 6s ease-in-out infinite;
            z-index: -1;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .float-1 {
            top: 15%;
            right: 10%;
            animation-delay: 0s;
        }
        
        .float-2 {
            bottom: 20%;
            left: 5%;
            animation-delay: 2s;
            font-size: 4rem;
        }
        
        .float-3 {
            top: 40%;
            left: 15%;
            animation-delay: 4s;
            font-size: 2.5rem;
        }
        
        /* Premium Glass Card */
        .premium-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 32px;
        }
        
        .premium-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 35px 60px -12px rgba(0, 0, 0, 0.6),
                0 0 0 2px rgba(255, 255, 255, 0.2) inset;
        }
        
        /* Camera Logo Container */
        .camera-logo-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            perspective: 1000px;
        }
        
        .camera-logo {
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, #3b82f6, #8b5cf6);
            border-radius: 30px 30px 30px 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 
                0 20px 30px -10px rgba(59, 130, 246, 0.5),
                0 0 0 3px rgba(255, 255, 255, 0.3) inset;
            animation: cameraGlow 3s ease-in-out infinite;
            transform-style: preserve-3d;
            transition: transform 0.5s ease;
        }
        
        .camera-logo:hover {
            transform: rotateY(10deg) rotateX(5deg);
        }
        
        @keyframes cameraGlow {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.2); box-shadow: 0 25px 40px -10px #3b82f6; }
        }
        
        .camera-logo i {
            font-size: 55px;
            color: white;
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.3));
            animation: lensShine 3s ease-in-out infinite;
        }
        
        @keyframes lensShine {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .camera-lens-detail {
            position: absolute;
            width: 35px;
            height: 35px;
            background: linear-gradient(145deg, #ffffff, #e2e8f0);
            border-radius: 50%;
            top: 20px;
            right: 20px;
            border: 3px solid #334155;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.5);
            animation: lensRotate 10s linear infinite;
        }
        
        @keyframes lensRotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .camera-lens-detail::after {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            background: #1e293b;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 2px solid #94a3b8;
        }
        
        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(145deg, #3b82f6, #8b5cf6, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.25rem;
            letter-spacing: -0.5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            animation: titleGlow 3s ease-in-out infinite;
        }
        
        @keyframes titleGlow {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.1); }
        }
        
        .brand-subtitle {
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            font-weight: 500;
            background: linear-gradient(145deg, #64748b, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }
        
        .input-premium {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-premium i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #3b82f6;
            font-size: 1.2rem;
            z-index: 10;
            transition: all 0.3s ease;
        }
        
        .input-premium input {
            width: 100%;
            padding: 18px 20px 18px 55px;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            font-weight: 500;
        }
        
        .input-premium input:focus {
            border-color: #3b82f6;
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3);
            outline: none;
            transform: scale(1.02);
        }
        
        .input-premium input:focus + i {
            color: #8b5cf6;
            transform: translateY(-50%) scale(1.1);
        }
        
        .btn-premium {
            background: linear-gradient(145deg, #3b82f6, #8b5cf6, #ec4899);
            background-size: 200% 200%;
            color: white;
            font-weight: 600;
            padding: 16px 20px;
            border-radius: 20px;
            border: none;
            width: 100%;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 25px -5px rgba(59, 130, 246, 0.5);
            letter-spacing: 1px;
            text-transform: uppercase;
            animation: gradientShift 3s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .btn-premium:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 20px 35px -5px rgba(59, 130, 246, 0.6);
        }
        
        .btn-premium:active {
            transform: translateY(2px) scale(0.98);
        }
        
        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-premium:hover::before {
            left: 100%;
        }
        
        .shutter-effect {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.1s ease;
            z-index: 9999;
        }
        
        .shutter-effect.active {
            opacity: 1;
            animation: shutter 0.2s ease;
        }
        
        @keyframes shutter {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }
        
        .alert-premium {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 350px;
            padding: 1.2rem 1.5rem;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.4);
            border-left: 6px solid;
            animation: slideInPremium 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        @keyframes slideInPremium {
            0% {
                transform: translateX(100%) scale(0.8);
                opacity: 0;
            }
            100% {
                transform: translateX(0) scale(1);
                opacity: 1;
            }
        }
        
        .alert-premium.success {
            border-left-color: #10b981;
        }
        
        .alert-premium.error {
            border-left-color: #ef4444;
        }
        
        .link-premium {
            color: #3b82f6;
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .link-premium::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        
        .link-premium:hover {
            color: #8b5cf6;
        }
        
        .link-premium:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.9rem;
            letter-spacing: 1px;
            transition: color 0.3s ease;
        }
        
        .footer-text:hover {
            color: rgba(255, 255, 255, 0.8);
        }
        
        @media (max-width: 640px) {
            .premium-card {
                margin: 1rem;
                padding: 1.5rem !important;
            }
            
            .brand-title {
                font-size: 2rem;
            }
            
            .camera-logo-container {
                width: 100px;
                height: 100px;
            }
            
            .alert-premium {
                left: 20px;
                right: 20px;
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Background Gambar Kamera -->
    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=1964&auto=format&fit=crop" 
         alt="Camera Background" 
         class="camera-bg">
    
    <!-- Overlay Gelap -->
    <div class="overlay-dark"></div>
    
    <!-- Animated Camera Lens Background -->
    <div class="camera-lens lens-1"></div>
    <div class="camera-lens lens-2"></div>
    
    <!-- Floating Camera Icons -->
    <i class="fas fa-camera float-icon float-1"></i>
    <i class="fas fa-camera-retro float-icon float-2"></i>
    <i class="fas fa-video float-icon float-3"></i>
    
    <!-- Shutter Effect -->
    <div class="shutter-effect" id="shutterEffect"></div>
    
    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        <div class="w-full max-w-md">
            <!-- Camera Logo & Brand Section -->
            <div class="text-center">
                <div class="camera-logo-container">
                    <div class="camera-logo">
                        <i class="fas fa-camera"></i>
                        <div class="camera-lens-detail"></div>
                    </div>
                </div>
                
                <h1 class="brand-title">
                    Peminjaman Kamera
                </h1>
                
                <p class="brand-subtitle">
                    Capture Your Moments
                </p>
                
                <!-- TAGLINE DENGAN WARNA PUTIH -->
                <p class="text-white text-sm mb-6 italic">
                    <i class="fas fa-quote-left mr-1 text-xs"></i>
                    Pinjam kamera, abadikan momen berharga
                    <i class="fas fa-quote-right ml-1 text-xs"></i>
                </p>
            </div>
            
            <!-- Premium Login Card -->
            <div class="premium-card p-8">
                <form action="/login" method="POST" onsubmit="triggerShutter()">
                    @csrf
                    
                    <div class="input-premium">
                        <i class="fas fa-envelope"></i>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               placeholder="Email address"
                               required>
                    </div>
                    
                    <div class="input-premium">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               placeholder="Password"
                               required>
                        <button type="button" 
                                onclick="togglePassword()" 
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors">
                            <i class="far fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" class="hidden">
                            <span class="w-5 h-5 border-2 border-gray-300 rounded-lg mr-2 flex items-center justify-center group-hover:border-blue-500 transition-colors">
                                <i class="fas fa-check text-transparent group-hover:text-blue-500 text-xs"></i>
                            </span>
                            <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Remember me</span>
                        </label>
                        <a href="#" class="link-premium text-sm">
                            Forgot password?
                        </a>
                    </div>
                    
                    <button type="submit" class="btn-premium mt-6">
                        <i class="fas fa-camera mr-2"></i>
                        Capture Login
                    </button>
                    
                    <p class="text-center text-sm text-gray-500 mt-6">
                        New photographer?
                        <a href="/register" class="link-premium ml-1">
                            Join the club
                        </a>
                    </p>
                </form>
            </div>
            
            <p class="footer-text text-center mt-8">
                <i class="fas fa-copyright mr-1 text-xs"></i>
                2024 Peminjaman Kamera. All rights reserved.
            </p>
        </div>
    </div>
    
    @if (session('success'))
    <div class="alert-premium success" id="alert-success">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-semibold text-green-800">Success!</p>
                <p class="text-sm text-green-600 mt-1">{{ session('success') }}</p>
            </div>
            <button type="button" class="text-green-400 hover:text-green-600" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif
    
    @if (session('error'))
    <div class="alert-premium error" id="alert-error">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-exclamation text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-semibold text-red-800">Error!</p>
                <p class="text-sm text-red-600 mt-1">{{ session('error') }}</p>
            </div>
            <button type="button" class="text-red-400 hover:text-red-600" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <script>
        function triggerShutter() {
            const shutter = document.getElementById('shutterEffect');
            shutter.classList.add('active');
            setTimeout(() => {
                shutter.classList.remove('active');
            }, 200);
        }
        
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-premium');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        alert.style.animation = 'slideOut 0.3s ease forwards';
                        setTimeout(() => {
                            if (alert.parentNode) alert.remove();
                        }, 300);
                    }
                }, 5000);
            });
        });
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOut {
                from { transform: translateX(0) scale(1); opacity: 1; }
                to { transform: translateX(100%) scale(0.8); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
        
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkIcon = this.nextElementSibling.querySelector('i');
                if (this.checked) {
                    checkIcon.classList.remove('text-transparent');
                    checkIcon.classList.add('text-blue-500');
                } else {
                    checkIcon.classList.add('text-transparent');
                    checkIcon.classList.remove('text-blue-500');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>
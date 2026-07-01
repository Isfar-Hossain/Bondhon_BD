<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userRole = $_SESSION['user_role'] ?? '';
$userFullName = $_SESSION['user_name'] ?? '';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bondhon BD - Find Your Perfect Life Partner</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif']
                    },
                    colors: {
                        brand: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239'
                        }
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons (packaged as SVG or standard feather icons for simple web usage) -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .font-display {
            font-family: 'Space Grotesk', sans-serif;
        }
    </style>
</head>
<body class="flex flex-col min-h-full">

    <!-- Top Navigation Bar -->
    <header class="bg-white border-b border-slate-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="index.php" class="flex items-center gap-2">
                        <span class="text-2xl font-bold font-display tracking-tight text-slate-900 flex items-center">
                            <span class="text-brand-600 mr-1">♥</span>Bondhon<span class="text-brand-600">BD</span>
                        </span>
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="index.php" class="<?php echo $currentPage == 'index.php' ? 'text-brand-600 font-semibold' : 'text-slate-600 hover:text-slate-900'; ?> text-sm transition">Home</a>
                    <a href="browse.php" class="<?php echo $currentPage == 'browse.php' ? 'text-brand-600 font-semibold' : 'text-slate-600 hover:text-slate-900'; ?> text-sm transition">Find Matches</a>
                    
                    <?php if ($isLoggedIn): ?>
                        <a href="profile.php?id=<?php echo $_SESSION['user_id']; ?>" class="<?php echo ($currentPage == 'profile.php' && ($_GET['id'] ?? '') == $_SESSION['user_id']) ? 'text-brand-600 font-semibold' : 'text-slate-600 hover:text-slate-900'; ?> text-sm transition">My Profile</a>
                        <?php if ($userRole === 'admin'): ?>
                            <a href="admin.php" class="<?php echo $currentPage == 'admin.php' ? 'text-brand-600 font-semibold' : 'text-slate-600 hover:text-slate-900'; ?> text-sm transition">Admin Portal</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </nav>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-3">
                    <?php if ($isLoggedIn): ?>
                        <span class="text-sm text-slate-500 mr-2">Hello, <strong><?php echo htmlspecialchars($userFullName); ?></strong></span>
                        <a href="logout.php" class="inline-flex justify-center items-center px-4 py-2 border border-slate-200 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition shadow-sm">
                            Log Out
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="text-sm font-medium text-slate-600 hover:text-slate-900 px-3 py-2 transition">
                            Sign In
                        </a>
                        <a href="register.php" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition shadow-sm">
                            Register Free
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button type="button" onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 hover:text-slate-900 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div class="hidden md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-slate-100 bg-white">
                <a href="index.php" class="block px-3 py-2 rounded-md text-base font-medium <?php echo $currentPage == 'index.php' ? 'bg-brand-50 text-brand-600' : 'text-slate-600 hover:bg-slate-50'; ?>">Home</a>
                <a href="browse.php" class="block px-3 py-2 rounded-md text-base font-medium <?php echo $currentPage == 'browse.php' ? 'bg-brand-50 text-brand-600' : 'text-slate-600 hover:bg-slate-50'; ?>">Find Matches</a>
                
                <?php if ($isLoggedIn): ?>
                    <a href="profile.php?id=<?php echo $_SESSION['user_id']; ?>" class="block px-3 py-2 rounded-md text-base font-medium <?php echo $currentPage == 'profile.php' ? 'bg-brand-50 text-brand-600' : 'text-slate-600 hover:bg-slate-50'; ?>">My Profile</a>
                    <?php if ($userRole === 'admin'): ?>
                        <a href="admin.php" class="block px-3 py-2 rounded-md text-base font-medium <?php echo $currentPage == 'admin.php' ? 'bg-brand-50 text-brand-600' : 'text-slate-600 hover:bg-slate-50'; ?>">Admin Portal</a>
                    <?php endif; ?>
                    <hr class="my-2 border-slate-100">
                    <div class="px-3 py-1 text-xs text-slate-400">Logged in as <?php echo htmlspecialchars($userFullName); ?></div>
                    <a href="logout.php" class="block px-3 py-2 rounded-md text-base font-medium text-rose-600 hover:bg-rose-50">Log Out</a>
                <?php else: ?>
                    <hr class="my-2 border-slate-100">
                    <a href="login.php" class="block px-3 py-2 rounded-md text-base font-medium text-slate-600 hover:bg-slate-50">Sign In</a>
                    <a href="register.php" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-brand-600 hover:bg-brand-700">Register Free</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <script>
        function toggleMobileMenu() {
            var menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        }
    </script>

    <main class="flex-grow">

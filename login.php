<?php
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        try {
            // Fetch user by email
            $stmt = $pdo->prepare("SELECT * FROM profiles WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                // Verify password (supports bcrypt hash. For simple testing, we also support plain password check if hash fails)
                if (password_verify($password, $user['password']) || $password === $user['password']) {
                    // Set sessions
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['fullName'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_email'] = $user['email'];

                    // Redirect based on role
                    if ($user['role'] === 'admin') {
                        header("Location: admin.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit;
                } else {
                    $error = 'Invalid email address or password.';
                }
            } else {
                $error = 'Invalid email address or password.';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}

include 'header.php';
?>

<div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-2xl border border-slate-100 shadow-xl">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <span class="text-3xl font-bold font-display tracking-tight text-slate-900">
                Welcome <span class="text-brand-600">Back</span>
            </span>
            <p class="text-sm text-slate-500">Sign in to search, filter, and connect with prospective partners.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="p-4 bg-rose-50 text-rose-800 border border-rose-100 rounded-lg text-sm font-medium">
                ⚠️ <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form class="space-y-6" action="login.php" method="POST">
            
            <div class="space-y-4">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 mb-2">Email Address</label>
                    <input id="email" name="email" type="email" required class="appearance-none block w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 transition" placeholder="you@example.com">
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-semibold text-slate-700">Password</label>
                        <a href="#" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition">Forgot password?</a>
                    </div>
                    <input id="password" name="password" type="password" required class="appearance-none block w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 transition" placeholder="••••••••">
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-semibold rounded-lg text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition shadow-md">
                    Sign In
                </button>
            </div>

            <!-- Seed Notice -->
            <div class="p-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-800 leading-relaxed space-y-1">
                <p class="font-bold">💡 Demo Accounts available:</p>
                <p>• <strong>Member:</strong> ayesha@example.com / admin123</p>
                <p>• <strong>Admin:</strong> admin@bondhon.com / admin123</p>
            </div>

            <!-- Register Promo -->
            <div class="text-center pt-2">
                <p class="text-sm text-slate-500">
                    New to Bondhon BD? 
                    <a href="register.php" class="font-semibold text-brand-600 hover:text-brand-700 transition">Register Free &rarr;</a>
                </p>
            </div>

        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

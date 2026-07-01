<?php
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $gender = trim($_POST['gender'] ?? 'Female');
    $age = intval($_POST['age'] ?? 0);
    $religion = trim($_POST['religion'] ?? '');
    $education = trim($_POST['education'] ?? '');
    $profession = trim($_POST['profession'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $aboutMe = trim($_POST['aboutMe'] ?? '');
    $familyBackground = trim($_POST['familyBackground'] ?? '');

    if (!empty($fullName) && !empty($email) && !empty($password) && !empty($religion) && !empty($education) && !empty($profession) && !empty($district)) {
        try {
            // Check if email already registered
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM profiles WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $error = 'Email address is already registered. Please sign in instead.';
            } else {
                // Securely hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Photo Placeholder based on gender
                $photoUrl = ($gender === 'Male') 
                    ? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=600'
                    : 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600';

                // Insert profile
                $sql = "INSERT INTO profiles (fullName, email, password, gender, age, religion, education, profession, district, aboutMe, familyBackground, photoUrl, status, role) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending Review', 'user')";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $fullName, $email, $hashedPassword, $gender, $age, 
                    $religion, $education, $profession, $district, 
                    $aboutMe, $familyBackground, $photoUrl
                ]);

                $newUserId = $pdo->lastInsertId();

                // Log the user in
                $_SESSION['user_id'] = $newUserId;
                $_SESSION['user_name'] = $fullName;
                $_SESSION['user_role'] = 'user';
                $_SESSION['user_email'] = $email;

                header("Location: profile.php?id=" . $newUserId . "&registered=1");
                exit;
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    } else {
        $error = 'Please fill in all required fields.';
    }
}

include 'header.php';
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden lg:grid lg:grid-cols-12">
        
        <!-- Left Banner: Visual Appeal -->
        <div class="hidden lg:block lg:col-span-5 bg-gradient-to-br from-rose-500 to-pink-700 relative overflow-hidden flex flex-col justify-between p-12 text-white">
            <div class="space-y-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white">
                    ✨ Free Registration
                </span>
                <h2 class="text-3xl font-bold font-display tracking-tight leading-snug">
                    Your search for a meaningful bond begins here.
                </h2>
                <p class="text-white/80 text-sm leading-relaxed">
                    Create your profile in 2 minutes and join thousands of respectable families. All profiles are manually audited to ensure maximum trust and validity.
                </p>
            </div>

            <!-- Testimonial -->
            <div class="border-t border-white/20 pt-8 mt-12">
                <p class="text-sm italic text-white/90">"Found my soulmate through Bondhon BD. Highly recommend their family-focused approach."</p>
                <p class="text-xs font-bold text-white mt-2">— Lamia & Sifat, Dhaka</p>
            </div>
            
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <!-- Right Content: Form -->
        <div class="p-8 sm:p-12 lg:col-span-7">
            <div class="space-y-4 mb-8">
                <h1 class="text-2xl font-bold font-display text-slate-900">Create Your Profile</h1>
                <p class="text-sm text-slate-500">Provide accurate details to find matches compatible with your family, professional background, and values.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="p-4 bg-rose-50 text-rose-800 border border-rose-100 rounded-lg text-sm font-medium mb-6">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form action="register.php" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    
                    <!-- Full Name -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Full Name (required)</label>
                        <input name="fullName" type="text" required class="appearance-none block w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 transition" placeholder="e.g. Tanzila Islam">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Email Address (required)</label>
                        <input name="email" type="email" required class="appearance-none block w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 transition" placeholder="email@example.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Password (required)</label>
                        <input name="password" type="password" required class="appearance-none block w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 transition" placeholder="••••••••">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Gender (required)</label>
                        <select name="gender" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="Female">Bride (Female)</option>
                            <option value="Male">Groom (Male)</option>
                        </select>
                    </div>

                    <!-- Age -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Age (required)</label>
                        <input name="age" type="number" min="18" max="70" required class="appearance-none block w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 transition" placeholder="e.g. 25">
                    </div>

                    <!-- Religion -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Religion (required)</label>
                        <select name="religion" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="Islam (Sunni)">Islam (Sunni)</option>
                            <option value="Islam (Shia)">Islam (Shia)</option>
                            <option value="Hinduism">Hinduism</option>
                            <option value="Buddhism">Buddhism</option>
                            <option value="Christianity">Christianity</option>
                        </select>
                    </div>

                    <!-- District -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">District / Home Town (required)</label>
                        <select name="district" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="Dhaka">Dhaka</option>
                            <option value="Chittagong">Chittagong</option>
                            <option value="Sylhet">Sylhet</option>
                            <option value="Rajshahi">Rajshahi</option>
                            <option value="Khulna">Khulna</option>
                            <option value="Barisal">Barisal</option>
                            <option value="Rangpur">Rangpur</option>
                            <option value="Mymensingh">Mymensingh</option>
                        </select>
                    </div>

                    <!-- Education -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Education Level (required)</label>
                        <input name="education" type="text" required class="appearance-none block w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 transition" placeholder="e.g. B.Sc. in Engineering, MBA, MBBS">
                    </div>

                    <!-- Profession -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Profession (required)</label>
                        <input name="profession" type="text" required class="appearance-none block w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 transition" placeholder="e.g. Software Engineer, Doctor, Business Owner">
                    </div>

                    <!-- About Me -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-2">About Me (A descriptive bio)</label>
                        <textarea name="aboutMe" rows="3" class="appearance-none block w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 transition" placeholder="Tell other members about your personality, hobbies, life philosophy, and what partner attributes you prefer..."></textarea>
                    </div>

                    <!-- Family Background -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Family Background & Values</label>
                        <textarea name="familyBackground" rows="2" class="appearance-none block w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2.5 text-sm placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500 transition" placeholder="Tell us about your parents, siblings, and family culture..."></textarea>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-4">
                    <p class="text-xs text-slate-400">By registering, you agree to Bondhon BD's terms of service and manually verified privacy policies.</p>
                    <button type="submit" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-brand-600 hover:bg-brand-700 transition shadow-md whitespace-nowrap">
                        Create Account
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>

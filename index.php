<?php
require_once 'db.php';
include 'header.php';

// Fetch a few approved featured profiles from database
try {
    $stmt = $pdo->query("SELECT * FROM profiles WHERE status = 'Approved' ORDER BY id DESC LIMIT 4");
    $featured = $stmt->fetchAll();
} catch (PDOException $e) {
    $featured = []; // Fallback to empty if db is not setup yet
}
?>

<!-- Hero Section -->
<section class="relative bg-white overflow-hidden py-16 sm:py-24 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
            
            <!-- Left Text Content -->
            <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left space-y-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-brand-700">
                    💖 Trusted Matrimony Service in Bangladesh
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold font-display tracking-tight text-slate-900 leading-none">
                    Find Your Genuine <span class="text-brand-600">Life Partner</span>
                </h1>
                <p class="text-base sm:text-lg text-slate-500 leading-relaxed">
                    Bondhon BD brings together single professionals and respectable families across Bangladesh. Discover verified profiles based on values, education, and compatibility.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 sm:justify-center lg:justify-start">
                    <a href="register.php" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-semibold rounded-xl text-white bg-brand-600 hover:bg-brand-700 transition shadow-md">
                        Get Started Free
                    </a>
                    <a href="browse.php" class="inline-flex justify-center items-center px-6 py-3 border border-slate-200 text-base font-semibold rounded-xl text-slate-700 bg-slate-50 hover:bg-slate-100 transition">
                        Browse Profiles
                    </a>
                </div>
            </div>

            <!-- Right Image Banner -->
            <div class="mt-12 sm:mt-16 lg:mt-0 lg:col-span-6 relative flex justify-center">
                <div class="relative w-full max-w-md lg:max-w-none">
                    <img class="w-full rounded-2xl shadow-xl object-cover aspect-[4/3]" src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=800" alt="Wedding Couple">
                    <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl shadow-lg border border-slate-100 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 text-lg">✓</div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">100% Verified</p>
                            <p class="text-xs text-slate-500">Profiles Checked manually</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Quick Search Form -->
<section class="max-w-5xl mx-auto px-4 -mt-10 relative z-10">
    <form action="browse.php" method="GET" class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 sm:p-8">
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 text-center sm:text-left">Quick Search</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            
            <!-- Gender Looking For -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Looking For</label>
                <select name="gender" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="">Any Gender</option>
                    <option value="Female">Bride (Female)</option>
                    <option value="Male">Groom (Male)</option>
                </select>
            </div>

            <!-- Religion -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">Religion</label>
                <select name="religion" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="">Any Religion</option>
                    <option value="Islam (Sunni)">Islam (Sunni)</option>
                    <option value="Islam (Shia)">Islam (Shia)</option>
                    <option value="Hinduism">Hinduism</option>
                    <option value="Buddhism">Buddhism</option>
                    <option value="Christianity">Christianity</option>
                </select>
            </div>

            <!-- District / Location -->
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-2">District</label>
                <select name="district" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="">Any District</option>
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

            <!-- Submit Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-lg text-sm px-4 py-2.5 shadow-sm transition">
                    Search Matches
                </button>
            </div>

        </div>
    </form>
</section>

<!-- How It Works Section -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto space-y-3 mb-12">
            <h2 class="text-3xl font-bold font-display text-slate-900">How Bondhon BD Works</h2>
            <p class="text-sm text-slate-500">Three simple steps to initiate a meaningful, lifelong connection.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Step 1 -->
            <div class="bg-white p-8 rounded-xl border border-slate-100 shadow-sm text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-rose-50 text-brand-600 flex items-center justify-center font-bold text-lg mx-auto">1</div>
                <h3 class="text-lg font-bold text-slate-950">Create Profile</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Register free, fill in your professional details, religious and cultural background, and upload a decent photograph.</p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white p-8 rounded-xl border border-slate-100 shadow-sm text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-rose-50 text-brand-600 flex items-center justify-center font-bold text-lg mx-auto">2</div>
                <h3 class="text-lg font-bold text-slate-950">Discover Matches</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Apply comprehensive search filters like age, education, and district to find individuals who match your expectations.</p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white p-8 rounded-xl border border-slate-100 shadow-sm text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-rose-50 text-brand-600 flex items-center justify-center font-bold text-lg mx-auto">3</div>
                <h3 class="text-lg font-bold text-slate-950">Initiate Contact</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Express interest, connect with validated candidates, and involve respectable families to take discussions forward.</p>
            </div>

        </div>
    </div>
</section>

<!-- Featured Profiles -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
            <div class="space-y-2">
                <h2 class="text-3xl font-bold font-display text-slate-900">Featured Profiles</h2>
                <p class="text-sm text-slate-500">Discover recent, verified profiles ready to connect.</p>
            </div>
            <a href="browse.php" class="text-sm font-semibold text-brand-600 hover:text-brand-700 transition flex items-center gap-1">
                View All Matches &rarr;
            </a>
        </div>

        <?php if (!empty($featured)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($featured as $profile): ?>
                    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition flex flex-col group">
                        
                        <!-- Profile Photo -->
                        <div class="relative aspect-[4/5] bg-slate-100 overflow-hidden">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition duration-300" src="<?php echo htmlspecialchars($profile['photoUrl'] ?? 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600'); ?>" alt="<?php echo htmlspecialchars($profile['fullName']); ?>" referrerPolicy="no-referrer">
                            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded-md text-xs font-semibold text-slate-900 border border-white/50 flex items-center gap-1">
                                <span class="text-brand-600">✓</span> Verified
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div class="space-y-1">
                                <h3 class="font-bold text-slate-950 group-hover:text-brand-600 transition"><?php echo htmlspecialchars($profile['fullName']); ?></h3>
                                <p class="text-xs font-semibold text-slate-500"><?php echo htmlspecialchars($profile['age']); ?> Yrs • <?php echo htmlspecialchars($profile['religion']); ?></p>
                                <p class="text-xs text-slate-600 font-medium truncate"><?php echo htmlspecialchars($profile['profession']); ?></p>
                                <p class="text-xs text-slate-400"><?php echo htmlspecialchars($profile['education']); ?></p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-50">
                                <a href="profile.php?id=<?php echo $profile['id']; ?>" class="block text-center w-full bg-slate-50 hover:bg-brand-600 hover:text-white text-slate-700 font-medium rounded-lg text-xs py-2 transition">
                                    View Full Profile
                                </a>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Fallback if database is not seeded/initialized yet -->
            <div class="text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                <p class="text-slate-500 text-sm mb-4">No active profiles loaded in database yet.</p>
                <a href="register.php" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg transition shadow-sm">
                    Be the First to Register!
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>

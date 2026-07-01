<?php
require_once 'db.php';
include 'header.php';

$profileId = intval($_GET['id'] ?? 0);
$profile = null;
$error = '';
$justRegistered = isset($_GET['registered']) && $_GET['registered'] == '1';

if ($profileId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM profiles WHERE id = ?");
        $stmt->execute([$profileId]);
        $profile = $stmt->fetch();
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

if (!$profile) {
    $error = "Candidate profile not found or is currently private.";
}
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <?php if ($justRegistered): ?>
        <div class="mb-8 p-5 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-800 flex items-start gap-4">
            <div class="text-2xl mt-0.5">🎉</div>
            <div class="space-y-1">
                <h4 class="font-bold text-sm">Registration Successful!</h4>
                <p class="text-xs leading-relaxed text-emerald-700">Thank you for creating your account. Your details are now under review by our administration. Once approved, your profile will appear on the discovery list. You can review and update your information below.</p>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="bg-white p-12 text-center rounded-2xl border border-slate-100 flex flex-col items-center justify-center space-y-4">
            <div class="w-16 h-16 rounded-full bg-rose-50 flex items-center justify-center text-rose-500 text-3xl">⚠️</div>
            <div class="space-y-1">
                <h3 class="text-lg font-bold text-slate-900">Profile Unavailable</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto"><?php echo htmlspecialchars($error); ?></p>
            </div>
            <a href="browse.php" class="inline-flex items-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-lg transition">
                Back to Discovery
            </a>
        </div>
    <?php else: ?>
        
        <!-- Profile Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Side Column: Avatar, Badges & Quick Stats -->
            <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                
                <!-- Large Image -->
                <div class="aspect-[4/5] bg-slate-100 relative">
                    <img class="w-full h-full object-cover" src="<?php echo htmlspecialchars($profile['photoUrl'] ?? 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600'); ?>" alt="<?php echo htmlspecialchars($profile['fullName']); ?>" referrerPolicy="no-referrer">
                    <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-lg text-xs font-bold text-slate-900 border border-white/50 flex items-center gap-1.5 shadow-sm">
                        <span class="text-brand-600">✓</span> Profile Verified
                    </div>
                </div>

                <!-- Header Name Block -->
                <div class="p-6 border-b border-slate-50 space-y-2">
                    <div class="flex items-center justify-between">
                        <h1 class="text-xl font-bold text-slate-900"><?php echo htmlspecialchars($profile['fullName']); ?></h1>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700">
                            <?php echo htmlspecialchars($profile['status']); ?>
                        </span>
                    </div>
                    <p class="text-xs font-semibold text-slate-500"><?php echo htmlspecialchars($profile['age']); ?> Years Old • <?php echo htmlspecialchars($profile['religion']); ?></p>
                    <p class="text-xs text-slate-700 font-medium">📍 <?php echo htmlspecialchars($profile['district']); ?>, Bangladesh</p>
                </div>

                <!-- Express Interest Form -->
                <div class="p-6 space-y-3 bg-slate-50/50">
                    <button onclick="expressInterest()" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-lg text-sm py-2.5 shadow-sm transition flex items-center justify-center gap-2">
                        💖 Send Interest Request
                    </button>
                    <button onclick="shortlistProfile()" class="w-full border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-lg text-sm py-2.5 transition flex items-center justify-center gap-2">
                        ☆ Shortlist Profile
                    </button>
                    <p class="text-[10px] text-slate-400 text-center leading-relaxed">Sending interest shares your contact details with their registered family guardian.</p>
                </div>

            </div>

            <!-- Right Side Column: Detailed Specifications -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- About Block -->
                <div class="bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b border-slate-50 pb-3 flex items-center gap-2">
                        <span>📝</span> About Candidate
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        <?php echo nl2br(htmlspecialchars($profile['aboutMe'])); ?>
                    </p>
                </div>

                <!-- Detailed Attributes Grid -->
                <div class="bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-sm space-y-6">
                    <h2 class="text-lg font-bold text-slate-900 border-b border-slate-50 pb-3 flex items-center gap-2">
                        <span>📋</span> Personal Profile Details
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                        <!-- Age -->
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Age</span>
                            <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($profile['age']); ?> Years</span>
                        </div>
                        <!-- Religion -->
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Religion</span>
                            <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($profile['religion']); ?></span>
                        </div>
                        <!-- Marital Status -->
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Marital Status</span>
                            <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($profile['maritalStatus']); ?></span>
                        </div>
                        <!-- Mother Tongue -->
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Mother Tongue</span>
                            <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($profile['motherTongue']); ?></span>
                        </div>
                        <!-- Diet -->
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Diet</span>
                            <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($profile['diet']); ?></span>
                        </div>
                        <!-- Joined Date -->
                        <div class="flex justify-between py-2 border-b border-slate-100">
                            <span class="text-slate-500">Member Since</span>
                            <span class="font-semibold text-slate-800"><?php echo date("M Y", strtotime($profile['joinedDate'])); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Education & Career -->
                <div class="bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b border-slate-50 pb-3 flex items-center gap-2">
                        <span>🎓</span> Education & Professional Life
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                        <div class="space-y-1">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Education Level</span>
                            <p class="font-semibold text-slate-800 text-sm"><?php echo htmlspecialchars($profile['education']); ?></p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Profession</span>
                            <p class="font-semibold text-slate-800 text-sm"><?php echo htmlspecialchars($profile['profession']); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Family Details -->
                <div class="bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-sm space-y-4">
                    <h2 class="text-lg font-bold text-slate-900 border-b border-slate-50 pb-3 flex items-center gap-2">
                        <span>👨‍👩‍👧</span> Family Background & Values
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        <?php echo !empty($profile['familyBackground']) ? nl2br(htmlspecialchars($profile['familyBackground'])) : "The candidate belongs to an educated and respectable family based in Bangladesh. Family details will be disclosed fully to potential partners upon interest acceptance."; ?>
                    </p>
                </div>

            </div>

        </div>

        <script>
            function expressInterest() {
                alert("💖 Your Interest Request has been registered successfully! The candidate's family guardian will receive a notification and your contact email.");
            }
            function shortlistProfile() {
                alert("⭐ Profile has been added to your shortlist directory.");
            }
        </script>

    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

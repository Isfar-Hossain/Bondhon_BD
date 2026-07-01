<?php
require_once 'db.php';
include 'header.php';

// Formulate dynamic search query
$where = ["status = 'Approved'"];
$params = [];

$genderFilter = $_GET['gender'] ?? '';
$religionFilter = $_GET['religion'] ?? '';
$districtFilter = $_GET['district'] ?? '';
$professionFilter = $_GET['profession'] ?? '';
$minAge = intval($_GET['minAge'] ?? 18);
$maxAge = intval($_GET['maxAge'] ?? 60);

if (!empty($genderFilter)) {
    $where[] = "gender = ?";
    $params[] = $genderFilter;
}
if (!empty($religionFilter)) {
    $where[] = "religion = ?";
    $params[] = $religionFilter;
}
if (!empty($districtFilter)) {
    $where[] = "district = ?";
    $params[] = $districtFilter;
}
if (!empty($professionFilter)) {
    $where[] = "profession LIKE ?";
    $params[] = "%" . $professionFilter . "%";
}
if ($minAge > 18) {
    $where[] = "age >= ?";
    $params[] = $minAge;
}
if ($maxAge < 60) {
    $where[] = "age <= ?";
    $params[] = $maxAge;
}

$sql = "SELECT * FROM profiles";
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY id DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $profiles = $stmt->fetchAll();
} catch (PDOException $e) {
    $profiles = [];
    $error = "Error executing query: " . $e->getMessage();
}
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Title -->
    <div class="mb-8 space-y-2">
        <h1 class="text-3xl font-bold font-display text-slate-900">Discover Matches</h1>
        <p class="text-sm text-slate-500">Filter profiles by background, occupation, location, and beliefs to find a suitable bride or groom.</p>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar Filter Form -->
        <div class="lg:col-span-1">
            <form action="browse.php" method="GET" class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-6 sticky top-20">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="font-bold text-slate-900">Search Filters</h3>
                    <a href="browse.php" class="text-xs font-semibold text-brand-600 hover:text-brand-700">Clear All</a>
                </div>

                <!-- Looking For -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Looking For</label>
                    <select name="gender" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="">Any Gender</option>
                        <option value="Female" <?php echo $genderFilter === 'Female' ? 'selected' : ''; ?>>Bride (Female)</option>
                        <option value="Male" <?php echo $genderFilter === 'Male' ? 'selected' : ''; ?>>Groom (Male)</option>
                    </select>
                </div>

                <!-- Religion -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Religion</label>
                    <select name="religion" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="">Any Religion</option>
                        <option value="Islam (Sunni)" <?php echo $religionFilter === 'Islam (Sunni)' ? 'selected' : ''; ?>>Islam (Sunni)</option>
                        <option value="Islam (Shia)" <?php echo $religionFilter === 'Islam (Shia)' ? 'selected' : ''; ?>>Islam (Shia)</option>
                        <option value="Hinduism" <?php echo $religionFilter === 'Hinduism' ? 'selected' : ''; ?>>Hinduism</option>
                        <option value="Buddhism" <?php echo $religionFilter === 'Buddhism' ? 'selected' : ''; ?>>Buddhism</option>
                        <option value="Christianity" <?php echo $religionFilter === 'Christianity' ? 'selected' : ''; ?>>Christianity</option>
                    </select>
                </div>

                <!-- District / Location -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">District</label>
                    <select name="district" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="">Any District</option>
                        <option value="Dhaka" <?php echo $districtFilter === 'Dhaka' ? 'selected' : ''; ?>>Dhaka</option>
                        <option value="Chittagong" <?php echo $districtFilter === 'Chittagong' ? 'selected' : ''; ?>>Chittagong</option>
                        <option value="Sylhet" <?php echo $districtFilter === 'Sylhet' ? 'selected' : ''; ?>>Sylhet</option>
                        <option value="Rajshahi" <?php echo $districtFilter === 'Rajshahi' ? 'selected' : ''; ?>>Rajshahi</option>
                        <option value="Khulna" <?php echo $districtFilter === 'Khulna' ? 'selected' : ''; ?>>Khulna</option>
                        <option value="Barisal" <?php echo $districtFilter === 'Barisal' ? 'selected' : ''; ?>>Barisal</option>
                        <option value="Rangpur" <?php echo $districtFilter === 'Rangpur' ? 'selected' : ''; ?>>Rangpur</option>
                        <option value="Mymensingh" <?php echo $districtFilter === 'Mymensingh' ? 'selected' : ''; ?>>Mymensingh</option>
                    </select>
                </div>

                <!-- Age Bracket -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Age Bracket</label>
                    <div class="flex gap-2 items-center">
                        <input name="minAge" type="number" min="18" max="70" value="<?php echo $minAge; ?>" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-2 py-2 text-center text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <span class="text-xs text-slate-400">to</span>
                        <input name="maxAge" type="number" min="18" max="70" value="<?php echo $maxAge; ?>" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-2 py-2 text-center text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>
                </div>

                <!-- Occupation keyword -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Occupation / Title</label>
                    <input name="profession" type="text" value="<?php echo htmlspecialchars($professionFilter); ?>" placeholder="e.g. Engineer" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-xs placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-lg text-xs py-2.5 shadow-sm transition">
                    Apply Filters
                </button>
            </form>
        </div>

        <!-- Main Profiles Grid -->
        <div class="lg:col-span-3">
            
            <?php if (!empty($profiles)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($profiles as $profile): ?>
                        <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition flex flex-col group justify-between">
                            
                            <!-- Profile Photo -->
                            <div class="relative aspect-[4/5] bg-slate-100 overflow-hidden">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition duration-300" src="<?php echo htmlspecialchars($profile['photoUrl'] ?? 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=600'); ?>" alt="<?php echo htmlspecialchars($profile['fullName']); ?>" referrerPolicy="no-referrer">
                                <div class="absolute top-3 right-3 bg-brand-600 text-white px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                    Verified
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div class="space-y-1.5">
                                    <h3 class="font-bold text-slate-950 group-hover:text-brand-600 transition text-sm"><?php echo htmlspecialchars($profile['fullName']); ?></h3>
                                    <p class="text-xs font-semibold text-slate-500"><?php echo htmlspecialchars($profile['age']); ?> Yrs • <?php echo htmlspecialchars($profile['religion']); ?></p>
                                    
                                    <div class="space-y-1 pt-1">
                                        <p class="text-xs text-slate-600 font-medium truncate">💼 <?php echo htmlspecialchars($profile['profession']); ?></p>
                                        <p class="text-xs text-slate-500 truncate">🎓 <?php echo htmlspecialchars($profile['education']); ?></p>
                                        <p class="text-xs text-slate-400">📍 District: <?php echo htmlspecialchars($profile['district']); ?></p>
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-t border-slate-50">
                                    <a href="profile.php?id=<?php echo $profile['id']; ?>" class="block text-center w-full bg-slate-50 hover:bg-brand-600 hover:text-white text-slate-700 font-semibold rounded-lg text-xs py-2.5 transition">
                                        View Details
                                    </a>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Empty Results -->
                <div class="bg-white p-12 text-center rounded-2xl border border-slate-100 flex flex-col items-center justify-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 text-3xl">🔍</div>
                    <div class="space-y-1">
                        <h3 class="text-lg font-bold text-slate-900">No Matches Found</h3>
                        <p class="text-sm text-slate-500 max-w-sm mx-auto">Try widening your search filters, checking spelling, or clearing selected attributes.</p>
                    </div>
                    <a href="browse.php" class="inline-flex items-center px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold rounded-lg transition">
                        Reset Filters
                    </a>
                </div>
            <?php endif; ?>

        </div>

    </div>
</div>

<?php include 'footer.php'; ?>

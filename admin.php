<?php
require_once 'db.php';

// Authorization Check
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    include 'header.php';
    echo "<div class='max-w-md mx-auto my-16 p-8 bg-white rounded-2xl border border-slate-100 shadow-xl text-center space-y-4'>";
    echo "<div class='text-4xl'>🔒</div>";
    echo "<h3 class='text-lg font-bold text-slate-900'>Access Restricted</h3>";
    echo "<p class='text-sm text-slate-500'>This page is reserved for system administrators only.</p>";
    echo "<p class='text-xs text-brand-600 bg-rose-50 p-3 rounded-lg font-medium'>Please sign out and sign back in using the administrator email: <strong>admin@bondhon.com</strong> with password <strong>admin123</strong> to test the admin controls.</p>";
    echo "<a href='login.php' class='inline-block px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg transition'>Go to Login</a>";
    echo "</div>";
    include 'footer.php';
    exit;
}

$notice = '';

// Handle Admin Actions
if (isset($_POST['action']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    try {
        if ($action === 'Approve') {
            $stmt = $pdo->prepare("UPDATE profiles SET status = 'Approved' WHERE id = ?");
            $stmt->execute([$id]);
            $notice = "Profile ID #$id was successfully Approved and is now public.";
        } elseif ($action === 'Reject') {
            $stmt = $pdo->prepare("UPDATE profiles SET status = 'Rejected' WHERE id = ?");
            $stmt->execute([$id]);
            $notice = "Profile ID #$id was Rejected.";
        } elseif ($action === 'Delete') {
            $stmt = $pdo->prepare("DELETE FROM profiles WHERE id = ?");
            $stmt->execute([$id]);
            $notice = "Profile ID #$id was permanently Deleted from the database.";
        }
    } catch (PDOException $e) {
        $notice = "Database Error: " . $e->getMessage();
    }
}

// Fetch all profiles for display
try {
    $stmt = $pdo->query("SELECT * FROM profiles ORDER BY id DESC");
    $profiles = $stmt->fetchAll();
} catch (PDOException $e) {
    $profiles = [];
    $notice = "Error loading profiles. Did you import schema.sql? Details: " . $e->getMessage();
}

include 'header.php';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Title -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 border-b border-slate-100 pb-5">
        <div>
            <h1 class="text-3xl font-bold font-display text-slate-900">Admin Control Center</h1>
            <p class="text-sm text-slate-500">Monitor registrations, audit bios, and approve pending profiles to maintain platform security.</p>
        </div>
        <div class="bg-brand-50 text-brand-700 px-4 py-1.5 rounded-lg text-xs font-semibold">
            Admin Session: Active
        </div>
    </div>

    <?php if (!empty($notice)): ?>
        <div class="mb-6 p-4 bg-blue-50 border border-blue-100 text-blue-800 rounded-xl text-sm font-medium">
            💡 <?php echo htmlspecialchars($notice); ?>
        </div>
    <?php endif; ?>

    <!-- User Audit Table -->
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h3 class="font-bold text-slate-900">Profiles Directory</h3>
            <span class="text-xs text-slate-400">Showing total <?php echo count($profiles); ?> records</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 font-bold uppercase text-[10px] tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6">ID & Avatar</th>
                        <th class="py-4 px-6">Candidate Details</th>
                        <th class="py-4 px-6">Location & Religion</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <?php if (!empty($profiles)): ?>
                        <?php foreach ($profiles as $p): ?>
                            <tr>
                                <!-- Avatar -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-bold text-slate-400">#<?php echo $p['id']; ?></span>
                                        <img class="w-10 h-10 rounded-full object-cover border border-slate-100" src="<?php echo htmlspecialchars($p['photoUrl'] ?? ''); ?>" alt="" referrerPolicy="no-referrer">
                                    </div>
                                </td>

                                <!-- Details -->
                                <td class="py-4 px-6">
                                    <div class="space-y-0.5">
                                        <a href="profile.php?id=<?php echo $p['id']; ?>" class="font-bold text-slate-900 hover:text-brand-600 transition">
                                            <?php echo htmlspecialchars($p['fullName']); ?>
                                        </a>
                                        <p class="text-xs text-slate-500 font-medium truncate max-w-xs"><?php echo htmlspecialchars($p['profession']); ?> • <?php echo htmlspecialchars($p['education']); ?></p>
                                        <p class="text-[11px] text-slate-400"><?php echo htmlspecialchars($p['email']); ?></p>
                                    </div>
                                </td>

                                <!-- Location -->
                                <td class="py-4 px-6">
                                    <div class="space-y-0.5 text-xs text-slate-600">
                                        <p class="font-semibold text-slate-800">📍 <?php echo htmlspecialchars($p['district']); ?></p>
                                        <p><?php echo htmlspecialchars($p['religion']); ?> • <?php echo htmlspecialchars($p['gender']); ?></p>
                                    </div>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-6">
                                    <?php 
                                    $badgeColor = 'bg-slate-50 text-slate-600';
                                    if ($p['status'] === 'Approved') $badgeColor = 'bg-emerald-50 text-emerald-700';
                                    if ($p['status'] === 'Pending Review') $badgeColor = 'bg-amber-50 text-amber-700';
                                    if ($p['status'] === 'Rejected') $badgeColor = 'bg-rose-50 text-rose-700';
                                    ?>
                                    <span class="inline-flex px-2 py-0.5 text-[10px] font-bold uppercase rounded-md <?php echo $badgeColor; ?>">
                                        <?php echo htmlspecialchars($p['status']); ?>
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6">
                                    <div class="flex justify-end gap-2">
                                        
                                        <!-- Approve / Reject Forms -->
                                        <?php if ($p['status'] === 'Pending Review'): ?>
                                            <form action="admin.php" method="POST" onsubmit="return confirm('Approve this profile for discovery?');">
                                                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                                <input type="hidden" name="action" value="Approve">
                                                <button type="submit" class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-md transition shadow-sm">
                                                    Approve
                                                </button>
                                            </form>

                                            <form action="admin.php" method="POST" onsubmit="return confirm('Reject this profile?');">
                                                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                                <input type="hidden" name="action" value="Reject">
                                                <button type="submit" class="px-2.5 py-1 text-xs font-semibold bg-rose-50 text-rose-700 hover:bg-rose-600 hover:text-white rounded-md transition shadow-sm">
                                                    Reject
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <!-- Delete action (except for the admin itself to avoid lockout) -->
                                        <?php if ($p['email'] !== $_SESSION['user_email']): ?>
                                            <form action="admin.php" method="POST" onsubmit="return confirm('Are you sure you want to PERMANENTLY DELETE this user from the database?');">
                                                <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                                                <input type="hidden" name="action" value="Delete">
                                                <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 rounded transition" title="Delete Candidate">
                                                    🗑️
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-12 px-6 text-center text-slate-400 text-sm">
                                No profile accounts registered in database.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

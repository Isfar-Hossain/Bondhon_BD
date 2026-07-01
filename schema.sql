CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `age` int(11) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `education` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `district` varchar(50) NOT NULL,
  `aboutMe` text NOT NULL,
  `familyBackground` text NOT NULL,
  `maritalStatus` varchar(50) NOT NULL DEFAULT 'Never Married',
  `motherTongue` varchar(50) NOT NULL DEFAULT 'Bengali',
  `diet` varchar(50) NOT NULL DEFAULT 'Halal',
  `photoUrl` varchar(255) DEFAULT NULL,
  `status` enum('Pending Review','Approved','Rejected') NOT NULL DEFAULT 'Pending Review',
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `joinedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Dumping seed data for testing
-- --------------------------------------------------------

INSERT INTO `profiles` (`id`, `fullName`, `email`, `password`, `gender`, `age`, `religion`, `education`, `profession`, `district`, `aboutMe`, `familyBackground`, `maritalStatus`, `motherTongue`, `diet`, `photoUrl`, `status`, `role`) VALUES
(1, 'Ayesha Rahman', 'ayesha@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Female', 26, 'Islam (Sunni)', 'MSc in Computer Science', 'Software Engineer', 'Dhaka', 'I am an independent, career-oriented individual who balances modern career aspirations with warm cultural values. I love technology, traveling, and spending time with my family.', 'Middle Class nuclear family from Dhaka. Father is a retired engineer, mother is a homemaker.', 'Never Married', 'Bengali', 'Halal', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=600', 'Approved', 'user'),
(2, 'Fahim Chowdhury', 'fahim@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Male', 28, 'Islam (Sunni)', 'MBBS', 'Medical Doctor', 'Chittagong', 'Dedicated physician working at a private hospital in Chittagong. I am active, love outdoors, and looking for a companion to share a meaningful journey of life.', 'Respectable family. Father is a doctor, mother is a university professor. One younger sister.', 'Never Married', 'Bengali', 'Halal', 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=600', 'Approved', 'user'),
(3, 'Nadia Islam', 'nadia@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Female', 28, 'Islam (Sunni)', 'B.Sc. in Computer Science', 'Senior Software Engineer', 'Dhaka', 'I am a dedicated and family-oriented individual who balances modern professional aspirations with deep-rooted traditional values. Currently working at a leading tech firm.', 'We are a respectable, middle-class nuclear family based in Dhaka. Father is a retired government official, mother is a homemaker.', 'Never Married', 'Bengali', 'Halal', 'https://images.unsplash.com/photo-1594744803329-e58b31de215f?auto=format&fit=crop&q=80&w=600', 'Pending Review', 'user'),
(4, 'Tariq Hasan', 'tariq@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Male', 30, 'Islam (Sunni)', 'BBA, IBA', 'Business Owner', 'Dhaka', 'An entrepreneur running a technology and retail export business in Dhaka. High believer of work-life integration. Love fitness, photography, and traditional arts.', 'Well-known business family in Dhaka. Both parents actively support my work.', 'Never Married', 'Bengali', 'Halal', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=600', 'Approved', 'user'),
(5, 'Admin Bondhon', 'admin@bondhon.com', '$2y$10$f6F6mH.K6v.B78l/A5a56eK1F56i0O5E1f71k.e5sX7r0i3g86.u6', 'Male', 32, 'Islam (Sunni)', 'MBA', 'Platform Administrator', 'Dhaka', 'System administration account for monitoring profiles and managing connections.', 'N/A', 'Never Married', 'Bengali', 'Halal', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=600', 'Approved', 'admin');

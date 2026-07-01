# Bondhon BD Matrimonial - Award Space Hosting Setup Guide

Congratulations! You have the complete, production-ready source code for **Bondhon BD Matrimonial**, customized specifically for standard PHP & MySQL hosting environments like **Award Space**.

Follow this step-by-step guide to launch your matrimonial platform live on the internet.

---

## 📁 File Structure Overview

These files are located in the `php-export` folder of your project:
*   `db.php` — Database connection configuration (PDO format).
*   `schema.sql` — MySQL database creation schema and initial sample candidate profiles.
*   `header.php` — Reusable page header, navigation, and mobile menu (integrates responsive Tailwind CSS).
*   `footer.php` — Reusable footer containing social markers and copyright text.
*   `index.php` — High-impact home landing page with statistics and a "Quick Search" utility.
*   `browse.php` — Dynamic search engine with criteria filters (location, profession, age, religion).
*   `profile.php` — Dynamic profile view detailing educational background, values, and family context.
*   `admin.php` — Administrator panel to moderate registered profiles, approve, or reject accounts.
*   `login.php` & `logout.php` — Secure user authentication matching against database records.
*   `register.php` — Comprehensive candidate signup form capturing multi-attribute details.

---

## 🚀 Step-by-Step Award Space Deployment Instructions

### Step 1: Create Your Account and Domain on Award Space
1. Go to [Award Space (awardspace.com)](https://www.awardspace.com/) and sign up for a free or premium hosting account.
2. Once logged in, go to the **Domain Manager** in your Control Panel.
3. Register a free subdomain (e.g., `bondhonbd.atwebpages.com`) or link your custom domain (e.g., `bondhonbd.com`).

### Step 2: Set Up the MySQL Database
1. Inside the Award Space Control Panel, navigate to **Database Manager** (under the Hosting Tools section).
2. Click **Create Database**. Enter a database name (e.g., `bondhon`) and set a password. Note these down.
3. Once created, copy the following fields displayed in your Database Manager table:
   *   **Database Name** (often formatted with a prefix like `1234567_bondhon`)
   *   **Database User** (often matches database name, e.g. `1234567_bondhon`)
   *   **Database Host** (e.g., `fdb1030.awardspace.net` or `localhost`)

### Step 3: Import the Database Schema
1. In the **Database Manager**, click on the **phpMyAdmin** link next to your newly created database. This will open the MySQL admin portal.
2. In phpMyAdmin, click the **Import** tab in the top menu.
3. Click **Choose File** and select the `schema.sql` file from this package.
4. Scroll to the bottom and click **Go** (or **Import**). This will automatically create the `profiles` table and pre-load several premium candidates and an administrator account for immediate testing!

### Step 4: Configure Database Connection in `db.php`
1. Open the `db.php` file using a text editor (e.g., Notepad, VS Code) or directly in Award Space's File Manager.
2. Replace the configuration constants with your actual Award Space database credentials:
   ```php
   define('DB_HOST', 'fdb1030.awardspace.net'); // Replace with your 'Database Host'
   define('DB_NAME', '1234567_bondhon');       // Replace with your 'Database Name'
   define('DB_USER', '1234567_bondhon');       // Replace with your 'Database User'
   define('DB_PASS', 'YourDatabasePassword');  // Replace with your 'Database Password'
   ```
3. Save and close the file.

### Step 5: Upload Your Files
1. Go to the **File Manager** inside your Award Space Control Panel.
2. Navigate to your website's root folder (usually named `public_html` or named after your domain, like `bondhonbd.atwebpages.com`).
3. Upload all the files inside the `php-export/` directory directly into that folder. (Do not upload the folder itself; upload the individual files so `index.php` is in the main directory).
4. *Alternatively, you can use an FTP client (like FileZilla) with the FTP Host, Username, and Password provided in the Award Space Control Panel to upload files.*

---

## 🎯 Testing Your Live Site

Open your browser and navigate to your domain (e.g., `http://bondhonbd.atwebpages.com`). Your website is now live!

### Demo Accounts to Test:
*   **Member Account:**
    *   **Email:** `ayesha@example.com`
    *   **Password:** `admin123`
*   **Admin Control Panel Account:**
    *   **Email:** `admin@bondhon.com`
    *   **Password:** `admin123`

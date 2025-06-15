# CSD Intranet

CSD Intranet is a web-based application designed to manage employee attendance, organizational events, report generation, and provide a personalized dashboard for users. This system is built using PHP, Tailwind CSS, and MySQL.

## Features

- **Attendance**: Track and manage employee attendance records efficiently.
- **Events**: Stay updated with organizational events and activities.
- **Reports**: Generate and view various reports and documents.
- **Dashboard**: Access a personalized dashboard with quick links to all features.

## Prerequisites

- **XAMPP**: Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
- **Composer**: Download and install Composer from [https://getcomposer.org/](https://getcomposer.org/)
- **Git** (optional): For cloning the repository

## Installation & Setup in XAMPP

### Step 1: Download/Clone the Project

**Option A: Clone with Git**
```bash
cd C:\xampp\htdocs
git clone https://github.com/yourusername/csd-intranet.git
```

**Option B: Manual Download**
- Download the project files
- Extract to `C:\xampp\htdocs\csd-intranet`

### Step 2: Install Dependencies

1. Open Command Prompt or PowerShell as Administrator
2. Navigate to the project directory:
   ```powershell
   cd C:\xampp\htdocs\csd-intranet
   ```
3. Install PHP dependencies using Composer:
   ```powershell
   composer install
   ```

### Step 3: Start XAMPP Services

1. Open XAMPP Control Panel
2. Start the following services:
   - **Apache** (Web Server)
   - **MySQL** (Database Server)

### Step 4: Set Up the Database

1. Open your web browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Create a new database:
   - Click "New" in the left sidebar
   - Enter database name: `csd_intranet`
   - Click "Create"
3. Import the database schema:
   - Select the `csd_intranet` database
   - Click "Import" tab
   - Choose file: `database/schema.sql` from your project folder
   - Click "Go" to import

### Step 5: Configure Database Connection

1. Open `src/config/database.php` in a text editor
2. Update the database configuration with XAMPP default settings:
   ```php
   <?php
   $host = 'localhost';
   $dbname = 'csd_intranet';
   $username = 'root';        // Default XAMPP MySQL username
   $password = '';            // Default XAMPP MySQL password (empty)
   $port = 3306;              // Default MySQL port
   ?>
   ```

### Step 6: Set Up Virtual Host (Optional but Recommended)

1. Open `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Add the following virtual host configuration:
   ```apache
   <VirtualHost *:80>
       DocumentRoot "C:/xampp/htdocs/csd-intranet/src"
       ServerName csd-intranet.local
       <Directory "C:/xampp/htdocs/csd-intranet/src">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```
3. Open `C:\Windows\System32\drivers\etc\hosts` as Administrator
4. Add this line:
   ```
   127.0.0.1    csd-intranet.local
   ```
5. Restart Apache from XAMPP Control Panel

### Step 7: Access the Application

**Option A: With Virtual Host**
- Open your browser and go to: [http://csd-intranet.local](http://csd-intranet.local)

**Option B: Direct Access**
- Open your browser and go to: [http://localhost/csd-intranet/src](http://localhost/csd-intranet/src)

### Step 8: Run Setup Script (If Available)

If there's a setup script, run it from the browser:
```
http://localhost/csd-intranet/setup.php
```

## Troubleshooting

### Common Issues

1. **Apache won't start**
   - Check if port 80 is being used by another application (like Skype, IIS)
   - Change Apache port in XAMPP or stop the conflicting service

2. **MySQL won't start**
   - Check if port 3306 is being used by another MySQL installation
   - Stop other MySQL services or change the port

3. **Database connection errors**
   - Verify MySQL is running in XAMPP
   - Check database credentials in `src/config/database.php`
   - Ensure the database `csd_intranet` exists

4. **Permission issues**
   - Make sure XAMPP has proper file permissions
   - Run XAMPP Control Panel as Administrator

5. **Composer not found**
   - Install Composer globally or use the full path to composer.phar
   - Add Composer to your system PATH

### File Permissions

Make sure the following directories are writable:
- `src/assets/uploads/` (if exists)
- `src/logs/` (if exists)

## Development Notes

- The application root is in the `src/` directory
- Database schema is located in `database/schema.sql`
- Configuration files are in `src/config/`
- Make sure to backup your database before making changes

## Usage

- Navigate to the dashboard to get an overview of your attendance, events, and reports.
- Use the attendance section to manage employee attendance records.
- Check the events section for upcoming organizational activities.
- Generate reports as needed from the reports section.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any enhancements or bug fixes.

## License

This project is licensed under the MIT License. See the LICENSE file for details.
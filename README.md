# CSD Intranet

CSD Intranet is a web-based application designed to manage employee attendance, organizational events, report generation, and provide a personalized dashboard for users. This system is built using PHP, Tailwind CSS, and MySQL.

## Features

- **Attendance**: Track and manage employee attendance records efficiently.
- **Events**: Stay updated with organizational events and activities.
- **Reports**: Generate and view various reports and documents.
- **Dashboard**: Access a personalized dashboard with quick links to all features.

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/csd-intranet.git
   ```

2. Navigate to the project directory:
   ```
   cd csd-intranet
   ```

3. Install dependencies using Composer:
   ```
   composer install
   ```

4. Set up the database:
   - Import the `database/schema.sql` file into your MySQL database.

5. Configure the database connection:
   - Update the `src/config/database.php` file with your database credentials.

6. Start the server:
   ```
   php -S localhost:8000 -t src
   ```

7. Access the application in your web browser at `http://localhost:8000`.

## Usage

- Navigate to the dashboard to get an overview of your attendance, events, and reports.
- Use the attendance section to manage employee attendance records.
- Check the events section for upcoming organizational activities.
- Generate reports as needed from the reports section.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any enhancements or bug fixes.

## License

This project is licensed under the MIT License. See the LICENSE file for details.
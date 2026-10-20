# Web-Based Complaint Management System

A Laravel-based web application developed as an academic and portfolio project to support the submission and management of public complaints.

**Disclaimer:** This project is an independent academic/portfolio project and is not an official application of the Department of Transportation (Dinas Perhubungan). It is not affiliated with, endorsed by, or operated by the institution. Any institutional names or logos included are used only in the context of the project, subject to applicable permissions.

This repository is a cleaned portfolio copy. Environment files, local databases, logs, uploaded complaint attachments, and dependency folders have been excluded for privacy and security.

## Technology

- PHP and Laravel
- MySQL (configure a local database before running)
- Blade templates
- Vite (if applicable to your setup)

## Features

The source code includes components related to complaint submission, user authentication, complaint management, and administrator pages. The exact functionality depends on the implementation in this repository.

## Local Setup

1. Install a compatible version of PHP, Composer, MySQL, and Node.js/npm if required.
2. Clone or download this repository.
3. Install PHP dependencies:

   ```bash
   composer install
   ```

4. Copy `.env.example` to `.env` and configure your local database credentials.
5. Create an empty local database matching the `DB_DATABASE` value in `.env`.
6. Generate an application key:

   ```bash
   php artisan key:generate
   ```

7. Review the database migrations, then run:

   ```bash
   php artisan migrate
   ```

8. If frontend assets need to be built, run:

   ```bash
   npm install
   npm run build
   ```

9. Start the local development server:

   ```bash
   php artisan serve
   ```

10. Open the local URL displayed in the terminal.

## Important Notes

- Do not commit production credentials, API keys, or private information.
- Do not upload original databases containing personal or complaint data.
- Configure an administrator account securely in your local environment. Do not use hard-coded real credentials.
- Confirm that you have permission to publish the source code and any institutional logos or branding included in the project.
- This portfolio copy may require additional local configuration before it can run successfully.

## Project Purpose

This project demonstrates web development and information system implementation skills, including complaint management workflows, database integration, and administrator interface development.
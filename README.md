# PHP Nexus App

A modern PHP boilerplate with Prisma ORM integration, enabling type-safe, schema-driven database interactions. This project includes a pre-configured environment for quick setup and efficient development workflows.

## Features

- **Prisma ORM**: Use `prisma.schema` to define your database schema, migrate, and generate a `prisma.php` file for easy queries.
- **Hot Reloading**: Integrated with `nodemon` and `browser-sync` for seamless development experience.
- **Environment Variables**: Centralized configuration using `.env`.
- **Dependency Management**: Uses Composer for PHP and npm/yarn for JavaScript dependencies.

## Basic Usage

1. **Define Your Database Schema**  
   Modify `prisma/schema.prisma` to define your database schema.

2. **Run Migrations or Push Schema**  
   Use the following command to create your database structure:

   ```bash
   npx prisma migrate dev --name init
   ```

   or

   ```bash
   npx prisma db push
   ```

3. **Generated PHP Client**  
   Prisma will generate a `prisma.php` file inside `src/lib`. Use this file to interact with your database programmatically.

   Example Usage:

   ```php
   require_once 'src/lib/prisma.php';

   $prisma = new Prisma();
   $users = $prisma->user->findMany();
   print_r($users);
   ```

## Installation

### Requirements

- PHP 8.1 or higher
- Composer
- Node.js and npm/yarn

### Steps

1. Clone the repository:

   ```bash
   git clone <repository-url>
   cd php-nexus-app
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Install Node.js dependencies:

   ```bash
   npm install
   ```

   or

   ```bash
   yarn
   ```

4. Copy `.env.example` to `.env` and configure your environment variables:
   ```bash
   cp .env.example .env
   ```

## Development Workflow

### Hot Reloading

Start the development server with:

```bash
npm run dev
```

This runs:

- **PHP Server**: Powered by `nodemon` to restart on file changes.
- **Browser-Sync**: Proxies the PHP server and reloads the browser automatically.

Access the app at `http://localhost:3000`.

### Prisma Commands

- **Format Schema**:
  ```bash
  npx prisma format
  ```
- **Generate PHP Client**:
  ```bash
  npx prisma generate
  ```
- **Push Schema to Database**:
  ```bash
  npx prisma db push
  ```
- **Run Migrations**:
  ```bash
  npx prisma migrate dev --name <migration-name>
  ```

## Project Structure

```
├── scripts/         # Custom automation scripts
├── src/             # Source code (includes generated prisma.php)
├── prisma/          # Prisma schema and related files
├── .env             # Environment variables
├── composer.json    # PHP dependencies
├── package.json     # Node.js dependencies
├── yarn.lock        # Node.js lockfile
├── .gitignore       # Ignored files
```

## Environment Variables

Configure the following in your `.env` file:

- `DB_HOST`: Database host
- `DB_DATABASE`: Database name
- `DB_USERNAME`: Database username
- `DB_PASSWORD`: Database password

## License

This project is licensed under the MIT License.

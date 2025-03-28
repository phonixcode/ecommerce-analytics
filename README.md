# Setup Guide

## Prerequisites

Before you begin, ensure you have met the following requirements:

- **PHP** >= PHP 8.2+
- **Composer** (Dependency Manager for PHP)
- **MySQL** or another supported database

## Installation Steps

1. **Clone the Repository**

   Clone the project repository to your local machine:

   ```bash
    git clone https://github.com/phonixcode/ecommerce-analytics.git
    cd ecommerce-analytics
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Set up your environment file**:
   ```bash
   cp .env.example .env
   ```

4. **Generate the application key**:
   ```bash
   php artisan key:generate
   ```

5. **Configure your database**: 
   Open the `.env` file and set your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
6. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

7. **Seed the database**: 
   You can seed your database with initial data using:
   ```bash
   php artisan db:seed
   ```

9. **Re-populates Consolidated Orders Using Artisan Command**:
    To re-populates (or refreshes) the consolidated_orders table every week at Sunday midnight. consolidated_orders from the command line, run:
    ```sh
    php artisan schedule:run
    ```
    or 

    To re-populates (or refreshes) the consolidated_orders table instantly , run:
    ```sh
    php artisan consolidated-orders:refresh
    ```

10. **Access the Application**:
    ```sh
    php artisan serve

    npm run dev 
    ```
    **View:** Open `http://localhost:8000`

    **DEMO:** Open [Demo](https://ecommerce-analytice.laravel.cloud/)

### API Endpoints
- **GET /api/consolidated-orders**: Retrieve all consolidated-orders.
- **POST /api/consolidated-orders/refrash**: re-populates (or refreshes) consolidated-orders.
- **GET /api/consolidated-orders/{id}**: get a single consolidated-orders information
- **GET /api/consolidated-orders/export**: export consolidated-orders information information as an excel file

check the complete documentation here [Documentation](https://documenter.getpostman.com/view/36429449/2sB2cPiQYG).

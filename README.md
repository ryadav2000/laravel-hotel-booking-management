# Laravel Project

This is a Laravel-based web application.

## Requirements

- PHP >= 8.0
- Composer
- Laravel >= 9.x
- MySQL 


# Installation

1. Clone the repository:

```bash
git https://github.com/ryadav2000/laravel-hotel-booking-management
cd laravel-hotel-booking-management



# Install PHP dependencies:
composer install

# Set up environment file:
cp .env.example .env
php artisan key:generate


# .env file configuration
Configure your .env file

# Run database migrations:
php artisan migrate

# Serve the application:
php artisan serve


## About the Project

This Laravel-based Hotel Management System is developed to automate and manage hotel operations efficiently. It provides functionality for both hotel administrators and customers, including room management, booking, and secure online payments.

Built on Laravel's robust MVC framework, this system is ideal for small to medium-sized hotels looking to modernize their booking process and improve customer experience.

### Key Features

- Room listing with availability status
- Online room booking by registered customers
- Admin panel for managing rooms, bookings, and users
- Secure online payment integration using **Stripe**
- Email notifications for booking confirmation
- Role-based access (Admin and Customer)
- Clean, responsive UI for both admin and customer sides

This project offers a scalable solution that can be extended with additional modules like reviews, seasonal pricing, or mobile integration.
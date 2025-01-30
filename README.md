# Onfly Challenge

This README provides a basic guide to set up and use a Laravel application with Sail Docker.

## Prerequisites

- Docker
- Docker Compose
- Composer

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/luhansalimena/desafio-onfly.git
    cd desafio-onfly
    ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Copy the `.env` file:**

    ```bash
    cp .env.example .env
    ```

4. **Generate application key:**

    ```bash
    ./vendor/bin/sail php artisan key:generate
    ```

## Using Laravel Sail

Laravel Sail provides a simple command-line interface for interacting with Laravel's default Docker configuration.

1. **Start the application:**

    ```bash
    ./vendor/bin/sail up
    ```

2. **Run migrations:**

    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

3. **Access the application:**

    Open your browser and navigate to `http://localhost/api/documentation`.

4. **Login With Default User**

    Use the following credentials to login:
    
    - **Email: test@example.com** 
    - **Password: password** 

## Additional Commands

- **Stop the application:**

    ```bash
    ./vendor/bin/sail down
    ```

- **Run tests:**

    ```bash
    ./vendor/bin/sail artisan test
    ```


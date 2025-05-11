# Lara-Classic App

This project containerizes a classic Laravel application using Docker, Nginx, and Supervisor. The setup is designed to simplify the development and deployment process.

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## Installation Guide

Follow these steps to set up and run the Lara-Classic app:

### 1. Configure Environment Variables
Navigate to the `docker` [directory](../docker/.envs/lara-classic/) and copy the `app.env.example` file to `app.env`:

```bash
cp app.env.example app.env
```
You can customize the environment variables in the `docker/.env` file as needed. For example, you can change the `LARA_CLASSIC_APP_HTTP_PUBLISH_PORT` and `LARA_CLASSIC_APP_HTTPS_PUBLISH_PORT` to avoid port conflicts.

### 2. Build and Start the Containers
Run the following command to build and start the Docker containers:

```bash
docker-compose up --build -d
```
This will build the necessary images and start the containers in detached mode.

### 3. Install Laravel Dependencies
Access the `classic-app` container and install Laravel dependencies using Composer:

```bash
docker exec -it lara-projects-classic-app bash
composer install
```
### 4. Access the Application
The application will be accessible at:

  - HTTP: `http://localhost:8080` (or the port specified in LARA_CLASSIC_APP_HTTP_PUBLISH_PORT)
  - HTTPS: `https://localhost:8533` (or the port specified in LARA_CLASSIC_APP_HTTPS_PUBLISH_PORT)

### 5. Stopping the Containers
To stop the containers, run:

```bash
docker-compose down
```

## Project Structure
  - `docker/`: Contains Docker-related configuration files.
  - `lara-classic/`: The Laravel application codebase.
  - `docker-compose.yml`: Defines the services and their configurations.

## Troubleshooting
  - If you encounter permission issues, ensure the storage and bootstrap/cache directories have the correct permissions.
  - Check the logs of the `classic-app` container for errors:
  
```bash
  docker logs -f lara-projects-classic-app
```

## Tips

### 1. Set Permissions
Ensure the necessary permissions are set for the Laravel application:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```
### 2. Generate and Show Application Key
  - To generate and show the Application Key
      ```bash
      php artisan key:generate --show
      ```


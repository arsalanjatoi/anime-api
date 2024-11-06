Anime Web Application Based upon Jikan API (4.0.0)
Description
It is a simple web app to fetch the anime data from Jikan API and store the anime data in the database and it also has a endpoint where we can fetch the stored anime data based upon the slug.

Getting Started
Follow these instructions to set up and run the project locally.

Prerequisites
PHP >= 8.1
Composer
MySQL
Git

Installation
Clone the Repository

Install Dependencie
"composer install"

Environment Configuration
create a new ".env" file:
Open the ".env" file in your preferred text editor and update the database details

Create the Database
Log in to your MySQL server and create a new database:
Generate Application Key
Run the following command to generate an application key:
"php artisan key"

Run Migrations

Run database migrations to create the necessary tables:
"php artisan migrate"
"php artisan serve"

Logging
Logs are available in the "storage/logs/laravel.log" file to track request and error details.

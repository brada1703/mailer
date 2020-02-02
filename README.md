## How to run the project on a local environment

Clone project and install dependencies:
* Clone repository: `git clone https://github.com/brada1703/mailer.git`
* CD into folder: `cd mailer`
* Install composer: `composer install`
* Install NPM packages: `npm install`
* Duplicate environment file with: `cp .env.example .env`
* Create APP_KEY with: `php artisan key:generate`

Set up database:
* Open Sequel Pro
* Connect to localhost (retrieve Username and Password for upcoming step)
* Add database "mailer"

Connect to database:
* Open `mailer` folder in text editor of choice
* Open ".env" file
* Change "DB_DATABASE=laravel" to "DB_DATABASE=mailer"
* Change "DB_USERNAME=root" to "DB_USERNAME={insert your localhost Username here}"
* Change "DB_PASSWORD=" to "DB_PASSWORD={insert your localhost Password here}"

Seed database and serve page:
* Open the terminal in the "mailer" folder
* Run the migrations and seed the database: `php artisan migrate:fresh --seed`
* Serve page: `php artisan serve`
* Visit page in the browser: "http://127.0.0.1:8000/"
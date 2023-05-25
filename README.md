# Requirement

PHP 8.1 ++
Node v16 ++ 
NPM v8 ++

# How to install

1. Clone this repository
2. `composer install`
3. `php artisan key:generate`
4. `cp .env_example .env` and configure your database in .env file.
5. `php artisan migrate && php artisan db:seed --class=AdminSeeder` seeding sample user data. or you can restore db using mongorestore command
6. Install node modules.
   `npm install`,
7. Compile the scripts.
   `npm run build`,
8. Final step run the server.
   `npm run dev`,
9. RUN SSR 
   `node bootstrap/ssr/ssr.mjs`


Now test it in your browser.
## Demo User Admin
/backend/login
super@admin.test
telin1q2w3e++2023

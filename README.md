# KTS

A knowledge testing information system created as my studies finishing project ... so do not expect anything amazing, thanks

# How to install

run `composer install` to install PHP dependencies
run `npm install` to install JS dependencies
optionaly run `npm run build` to compile JS and CSS

# How to setup connection to database

- create `.env` file by duplicating `.env.example` or just creating a new file
- set `APP_NAME`
- denpending on wether it is run localy set `APP_ENV` to `local`
- do not add or remove `APP_DEBUG`
- set `APP_URL` to the URL that the system will be accessed through

- set `DB_CONNECTION` to `mysql` or other used DB engine
- set `DB_HOST` to URL/IP adress that the database is accessed through, set to `127.0.0.1` if is being run localy
- set `DB_PORT` to port used for database connection, default is `3306`
- set `DB_DATABASE` to database name, you will need to create the database in the engine before stating Laravel
- set `DB_USERNAME` to database user username used for connection
- set `DB_PASSWORD` to database user password used for connection

# How to create database tables

run `php artisan migrate:fresh --seed` to use migrations to create all tables and add starting data (after there should be a `admin` user with `password` set as password (i know))

# How to start

run `php artisan serve` to start Laravel
optionaly run `npm run build` to rebuild CSS and JS
optionaly can run `npm run dev` to start Vite in case it does not work with built resources
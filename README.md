

# README

# Campagins System

there is two ways to start the system : 
* by Laravel Sail : 
    *  ``` composer install ```
    * ``` ./vendor/bin/sail up -d```
        * required ports : 8080 , 3306 , 8082 
    * ``` ./vendor/bin/sail php artisan migrate ```
    *  ``` ./vendor/bin/sail npm install && npm run dev ```
* by Artisan : 
    * ``` php artisan serve```
    * ``` php artisan migrate ```
    * ``` npm install && npm run dev ```

# run tests :
* by sail : ``` ./vendor/bin/sail php artisan test ```
* by artisan : ``` php artisan test ```

Endpoints : 

| route | Description | HTTP Verb
| --- | --- | ---
| `/campaigns/` | List all *campaigns*  | GET 
| `/campaigns/` | CREATE new campaign  | POST
| `/campaigns/:id` | update an campaign  | UPDATE


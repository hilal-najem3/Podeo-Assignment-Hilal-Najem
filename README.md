## About 
Podeo-Assignment-Hilal-Najem

This laravel web application hepls in managing podcasts that can have one or more episodes that need their respective crud implementation.

## Intsallation Steps

1. Download the app
2. Navigate to app folder using terminal
3. Run command `composer install`
4. Update .env file by generating app key, adding a mysql connection
	1. Command: `php artisan k:g`
	2. Add your database
	4. Command: `php artisan cache:clear && php artisan config:cache && php artisan view:cache && php artisan view:clear && php artisan route:clear && php artisan optimize:clear && composer dump-autoload`
5. Migrate the database with seeding `php artisan migrate:fresh --seed`
6. Run `php artisan storage:link` if you are working on localhost
7. Run the app.

## Important Information

1. This application is a showcase of what I can do in a CRUD system
2. **By far** this application doesn't take into consideration the best practices for software and web development.
3. **I am trying to show the different ways to approach a certain development idea.**
4. All the work for this applicattion are on `http://localhost:8000/admin` route. `So testers need to login as admins only.`
5. `And testers need to first read the migrations and seeds as a first step`
6. The important parts needed for testing:
	1. Login guard on admin
	2. CRUD on Podcasts table
	3. Roles and Permissions effect in managing Podcasts in `Admin/PodcastsController`
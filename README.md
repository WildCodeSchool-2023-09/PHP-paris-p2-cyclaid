# Simple MVC

## Description

This repository is a simple PHP MVC structure from scratch.

It uses some cool vendors/libraries such as Twig and Grumphp.
For this one, just a simple example where users can choose one of their databases and see tables in it.

## Steps

1. Clone the repo from Github.
2. Run `composer install`.
3. Create _config/db.php_ from _config/db.php.dist_ file and add your DB parameters. Don't delete the _.dist_ file, it must be kept.
   ## The DB_name is : 'cyclaid'.
```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PASSWORD', 'your_db_password');
```

4. Import _database.sql_ in your SQL server, you can do it manually or use the _migration.php_ script which will import a _database.sql_ file.
5. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
6. Go to `localhost:8000` with your favorite browser.
7. From this starter kit, create your own web application.

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command :

`git config --global core.autocrlf true`

## Accessible URLs

The accessible URLs are :

-   Home page at [localhost:8000/](localhost:8000/)
-   Post category [localhost:8000/categories/index](localhost:8000/categories/index)
-   Post category filter list [localhost:8000/category/results](localhost:8000/category/results)
-   Post index [localhost:8000/post/index](localhost:8000/post/index)
-   Post show details [localhost:8000//post/show?id=](localhost:8000/post/show?id=)
-   Item add [localhost:8000/post/add](localhost:8000/post/add)


You can find all these routes declared in the file `src/routes.php`. This is the very same file where you'll add your own new routes to the application.

## User Journey

Hello dear user and welcome to the Cycl'aid community. To start your amzingly incredible journey with us, you'lle have to understand how the website works. 

Thank god, you're at the right place for that.

The website works on a token exchange system : if you want to get a free spare part to improve and/r fix your bike, you'lle have to give one as well.

Once you give a part, you get a token wich can be exchanged for another spare part. and the cycle goes on ! 

Once you've created your account, you'll get a free token.

To get a part, you can search for it via the searchbar or via the categories by clicking on the magnifying glass. If you want to see all the available parts you just have to click on the book.

Once you clicked on the part card, you'll see a button to get it at the button of the screen, be careful, clicking on it will cost you a token after the last validation wich would have appeared on your screen.

To get a new token, you'lle have to post a part. In order to accomplish that you can fill out the form accessible via the "post your part" button, located either on the navbar or at the bottom of most of the pages.

Fill out the form, be aware of the following rules concerning images :

-the only accepted formats are JPEG, JPG, PNG, WEBP.
-the maximum size of all the files should not exceed 10 Mbits.
-the maximum amount of pictures per post is four.
-if you want to post multiples pictures, you have to post them all at once.

enjoy !
# Laravel in WordPress Theme

Laravel is a web application framework with expressive, elegant syntax. It's one of the most popular PHP frameworks today.

laraveltheme brings the Laravel Framework into WordPress, which allow us to have all the benefits of Laravel. So you can create themes with less effort, more enjoyment!


## Requirement
php 7.2

## What's the diffrence between the original Laravel?

I'd say almost no differences there, except some additional tweaking, which gets Laravel to work well inside a WordPress theme. So basically you could do anything that you could do with Laravel, it's just the regular Laravel inside a WordPress theme. If you are curious about what exactly have been modified, taking a diff to the original Laravel would make sense for you.


# Get Started

## Installation
copy files inside empty folder in wordpress wp-content/themes

and before you active the theme open your cmd and install composer

ex : cd wp-content\themes\laraveltheme-master

and run this command > composer install

then activate the theme

Note that **the MySQL server and the web server must be running before you can issue the `composer create-project` command** to install laraveltheme. Because after Composer finishes the installation, it's going to run an artisan command, which requires MySQL server and the web server that host the WordPress be running at the time you issuing the command.

Also, notice that if you are on Mac and use MAMP or similar application to create your local server environment you may need to change your `$PATH` environment variable to make Composer use the PHP binary that MAMP provides rather than the OS's built-in PHP binary.

## Routing
laraveltheme replaced the original `UriValidator`(`Illuminate\Routing\Matching\UriValidator`) with its own one to allow you to specify WordPress specific routes, like "archive" or "page" or "custom post type" ex.

To define a WordPress specific route, just by providing a "page type" as the first argument.

For example:

```php
// The "about" page
Route::any('page.about', Controller@method);

// The child page "works" of "about".
Route::any('page.about.works', Controller@method);

// Any child page of "about".
Route::any('page.about.*', Controller@method);

// Any descendant page of "about".
Route::any('page.about.**', Controller@method);

// Grouping multiple routes that sharing a common `prefix`.
Route::group(['prefix' => 'page'], function () {
    
    Route::any('about.contact', function () {
        return 'Foo'; // equivalent to <page.about.contact>
    });
    
    Route::any('service.*.price', function () {
        return 'Bar'; // equivalent to <page.service.*.price>
    });
    
});


// IMPORTANT !
//
// Routes that has a higher specificity should be 
// placed more above(earlier) than the routes that have a lower specificity.
// Why? If you place the routes that have a lower specificity,
// the subsequent routes that have a higher specificity will be ignored.
//
// The following routes have a lower specificity than the above ones.
// So you want to place them here.

// Generic pages
Route::any('page', Controller@method);

// Front page
Route::any('front_page', Controller@method); 

// Post archive index page
Route::any('archive', Controller@method);

```

Here's some notes you should keep in mind.

* You can use a "dot notation" to specify the hierarchy for pages and taxonomies.
* You can use the wild card to specify any child/descendant page/term of a parent/ancestor page/term.
* You should care about the order of your routes. Routes that has a higher specificity should be placed more above than the routes that have a lower specificity.

What's more, you can even write your own routes by URI, and it just works.

```php
// This will use the original UriValidator of Laravel.
Route::get('/my/endpoint', function () {
    return 'Magic!';
});
```

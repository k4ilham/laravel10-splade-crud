# Install Laravel 10
composer create-project --prefer-dist laravel/laravel:^10.0 splade-tutorial 

# Link Storage
php artisan storage:link 

# run laravel
php artisan serve

# Install splade
composer require protonemedia/laravel-splade

# Make Asset Frontend
php artisan splade:install 

change file postcss.config.js

module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
};

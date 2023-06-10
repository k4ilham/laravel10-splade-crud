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

npm run build
php artisan serve

# make model and migrations
php artisan make:model Post -m

 public function up(): void
  {
      Schema::create('posts', function (Blueprint $table) {
          $table->id();
          $table->string('title');
          $table->string('image');
          $table->string('content');
          $table->timestamps();
      });
  }

model post.php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['title', 'image', 'content'];
}


php artisan migrate



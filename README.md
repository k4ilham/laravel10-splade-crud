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

<pre><code class="language-javascript">
module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
};
</code></pre>

npm run build
php artisan serve

# make model and migrations
php artisan make:model Post -m

<pre><code class="language-php">
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
</code></pre>

model post.php

<pre><code class="language-php">
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
</code></pre>


php artisan migrate

# read data

php artisan make:controller PostController

PostController.php

<pre><code class="language-php">
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;

class PostController extends Controller
{
    /**
     * display all post data
     */
    public function index()
    {
        // get all post data
        $posts = Post::latest()->paginate(7);

        // render view
        return view('posts.index', [
            'posts' => SpladeTable::for($posts)
            ->column('image')
            ->column('title')
            ->column('content')
            ->column('action')
        ]);
    }
}
</code></pre>

route web.php

<pre><code class="language-php">
use App\Http\Controllers\PostController;
Route::resource('/posts', PostController::class);
</code></pre>

php artisan r:l --name=posts

resources/views/post/index.blade.php

<pre><code class="language-php">
<x-layout>
    <x-slot name="header">
        {{ __('Posts') }}
    </x-slot>
    <x-panel>
        <!-- btn create -->
        <div class="flex">
            <Link href="/posts/create"
                class="px-4 py-2 bg-gray-100 rounded-md text-sm border flex items-center gap-2 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                <path d="M9 12l6 0"></path>
                <path d="M12 9l0 6"></path>
            </svg>
            Add New Post
            </Link>
        </div>
        <!-- table component -->
        <x-splade-table :for="$posts">
            <x-slot:empty-state>
                <div class="flex text-center justify-center text-red-500">There are no items to show</div>
                </x-slot>
                @cell('image', $posts)
                    <img src="{{ asset('/storage/posts/' . $posts->image) }}" class="rounded-md w-1/3" />
                @endcell
                <!-- action button -->
                @cell('action', $posts)
                    <div class="flex gap-2">
                        <Link href="{{ route('posts.edit', $posts->id) }}"
                            class="rounded-full p-2 bg-orange-300 text-white hover:bg-orange-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit w-5 h-5"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                            <path d="M16 5l3 3"></path>
                        </svg>
                        </Link>
                    </div>
                @endcell
        </x-splade-table>
    </x-panel>
</x-layout>
</code></pre>

resource/views/components/navigation.blade.php

<pre><code class="language-php">
<x-splade-data default="{ open: false }">
    <nav class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}">
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('docs') }}" :active="request()->routeIs('docs')">
                            {{ __('Documentation') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts*')">
                            {{ __('Posts') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="data.open = ! data.open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path v-bind:class="{'hidden': data.open, 'inline-flex': ! data.open }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path v-bind:class="{'hidden': ! data.open, 'inline-flex': data.open }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div v-bind:class="{'block': data.open, 'hidden': ! data.open }" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('docs') }}" :active="request()->routeIs('docs')">
                    {{ __('Documentation') }}
                </x-responsive-nav-link>
            </div>
        </div>
    </nav>
</x-splade-data>
</code></pre>


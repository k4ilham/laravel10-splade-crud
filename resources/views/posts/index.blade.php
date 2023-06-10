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
                        <x-splade-form action="{{ route('posts.destroy', $posts->id) }}" confirm="Delete Data"
                            confirm-text="Are you sure you want to delete your post data?"
                            confirm-button="Yes, delete everything!" cancel-button="No, I want to stay!" method="delete">
                            <button type="submit" class="rounded-full p-2 bg-rose-300 text-white hover:bg-rose-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash w-5 h-5"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="1.2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7l16 0"></path>
                                    <path d="M10 11l0 6"></path>
                                    <path d="M14 11l0 6"></path>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg>
                            </button>
                        </x-splade-form>
                    </div>
                @endcell
        </x-splade-table>
    </x-panel>
</x-layout>
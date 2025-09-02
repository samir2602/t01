<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="post" action="{{ route('post.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Post Title')" />
                            <x-text-input id="post_title" name="post_title" type="text" class="mt-1 block w-full" :value="old('post_title')" autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('post_title')" />
                        </div>
                        <div>
                            <x-input-label for="name" :value="__('Post Content')" />
                            <textarea class="form-control" name="post_content" id="post_content" rows="3">{{ old('post_content') }} </textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('post_content')" />
                        </div>
                        <div>
                            <x-input-label for="name" :value="__('Post Author')" />
                            <x-text-input id="post_auther" name="post_auther" type="text" class="mt-1 block w-full" :value="old('post_auther')" autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('post_auther')" />
                        </div>
                        
                        <div>
                            <x-input-label for="name" :value="__('Post Tags')" />
                            @foreach($tag as $tg)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="tag_{{ $tg->id }}" name="tag_ids[]" value="{{ $tg->id }}">
                                <label class="form-check-label" for="tag_{{ $tg->id }}">{{ $tg->tag_name }}</label>
                            </div>
                            @endforeach
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Post Category')" />
                            @foreach($category as $ct)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="tag_{{ $ct->id }}" name="category_id" value="{{ $ct->id }}">
                                <label class="form-check-label" for="tag_{{ $ct->id }}">{{ $ct->category_name }}</label>
                            </div>
                            @endforeach
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Post Image')" />
                            <x-text-input id="post_image" name="post_image" type="file" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('post_image')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-links href="/tag">Back</x-links>
                            <x-primary-button>{{ __('Add') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
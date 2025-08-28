<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">                    
                    <form method="post" action="{{ route('category.store') }}" class="mt-6 space-y-6">
                        @csrf                        
                        <div>
                            <x-input-label for="name" :value="__('Category name')" />
                            <x-text-input id="category_name" name="category_name" type="text" class="mt-1 block w-full" :value="old('category_name')" autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('category_name')" />
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <x-links href="/category">Back</x-links>
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
    </div>
</x-app-layout>

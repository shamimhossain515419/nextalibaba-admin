@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Edit Category
            </h2>
            <nav>
                <!-- Success message -->
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                           href="{{ route('dashboard') }}">
                            Home
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2"
                                      stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                           href="{{ route('inventory.category.index') }}">
                            Category
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2"
                                      stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">
                        Edit Category
                    </li>
                </ol>
            </nav>
        </div>
        <form action="{{ route('inventory.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Products Description Section -->
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Category Description</h2>
                    </div>
                    <div class="p-4 sm:p-6 dark:border-gray-800">
                        <div class="grid grid-cols-1 gap-5 ">
                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Category Name
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                       placeholder="Enter category name" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Images Section -->
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Category Images</h2>
                    </div>
                    <div class="p-4 sm:p-6">
                        <!-- Current Image Preview -->
                        @if($category->image)
                            <div class="mb-4">
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Current Image
                                </label>
                                <div class="inline-block">
                                    <img src="{{ asset('storage/'. $category->image) }}"
                                         alt="{{ $category->name }}"
                                         class="h-32 w-32 rounded-lg object-cover border border-gray-200 dark:border-gray-700"
                                         id="currentImage"
                                         onerror="this.src='https://via.placeholder.com/128'">
                                </div>
                            </div>
                        @endif

                        <!-- New Image Upload -->
                        <label for="image"
                               class="block cursor-pointer rounded-lg border-2 border-dashed border-gray-300 transition hover:border-blue-500 dark:border-gray-800">
                            <div class="flex justify-center p-10">
                                <div class="flex max-w-65 flex-col items-center gap-4">
                                    <div
                                        class="inline-flex h-13 w-13 items-center justify-center rounded-full border border-gray-200 text-gray-700 transition dark:border-gray-800 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M20.0004 16V18.5C20.0004 19.3284 19.3288 20 18.5004 20H5.49951C4.67108 20 3.99951 19.3284 3.99951 18.5V16M12.0015 4L12.0015 16M7.37454 8.6246L11.9994 4.00269L16.6245 8.6246"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                                        <span class="font-medium text-gray-800 dark:text-white/90">Click to upload new image</span> or drag and drop
                                        <br>SVG, PNG, JPG or GIF (MAX. 800x400px)
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        Leave empty to keep current image
                                    </p>
                                </div>
                            </div>
                            <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="previewNewImage(event)">
                        </label>

                        <!-- New Image Preview -->
                        <div id="newImagePreview" class="mt-4 hidden">
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                New Image Preview
                            </label>
                            <div class="inline-block">
                                <img src="" alt="New image preview"
                                     class="h-32 w-32 rounded-lg object-cover border border-gray-200 dark:border-gray-700"
                                     id="previewImg">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('inventory.category.index') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-200 px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-500 px-4 py-3 text-sm font-medium text-white transition hover:bg-blue-600">
                        Update Category
                    </button>
                </div>
            </div>
        </form>

    </div>

    <script>
        function previewNewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('newImagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

@endsection

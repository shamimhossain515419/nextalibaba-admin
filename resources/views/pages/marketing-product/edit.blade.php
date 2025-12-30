@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Edit Marketing Product
            </h2>
            <nav>
                <!-- Success message -->
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Error messages -->
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
                           href={{route("dashboard")}}>
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
                           href={{route("marketingProduct.index")}}>
                            Marketing Product
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2"
                                      stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">
                        Marketing Product
                    </li>
                </ol>
            </nav>
        </div>
        <form action="{{ route('marketingProduct.update',$product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @method('patch')
            <input type="hidden" autocomplete="off">
            <div class="space-y-6">
                <!-- Products Description Section -->
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Product Description</h2>
                    </div>
                    <div class="p-4 sm:p-6 dark:border-gray-800">
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="name"
                                       class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Product
                                    Name</label>
                                <input type="text" name="name"
                                       value="{{ old('name', $product->name) }}"
                                       class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                       placeholder="Enter product name" required>
                            </div>
                            <div>
                                <label for="sku"
                                       class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Product
                                    Title</label>
                                <input type="text" id="title" name="title"
                                       value="{{ old('title', $product->title) }}"
                                       class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                       placeholder="Enter product name" required>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Category
                                </label>
                                <div class="relative z-20 bg-transparent">
                                    <select
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        :class="isOptionSelected &amp;&amp; 'text-gray-800 dark:text-white/90'"
                                        name="category_id" required>
                                        <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            Select Category
                                        </option>

                                        @foreach($categories as $category)
                                            <option  value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span
                                        class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                              <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                          </span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>


                <!-- Product Image -->
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Product Image</h2>
                    </div>
                    <div class="p-4 sm:p-6">
                        <label for="image" class="flex cursor-pointer items-center justify-center rounded border-2 border-dashed p-6">
                            Click to upload image
                            <input type="file" name="image" id="image" class="hidden" accept="image/*">
                        </label>

                        <!-- Preview -->
                        <div id="imagePreview" class="mt-4 hidden relative w-40 h-40">
                            <img id="previewImg" class="h-full w-full object-cover rounded border" />
                            <button id="removeImage" class="absolute top-1 right-1 h-6 w-6 rounded-full bg-red-600 text-white text-sm flex items-center justify-center hover:bg-red-700">&times;</button>
                        </div>

                        <div class="py-5 md:max-w-[80%]">
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="h-32 w-full object-cover rounded border">
                        </div>
                    </div>


                </div>


                <!-- Buttons -->
                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-500 px-4 py-3 text-sm font-medium text-white transition hover:bg-blue-600">
                        Publish Product
                    </button>
                </div>
            </div>
        </form>

    </div>
    <script>
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const removeImageBtn = document.getElementById('removeImage');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        removeImageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            imageInput.value = '';
            previewImg.src = '';
            imagePreview.classList.add('hidden');
        });
    </script>

    <style>
        .input-field {
            height: 44px;
            width: 100%;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            background-color: transparent;
            color: #1f2937;
            font-size: 0.875rem;
        }
        .btn-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border-radius: 0.5rem;
            background-color: #3b82f6;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #fff;
            transition: background-color 0.2s;
        }
        .btn-submit:hover {
            background-color: #2563eb;
        }
    </style>

@endsection

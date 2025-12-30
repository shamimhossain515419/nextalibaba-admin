@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Add Marketing Product
            </h2>
            <nav>
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
                        Add Marketing Product
                    </li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('marketingProduct.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            <div class="space-y-6">

                <!-- Product Description -->
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Marketing Product Description</h2>
                    </div>
                    <div class="p-4 sm:p-6 dark:border-gray-800">
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Product Name
                                </label>
                                <input type="text" name="name" class="input-field" placeholder="Enter product name" required>
                            </div>
                            <div>
                                <label for="title" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Product Title
                                </label>
                                <input type="text" name="title" class="input-field" placeholder="Enter product title" required>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Category</label>
                                <select name="category_id" class="input-field" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
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
                        <div id="imagePreview" class="mt-4 hidden relative w-full md:w-[80%] h-40">
                            <img id="previewImg" class="h-full w-full object-cover rounded border" />
                            <button id="removeImage" class="absolute top-1 right-1 h-6 w-6 rounded-full bg-red-600 text-white text-sm flex items-center justify-center hover:bg-red-700">&times;</button>
                        </div>
                    </div>
                </div>
                <!-- Submit -->
                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="submit" class="btn-submit">Publish Product</button>
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

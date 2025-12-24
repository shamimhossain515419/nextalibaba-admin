@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Add Blog
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
                           href={{route("blogs.index")}}>
                            Blog
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2"
                                      stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">
                        Add Blog
                    </li>
                </ol>
            </nav>
        </div>
        <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
            @csrf
            <input type="hidden" autocomplete="off">
            <div class="space-y-6">
                <!-- Products Description Section -->
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Blog Description</h2>
                    </div>
                    <div class="p-4 sm:p-6 dark:border-gray-800">
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="name"
                                       class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Blog
                                    title</label>
                                <input type="text" name="title"
                                       class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                       placeholder="Enter title " required>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Blog Category
                                </label>
                                <div class="relative z-20 bg-transparent">
                                    <select
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                        name="category_id" required>
                                        <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            Select Blog Category
                                        </option>

                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
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


                            <div class="col-span-full">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Content
                                </label>
                                <!-- Quill Editor Container -->
                                <div id="editor" style="height: 400px; background-color: white;" class="rounded-lg border border-gray-300 dark:border-gray-700"></div>
                                <!-- Hidden textarea for form submission -->
                                <textarea name="content" id="content" style="display:none;"></textarea>
                            </div>


                            <div x-data="{ switcherToggle: false }">
                                <label for="toggle2" class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                    <div class="relative">
                                        <input type="checkbox"  name="status" id="toggle2" class="sr-only" @change="switcherToggle = !switcherToggle">
                                        <div class="block h-6 w-11 rounded-full bg-brand-500 dark:bg-brand-500" :class="switcherToggle ? 'bg-brand-500 dark:bg-brand-500' : 'bg-gray-200 dark:bg-white/10'"></div>
                                        <div :class="switcherToggle ? 'translate-x-full': 'translate-x-0'" class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear translate-x-full"></div>
                                    </div>

                                    status
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Products Images Section -->
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Blog Images</h2>
                    </div>
                    <div class="p-4 sm:p-6">
                        <label for="image"
                               class="block cursor-pointer rounded-lg border-2 border-dashed border-gray-300 transition hover:border-blue-500 dark:border-gray-800" id="imageUploadLabel">
                            <div class="flex justify-center p-10" id="uploadPlaceholder">
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
                                        <span class="font-medium text-gray-800 dark:text-white/90">Click to upload</span> or drag and drop
                                        SVG, PNG, JPG or GIF (MAX. 800x400px)
                                    </p>
                                </div>
                            </div>
                            <div id="imagePreview" class="hidden p-4">
                                <div class="relative">
                                    <img id="previewImg" src="" alt="Preview" class="w-full h-auto max-h-96 object-contain rounded-lg">
                                    <button type="button" id="removeImage" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <input type="file" name="image" id="image" class="hidden" accept="image/*">
                        </label>
                    </div>
                </div>


                <!-- Buttons -->
                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-500 px-4 py-3 text-sm font-medium text-white transition hover:bg-blue-600">
                        Publish Blog
                    </button>
                </div>
            </div>
        </form>

    </div>

    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        // Quill Editor Initialize
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write your amazing blog content here...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'font': [] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Form submit hole hidden textarea te content save hobe
        document.getElementById('blogForm').onsubmit = function() {
            var content = document.querySelector('#content');
            content.value = quill.root.innerHTML;
        };

        // Image Preview Functionality
        const imageInput = document.getElementById('image');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const removeImageBtn = document.getElementById('removeImage');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    uploadPlaceholder.classList.add('hidden');
                    imagePreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        removeImageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            imageInput.value = '';
            previewImg.src = '';
            uploadPlaceholder.classList.remove('hidden');
            imagePreview.classList.add('hidden');
        });
    </script>

    <style>
        /* Quill editor always white background */
        .ql-toolbar {
            background-color: #ffffff !important;
            border-color: #d1d5db;
        }

        .ql-container {
            background-color: #ffffff !important;
            border-color: #d1d5db;
            color: #1f2937;
        }

        .ql-editor.ql-blank::before {
            color: #9ca3af;
        }

        .ql-snow .ql-stroke {
            stroke: #374151;
        }

        .ql-snow .ql-fill {
            fill: #374151;
        }

        .ql-snow .ql-picker-label {
            color: #374151;
        }

        /* Dark mode e o white background thakbe */
        .dark .ql-toolbar {
            background-color: #ffffff !important;
            border-color: #d1d5db;
        }

        .dark .ql-container {
            background-color: #ffffff !important;
            border-color: #d1d5db;
            color: #1f2937;
        }

        .dark .ql-editor.ql-blank::before {
            color: #9ca3af;
        }

        .dark .ql-snow .ql-stroke {
            stroke: #374151;
        }

        .dark .ql-snow .ql-fill {
            fill: #374151;
        }

        .dark .ql-snow .ql-picker-label {
            color: #374151;
        }
    </style>

@endsection

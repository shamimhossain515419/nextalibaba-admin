@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Product Banner
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

                    <li class="text-sm text-gray-800 dark:text-white/90">
                       Product Banner
                    </li>
                </ol>
            </nav>
        </div>
        <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @method('POST')
            <input type="hidden" autocomplete="off">
            <div class="space-y-6">
                <!-- Products Description Section -->
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Product Description</h2>
                    </div>
                    <div class="p-4 sm:p-6 dark:border-gray-800">
                        <div class="grid grid-cols-1 gap-5 ">
                            <div>
                                <label for="name"
                                       class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Title
                                       </label>
                                <input type="text" name="name"
                                       value="{{ old('name', $banner?->name) }}"
                                       class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                       placeholder="Enter product name" required>
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Product
                                </label>
                                <div class="relative z-20 bg-transparent">
                                    <select
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                        :class="isOptionSelected &amp;&amp; 'text-gray-800 dark:text-white/90'"
                                        name="product_id" required>
                                        <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                            Select Category
                                        </option>

                                        @foreach($products as $product)
                                            <option  value="{{ $product->id }}"
                                                {{ old('product_id', $banner?->product_id) == $product?->id ? 'selected' : '' }}>{{ $product->name }}</option>
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

                        <div class="mt-8 rounded-xl overflow-hidden shadow-lg">
                            <div class="">
                                <img
                                    height="450"
                                    width="350"
                                    src="{{ $banner->product->primaryImage
                                ? asset('storage/' . $banner->product->primaryImage->image)
                                : asset('placeholder.png') }}"
                                    alt="{{ $banner->product->name }}"
                                    class="max-h-112.5 "
                                >

                                <div class="  flex items-center p-6">
                                    <div class="text-black max-w-md">
                                        <p class="text-sm mb-1">
                                            {{ $banner->product->category?->name }}
                                        </p>

                                        <h2 class="text-2xl md:text-3xl font-bold mb-3">
                                            {{ $banner->product->name }}
                                        </h2>

                                        <p class="text-xl font-semibold mb-4">
                                            ৳ {{ number_format($banner->product->base_price, 2) }}
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-500 px-4 py-3 text-sm font-medium text-white transition hover:bg-blue-600">
                        Publish Banner
                    </button>
                </div>
            </div>
        </form>

    </div>
    {{-- Preview Script --}}
    <script>
        const imagesInput = document.getElementById('images');
        const preview = document.getElementById('preview');

        let selectedFiles = [];

        imagesInput.addEventListener('change', function () {
            selectedFiles = Array.from(this.files);
            renderPreview();
        });

        function renderPreview() {
            preview.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();

                reader.onload = e => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'h-32 w-full rounded object-cover border';

                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.className =
                        'absolute top-1 right-1 h-6 w-6 rounded-full bg-red-600 text-white text-sm flex items-center justify-center hover:bg-red-700';

                    removeBtn.onclick = () => removeImage(index);

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    preview.appendChild(wrapper);
                };

                reader.readAsDataURL(file);
            });
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1);

            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));

            imagesInput.files = dataTransfer.files;
            renderPreview();
        }

        function deleteImage(id) {
            if (!confirm('Delete this image?')) return;

            fetch(`/dashboard/inventory/product/destroy-image/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`image-${id}`).remove();
                    }
                });
        }

        function setPrimary(id) {
            fetch(`/dashboard/inventory/product/set-primary/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // refresh to update primary badge
                    }
                });
        }
    </script>


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

        // Set existing content to Quill editor
        var existingContent = document.getElementById('description').value;
        if (existingContent) {
            quill.root.innerHTML = existingContent;
        }

        // Form submit hole hidden textarea te content save hobe
        document.getElementById('productForm').onsubmit = function() {
            var content = document.querySelector('#description');
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

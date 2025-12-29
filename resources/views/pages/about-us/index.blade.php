@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                About Info
            </h2>
        </div>

        {{-- Messages --}}
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

        {{-- FORM --}}
        <form action="{{ route('aboutUs.store') }}" method="POST" enctype="multipart/form-data" id="aboutForm">
            @csrf

            <div class="space-y-6">

                {{-- BASIC INFO --}}
                <div class="rounded-2xl border bg-white p-6 dark:bg-white/[0.03]">

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Title</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $about?->name) }}"
                               class="w-full rounded-lg border px-4 py-2"
                               required>
                    </div>

                    {{-- Description (Quill) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">About Info</label>

                        <div id="editor" class="h-64 border rounded bg-white"></div>

                        <textarea name="about_info" id="about_info" class="hidden">
                        {{ old('about_info', $about?->about_info) }}
                    </textarea>
                    </div>

                    {{-- About Info (Textarea) --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Description</label>
                        <textarea name="description"
                                  rows="4"
                                  class="w-full rounded-lg border px-4 py-2"
                                  placeholder="Short description...">{{ old('description', $about?->description) }}</textarea>
                    </div>
                </div>

                {{-- SOCIAL & EMAIL --}}
                <div class="rounded-2xl border bg-white p-6 dark:bg-white/[0.03] grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="email" class="w-full rounded-lg border px-4 py-2" name="support_email" value="{{ old('support_email', $about?->support_email) }}" placeholder="Support Email">
                    <input class="w-full rounded-lg border px-4 py-2" name="facebook" value="{{ old('facebook', $about?->facebook) }}" placeholder="Facebook">
                    <input class="w-full rounded-lg border px-4 py-2" name="twitter" value="{{ old('twitter', $about?->twitter) }}" placeholder="Twitter">
                    <input class="w-full rounded-lg border px-4 py-2" name="linkedin" value="{{ old('linkedin', $about?->linkedin) }}" placeholder="LinkedIn">
                    <input class="w-full rounded-lg border px-4 py-2" name="youtube" value="{{ old('youtube', $about?->youtube) }}" placeholder="https://youtube:example">
                </div>

                {{-- IMAGE UPLOAD --}}
                <div class="rounded-2xl border bg-white p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <!-- Images -->
                <div class="">
                    <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Footer Logo</label>
                    <input type="file" name="footer_logo" id="footer_logo" accept="image/*" class="mb-2">
                    @if($about?->footer_logo)
                        <img src="{{ asset('storage/images/'.$about->footer_logo) }}" class="h-20">
                    @endif
                    <div id="footerLogoPreview"></div>
                </div>

                <div class="">
                    <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Navbar Logo</label>
                    <input type="file" name="navbar_logo" id="navbar_logo" accept="image/*" class="mb-2">
                    @if($about?->navbar_logo)
                        <img src="{{ asset('storage/images/'.$about->navbar_logo) }}" class="h-20">
                    @endif
                    <div id="navbarLogoPreview"></div>
                </div>

                <div class="">
                    <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">Favicon</label>
                    <input type="file" name="favicon" id="favicon" accept="image/*" class="mb-2">
                    @if($about?->favicon)
                        <img src="{{ asset('storage/images/'.$about->favicon) }}" class="h-10">
                    @endif
                    <div id="faviconPreview"></div>
                </div>
                </div>

                {{-- SUBMIT --}}
                <div class="flex justify-end">
                    <button class="rounded-lg bg-blue-500 px-6 py-3 text-white">
                        {{ $about ? 'Update About' : 'Create About' }}
                    </button>
                </div>

            </div>
        </form>
    </div>

    {{-- Quill --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        // Quill init
        const quill = new Quill('#editor', { theme: 'snow' });

        const oldContent = document.getElementById('about_info').value;
        if (oldContent) quill.root.innerHTML = oldContent;

        document.getElementById('aboutForm').onsubmit = () => {
            document.getElementById('about_info').value = quill.root.innerHTML;
        };

        // Image preview
        function previewImage(event, field) {
            const img = document.getElementById(field + '_preview');
            img.src = URL.createObjectURL(event.target.files[0]);
            img.classList.remove('hidden');
        }


        // Image Preview
        function previewImage(inputId, previewDivId){
            const input = document.getElementById(inputId);
            const previewDiv = document.getElementById(previewDivId);

            input.addEventListener('change', function(e){
                previewDiv.innerHTML = '';
                const file = e.target.files[0];
                if(file){
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.className = 'h-20 mt-2';
                    previewDiv.appendChild(img);
                }
            });
        }

        previewImage('footer_logo','footerLogoPreview');
        previewImage('navbar_logo','navbarLogoPreview');
        previewImage('favicon','faviconPreview');
    </script>
@endsection

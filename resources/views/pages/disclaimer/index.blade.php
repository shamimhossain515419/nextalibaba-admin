@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Disclaimer
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
        <form action="{{ route('disclaimer.store') }}" method="POST" enctype="multipart/form-data" id="itemForm">
            @csrf

            <div class="space-y-6">

                {{-- BASIC INFO --}}
                <div class="rounded-2xl border bg-white p-6 dark:bg-white/[0.03]">


                    {{-- Description (Quill) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Disclaimer Description</label>

                        <div id="editor" class="h-64 border rounded bg-white"></div>

                        <textarea name="content" id="content" class="hidden">
                        {{ old('content', $data?->content) }}
                    </textarea>
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="flex justify-end">
                    <button class="rounded-lg bg-blue-500 px-6 py-3 text-white">
                        {{ $data ? 'Update Packaging' : 'Create Packaging' }}
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

        const oldContent = document.getElementById('content').value;
        if (oldContent) quill.root.innerHTML = oldContent;

        document.getElementById('itemForm').onsubmit = () => {
            document.getElementById('content').value = quill.root.innerHTML;
        };

    </script>
@endsection

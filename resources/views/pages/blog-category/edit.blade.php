@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                Edit   Blog Category
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
                           href="{{ route('blogCategory.index') }}">
                            Blog Category
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2"
                                      stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">
                        Edit Blog Category
                    </li>
                </ol>
            </nav>
        </div>
        <form action="{{ route('blogCategory.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Products Description Section -->
                <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Blog Category Description</h2>
                    </div>
                    <div class="p-4 sm:p-6 dark:border-gray-800">
                        <div class="grid grid-cols-1 gap-5 ">
                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Blog Category Name
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                       placeholder="Enter category name" required>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Buttons -->
                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('blogCategory.index') }}"
                       class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-200 px-4 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-500 px-4 py-3 text-sm font-medium text-white transition hover:bg-blue-600">
                        Update  Blog Category
                    </button>
                </div>
            </div>
        </form>

    </div>


@endsection

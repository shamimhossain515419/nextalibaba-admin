@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                All Category
            </h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                            Home
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                                      stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">
                        All Category
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="my-5 rounded-xl bg-success-100 p-3 text-success-500">
                {{ session('success') }}
            </div>
        @endif

        <!-- Card -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <!-- Card Header -->
            <div class="flex flex-col gap-5 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Category List</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Track your store's progress to boost your sales.
                    </p>
                </div>

                <a href="{{ route('inventory.category.create') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600">
                    <svg width="20" height="20" fill="none">
                        <path d="M5 10H15M10 5V15"
                              stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Add category
                </a>
            </div>

            <!-- Search -->
            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800">
                <div class="relative sm:w-[300px]">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    🔍
                </span>
                    <input id="searchInput" type="text" placeholder="Search..."
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent pl-11 pr-4 text-sm
                              focus:border-brand-300 focus:outline-none focus:ring-3 focus:ring-brand-500/10
                              dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto pb-20">
                <table class="w-full table-auto">
                    <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="px-5 py-4 text-left text-xs text-gray-500">Image</th>
                        <th class="px-5 py-4 text-left text-xs text-gray-500">Category Name</th>
                        <th class="px-5 py-4 text-left text-xs text-gray-500">Action</th>
                    </tr>
                    </thead>

                    <tbody id="categoryTableBody" class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse ($categories as $category)
                        <tr class="category-row hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                            <td class="px-5 py-4">
                                <img src="{{ asset('storage/'.$category->image) }}"
                                     class="h-12 w-12 rounded-md object-cover"
                                     onerror="this.src='https://via.placeholder.com/48'">
                            </td>

                            <td class="px-5 py-4">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-400">
                                {{ $category->name }}
                            </span>
                            </td>

                            <!-- Action -->
                            <td class="px-5 py-4">
                                <div class="relative inline-block">
                                    <button class="dropdown-trigger text-gray-500 hover:text-gray-700">
                                        ⋮
                                    </button>

                                    <!-- Dropdown -->
                                    <div class="dropdown-menu absolute right-0 z-50 mt-2 hidden w-40
                                            rounded-xl border border-gray-200 bg-white p-2 shadow-lg
                                            dark:border-gray-800 dark:bg-gray-800">
                                        <a href="{{ route('inventory.category.edit', $category->id) }}"
                                           class="block rounded-lg px-3 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:text-gray-300">
                                            Edit
                                        </a>

                                        <form method="POST"
                                              action="{{ route('inventory.category.destroy', $category->id) }}"
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full rounded-lg px-3 py-2 text-left text-sm text-red-500 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-sm text-gray-500">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        /* Dropdown */
        document.addEventListener('click', function (e) {
            const trigger = e.target.closest('.dropdown-trigger');

            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });

            if (trigger) {
                const menu = trigger.nextElementSibling;
                menu.classList.toggle('hidden');
            }
        });

        /* Search */
        document.getElementById('searchInput').addEventListener('input', function () {
            const value = this.value.toLowerCase();
            document.querySelectorAll('.category-row').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    </script>
@endsection

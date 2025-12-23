@extends('layouts.app')

@section('content')
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                All Today Hot Deal
            </h2>
            <nav>
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
                    <li class="text-sm text-gray-800 dark:text-white/90">
                        All Today Hot Deal
                    </li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div class="text-success-500 bg-success-100 my-5 p-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex flex-col justify-between gap-5 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center dark:border-gray-800">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Today Hot Deal List
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Track your store's progress to boost your sales.
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('todayHotDeal.create') }}"
                       class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M5 10.0002H15.0006M10.0002 5V15.0006" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        Add Today Hot Deal
                    </a>
                </div>
            </div>

            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800">
                <div class="flex gap-3 sm:justify-between">
                    <div class="relative flex-1 sm:flex-auto">
                        <span class="absolute top-1/2 left-4 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M3.04199 9.37363C3.04199 5.87693 5.87735 3.04199 9.37533 3.04199C12.8733 3.04199 15.7087 5.87693 15.7087 9.37363C15.7087 12.8703 12.8733 15.7053 9.37533 15.7053C5.87735 15.7053 3.04199 12.8703 3.04199 9.37363ZM9.37533 1.54199C5.04926 1.54199 1.54199 5.04817 1.54199 9.37363C1.54199 13.6991 5.04926 17.2053 9.37533 17.2053C11.2676 17.2053 13.0032 16.5344 14.3572 15.4176L17.1773 18.238C17.4702 18.5309 17.945 18.5309 18.2379 18.238C18.5308 17.9451 18.5309 17.4703 18.238 17.1773L15.4182 14.3573C16.5367 13.0033 17.2087 11.2669 17.2087 9.37363C17.2087 5.04817 13.7014 1.54199 9.37533 1.54199Z"
                                      fill=""></path>
                            </svg>
                        </span>
                        <input type="text" placeholder="Search..." id="searchInput"
                               class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-4 pl-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden sm:w-[300px] sm:min-w-[300px] dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="custom-scrollbar overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                    <tr class="border-b border-gray-200 dark:divide-gray-800 dark:border-gray-800">
                        <th class="px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                             Name
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                            Price
                        </th>
                        <th class="px-5 py-4  text-center text-xs font-medium text-gray-500 dark:text-gray-400">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-x divide-y divide-gray-200 dark:divide-gray-800" id="categoryTableBody">
                    @forelse($todayHotDeals as $item)
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900 category-row">

                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12">
                                        <img class="h-12 w-12 rounded-md" alt=""
                                             src="{{ asset('storage/'.$item?->product?->primaryImage?->image) }}">
                                    </div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-400">{{$item->product->name}}r</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-700 dark:text-gray-400">{{$item->product->base_price}}</p>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="relative flex justify-center">
                                    <button class="text-gray-500 dark:text-gray-400 dropdown-trigger">
                                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"
                                                  fill=""></path>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu shadow-theme-lg fixed w-40 space-y-1 rounded-2xl border border-gray-200 bg-white p-2 dark:border-gray-800 dark:bg-gray-800" style="display: none;">
                                        <a href="{{ route('todayHotDeal.edit', $item->id) }}"
                                           class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">
                                            Edit
                                        </a>
                                        <form action="{{ route('todayHotDeal.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Today Hot Deal?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-red-500 hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-500/10 dark:hover:text-red-300">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center">
                                <p class="text-sm text-gray-500 dark:text-gray-400">No Features Category found.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Dropdown functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.dropdown-trigger')) {
                const dropdown = e.target.closest('.dropdown-trigger').nextElementSibling;
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
            } else if (!e.target.closest('.dropdown-menu')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.category-row');

            rows.forEach(row => {
                const categoryName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (categoryName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection

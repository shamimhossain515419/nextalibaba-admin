@extends('layouts.app')

@section('content')
    <div x-data="{ openVariantModal: false }" class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                All Variant Attribute
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
                        All Variant Attribute
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="text-success-500 bg-success-100 my-5 p-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="text-red-500 bg-red-100 my-5 p-3 rounded-xl">
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

        <!-- Table Container -->
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <!-- Table Header -->
            <div class="flex flex-col justify-between gap-5 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center dark:border-gray-800">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Variant Attribute List
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Track your store's progress to boost your sales.
                    </p>
                </div>
                <!-- Add Variant Button -->
                <button @click="openVariantModal = true"
                        class="rounded-lg bg-indigo-500 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-600">
                    Add Variant
                </button>
            </div>

            <!-- Search -->
            <div class="border-b border-gray-200 px-5 py-4 dark:border-gray-800">
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

            <!-- Table -->
            <div class="custom-scrollbar overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                    <tr class="border-b border-gray-200 dark:divide-gray-800 dark:border-gray-800">
                        <th class="px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Variant</th>
                        <th class="px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Attribute</th>
                        <th class="px-5 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-x divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($mappings as $product)
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="px-5 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->variant->name }}</p>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $product->attribute->name }}</p>
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
                                        <a href="{{ route('inventory.product.edit', $product->id) }}" class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">Edit</a>
                                        <form action="{{ route('inventory.product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-red-500 hover:bg-red-50 hover:text-red-700 dark:text-red-400 dark:hover:bg-red-500/10 dark:hover:text-red-300">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-sm text-gray-500 dark:text-gray-400">No variant found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="openVariantModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div @click.away="openVariantModal = false" class="w-full max-w-lg rounded-2xl bg-white p-6 dark:bg-gray-900">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Add Variant Attribute</h2>
                    <button @click="openVariantModal = false" class="text-gray-400 hover:text-red-500">✕</button>
                </div>

                <form action="{{ route('inventory.product.variantStore') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-400">Variant</label>
                            <select name="variant_id" required class="h-11 w-full rounded-lg border px-4 dark:bg-gray-900 dark:border-gray-700">
                                <option value="">Select Variant</option>
                                @foreach($variants as $variant)
                                    <option value="{{ $variant->id }}">{{ $variant->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-400">Attribute</label>
                            <select name="attribute_id" required class="h-11 w-full rounded-lg border px-4 dark:bg-gray-900 dark:border-gray-700">
                                <option value="">Select Attribute</option>
                                @foreach($attributes as $attribute)
                                    <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @php
                      @endphp
                        <input type="hidden" name="product_id" value="{{ old('product_id', $product_id) }}">

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" @click="openVariantModal = false" class="rounded-lg border px-4 py-2 text-sm">Cancel</button>
                            <button type="submit" class="rounded-lg bg-blue-500 px-4 py-2 text-sm text-white hover:bg-blue-600">Publish Attribute</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- JS for dropdown -->
    <script>
        document.querySelectorAll('.dropdown-trigger').forEach(button => {
            button.addEventListener('click', () => {
                const menu = button.nextElementSibling;
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });
        });

        window.addEventListener('click', function(e) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (!menu.contains(e.target) && !menu.previousElementSibling.contains(e.target)) {
                    menu.style.display = 'none';
                }
            });
        });
    </script>
@endsection

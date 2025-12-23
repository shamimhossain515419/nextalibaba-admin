@extends('layouts.app')

@section('content')
    <div x-data="{
        openVariantModal: false,
        isEdit: false,
        actionUrl: '',
        variantId: '',
        attributeId: '',
        product_id: '{{ $product_id }}',
        filteredAttributes: [],

        // Function to fetch attributes based on Variant ID
        async fetchAttributes(vId, selectedAttrId = '') {
            if (!vId) {
                this.filteredAttributes = [];
                return;
            }
            try {
                const response = await fetch(`/dashboard/inventory/product/get-attributes/${vId}`);
                const data = await response.json();
                this.filteredAttributes = data;

                // If editing, set the attributeId after list loads
                if(selectedAttrId) {
                    this.attributeId = selectedAttrId;
                }
            } catch (error) {
                console.error('Error fetching attributes:', error);
            }
        },

        // Reset Modal for adding new
        resetForAdd() {
            this.isEdit = false;
            this.variantId = '';
            this.attributeId = '';
            this.filteredAttributes = [];
            this.openVariantModal = true;
        }
    }" class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
                All Variant Attribute
            </h2>
            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('dashboard') }}">
                            Home
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"><path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90">All Variant Attribute</li>
                </ol>
            </nav>
        </div>

        {{-- Session Messages --}}
        @if (session('success'))
            <div class="my-5 rounded-xl bg-green-100 p-3 text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex flex-col justify-between gap-5 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center dark:border-gray-800">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Variant Attribute List</h3>
                </div>
                <button @click="resetForAdd()" class="rounded-lg bg-indigo-500 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-600">
                    Add Variant
                </button>
            </div>

            <div class="custom-scrollbar overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800 text-left">
                        <th class="px-5 py-4 text-xs font-medium text-gray-500 uppercase">Variant</th>
                        <th class="px-5 py-4 text-xs font-medium text-gray-500 uppercase">Attribute</th>
                        <th class="px-5 py-4 text-xs font-medium text-gray-500 uppercase text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($mappings as $mapping)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                            <td class="px-5 py-4 text-sm dark:text-gray-400 font-medium">{{ $mapping->variant->name }}</td>
                            <td class="px-5 py-4 text-sm dark:text-gray-400">{{ $mapping->attribute->name }}</td>
                            <td class="px-5 py-4 text-right">
                                <div class="relative inline-block text-left">
                                    <button class="text-gray-500 dropdown-trigger p-1 hover:bg-gray-100 rounded-full transition">
                                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"><path d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"/></svg>
                                    </button>
                                    <div class="dropdown-menu absolute right-0 z-10 w-40 mt-2 origin-top-right rounded-xl border border-gray-200 bg-white p-2 shadow-lg dark:border-gray-800 dark:bg-gray-800" style="display: none;">
                                        <button @click="
                                            isEdit = true;
                                            variantId = '{{ $mapping->variant_id }}';
                                            actionUrl = '{{ route('inventory.product.variantUpdate', $mapping->id) }}';
                                            fetchAttributes(variantId, '{{ $mapping->attribute_id }}');
                                            openVariantModal = true;
                                        " class="flex w-full rounded-lg px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 dark:hover:bg-white/5 transition">Edit</button>

                                        <form action="{{ route('inventory.product.destroyVariant', $mapping->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="flex w-full rounded-lg px-3 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-8 text-center text-gray-500 italic">No variant attributes mapped yet.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openVariantModal" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div @click.away="openVariantModal = false" class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900">

                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white" x-text="isEdit ? 'Edit Mapping' : 'Add New Mapping'"></h2>
                    <button @click="openVariantModal = false" class="text-gray-400 hover:text-red-500 transition text-2xl">&times;</button>
                </div>

                <form :action="isEdit ? actionUrl : '{{ route('inventory.product.variantStore') }}'" method="POST">
                    @csrf
                    <template x-if="isEdit"><input type="hidden" name="_method" value="PUT"></template>

                    <div class="space-y-5">
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">Variant</label>
                            <select name="variant_id" x-model="variantId" @change="fetchAttributes(variantId)" required
                                    class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-white focus:ring-indigo-500 h-11 px-3 border">
                                <option value="">-- Select Variant --</option>
                                @foreach($variants as $variant)
                                    <option value="{{ $variant->id }}">{{ $variant->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-gray-700 dark:text-gray-300">Attribute</label>
                            <select name="attribute_id" x-model="attributeId" required :disabled="!variantId"
                                    class="w-full rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-white focus:ring-indigo-500 h-11 px-3 border disabled:opacity-50">
                                <option value="">-- Select Attribute --</option>
                                <template x-for="attr in filteredAttributes" :key="attr.id">
                                    <option :value="attr.id" x-text="attr.name" :selected="attr.id == attributeId"></option>
                                </template>
                            </select>
                            <p x-show="!variantId" class="text-xs text-indigo-500 mt-1">Please select a variant first.</p>
                        </div>

                        <input type="hidden" name="product_id" :value="product_id">

                        <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-800">
                            <button type="button" @click="openVariantModal = false"
                                    class="rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 transition">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="rounded-lg bg-indigo-600 px-5 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition"
                                    x-text="isEdit ? 'Update Now' : 'Save Mapping'"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.dropdown-trigger').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const menu = button.nextElementSibling;
                document.querySelectorAll('.dropdown-menu').forEach(m => { if(m !== menu) m.style.display = 'none'; });
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });
        });
        window.onclick = () => document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = 'none');
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
@endsection

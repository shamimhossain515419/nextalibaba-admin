@extends('layouts.app')

@section('content')
  <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
      <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Add Category
      </h2>
      <nav>
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
                   href={{route("inventory.category.index")}}>
                    Category
                    <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2"
                              stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a>
            </li>
          <li class="text-sm text-gray-800 dark:text-white/90">
            Add Category
          </li>
        </ol>
      </nav>
    </div>
      <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-white/[0.05] dark:bg-white/[0.03]">
          <!-- Header -->
          <div class="flex flex-col gap-4 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
              <div>
                  <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                      Recent Orders
                  </h3>
              </div>
              <div class="flex items-center gap-3">
                  <button class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                      <svg class="stroke-current fill-white dark:fill-gray-800" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z" fill="" stroke="" stroke-width="1.5"/>
                          <path d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z" fill="" stroke="" stroke-width="1.5"/>
                      </svg>
                      Filter
                  </button>
                  <button class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-3 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                      See all
                  </button>
              </div>
          </div>

          <!-- Table -->
          <div class="max-w-full overflow-x-auto">
              <table class="w-full">
                  <thead class="px-6 py-3.5 border-t border-gray-100 border-y bg-gray-50 dark:border-white/[0.05] dark:bg-gray-900">
                  <tr>
                      <th class="px-6 py-3 font-medium text-gray-500 sm:px-6 text-theme-xs dark:text-gray-400 text-start">
                          <div class="flex items-center gap-3">
                              <div @click="handleSelectAll()"
                                   class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px]"
                                   :class="selectAll ? 'border-blue-500 dark:border-blue-500 bg-blue-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700'">
                                  <svg :class="selectAll ? 'block' : 'hidden'" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path d="M11.6668 3.5L5.25016 9.91667L2.3335 7" stroke="white" stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round"/>
                                  </svg>
                              </div>
                              <span class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Deal ID</span>
                          </div>
                      </th>
                      <th class="px-6 py-3 font-medium text-gray-500 sm:px-6 text-theme-xs dark:text-gray-400 text-start">Customer</th>
                      <th class="px-6 py-3 font-medium text-gray-500 sm:px-6 text-theme-xs dark:text-gray-400 text-start">Product/Service</th>
                      <th class="px-6 py-3 font-medium text-gray-500 sm:px-6 text-theme-xs dark:text-gray-400 text-start">Deal Value</th>
                      <th class="px-6 py-3 font-medium text-gray-500 sm:px-6 text-theme-xs dark:text-gray-400 text-start">Close Date</th>
                      <th class="px-6 py-3 font-medium text-gray-500 sm:px-6 text-theme-xs dark:text-gray-400 text-start">Status</th>
                      <th class="px-6 py-3 font-medium text-gray-500 sm:px-6 text-theme-xs dark:text-gray-400 text-start">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <template x-for="row in tableRowData" :key="row.id">
                      <tr class="border-b border-gray-100 dark:border-white/[0.05]">
                          <td class="px-4 sm:px-6 py-3.5">
                              <div class="flex items-center gap-3">
                                  <div @click="handleRowSelect(row.id)"
                                       class="flex h-5 w-5 cursor-pointer items-center justify-center rounded-md border-[1.25px]"
                                       :class="selectedRows.includes(row.id) ? 'border-blue-500 dark:border-blue-500 bg-blue-500' : 'bg-white dark:bg-white/0 border-gray-300 dark:border-gray-700'">
                                      <svg :class="selectedRows.includes(row.id) ? 'block' : 'hidden'" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M11.6668 3.5L5.25016 9.91667L2.3335 7" stroke="white" stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round"/>
                                      </svg>
                                  </div>
                                  <div>
                                      <span class="block font-medium text-gray-700 text-theme-sm dark:text-gray-400" x-text="row.id"></span>
                                  </div>
                              </div>
                          </td>
                          <td class="px-4 sm:px-6 py-3.5">
                              <div class="flex items-center gap-3">
                                  <div class="flex items-center justify-center w-10 h-10 rounded-full font-medium text-sm"
                                       :class="[row.avatarBg, row.avatarColor]">
                                      <span x-text="row.initials"></span>
                                  </div>
                                  <div>
                                      <span class="mb-0.5 block text-theme-sm font-medium text-gray-700 dark:text-gray-400" x-text="row.customerName"></span>
                                      <span class="text-gray-500 text-theme-sm dark:text-gray-400" x-text="row.customerEmail"></span>
                                  </div>
                              </div>
                          </td>
                          <td class="px-4 sm:px-6 py-3.5">
                              <p class="text-gray-700 text-theme-sm dark:text-gray-400" x-text="row.product"></p>
                          </td>
                          <td class="px-4 sm:px-6 py-3.5">
                              <p class="text-gray-700 text-theme-sm dark:text-gray-400" x-text="row.value"></p>
                          </td>
                          <td class="px-4 sm:px-6 py-3.5">
                              <p class="text-gray-700 text-theme-sm dark:text-gray-400" x-text="row.closeDate"></p>
                          </td>
                          <td class="px-4 sm:px-6 py-3.5">
                                <span class="text-theme-xs inline-block rounded-full px-2 py-0.5 font-medium"
                                      :class="getStatusClass(row.status)"
                                      x-text="row.status"></span>
                          </td>
                          <td class="px-4 sm:px-6 py-3.5">
                              <button @click="deleteRow(row.id)">
                                  <svg class="text-gray-700 cursor-pointer size-5 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-500"
                                       fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                  </svg>
                              </button>
                          </td>
                      </tr>
                  </template>
                  </tbody>
              </table>
          </div>
      </div>

  </div>
@endsection

<template>
    <Head title="Transactions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transactions</h2>
        </template>

        <div class="py-12">
            
            
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <template v-if="transactions.data.length > 0">
                    <!-- Table -->
                    <div class="flex flex-col bg-white">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                <table class="min-w-full text-left text-sm font-light">
                                    <thead class="border-b border-g font-medium  ">
                                        <tr>
                                            <th scope="col" class="px-6 py-4">Date</th>
                                            <th scope="col" class="px-6 py-4">Reference No.</th>
                                            <th scope="col" class="px-6 py-4">Type</th>
                                            <th scope="col" class="px-6 py-4">Name</th>
                                            <th scope="col" class="px-6 py-4">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border-b " v-for="transaction in transactions.data">
                                            <td class="whitespace-nowrap px-6 py-4">{{ formatDate(transaction.updated_at) }}</td>
                                            <td class="whitespace-nowrap px-6 py-4">{{ transaction.reference_number }}</td>
                                            <template v-if="transaction.from.id == $page.props.auth.user.id">
                                                <td class="whitespace-nowrap px-6 py-4">Transfer To</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{ transaction.to.name }}</td>
                                            </template>
                                            <template v-else-if="transaction.to.id == $page.props.auth.user.id">
                                                <td class="whitespace-nowrap px-6 py-4">Transfer From</td>
                                                <td class="whitespace-nowrap px-6 py-4">{{ transaction.from.name }}</td>
                                            </template>
                                            <td class="whitespace-nowrap px-6 py-4">Php. {{ transaction.amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        </div>
                    <!-- Pagination -->
                    <div class="flex items-center justify-between bg-white px-4 py-3 sm:px-6">
                        <div class="flex flex-1 justify-between sm:hidden">
                            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
                            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
                        </div>
                        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                            <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ transactions.from }}</span>
                                to
                                <span class="font-medium">{{ transactions.to }}</span>
                                of
                                <span class="font-medium">{{ transactions.total }}</span>
                                results
                            </p>
                            </div>
                            <div>
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <a href="#" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                </svg>
                                </a>
                                <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
                                <!-- <a href="#" aria-current="page" class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">1</a> -->
                                
                                
                                <template v-for="link in transactions.links">
                                    <Link
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                                        :class="{'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:bg-indigo-500': link.active}"
                                        v-if="link.url"
                                        :href="link.url"
                                        v-html="link.label"
                                    ></Link>
                                </template>

                                <a href="#" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                                </a>
                            </nav>
                            </div>
                        </div>
                    </div>
                    
                </template>

                <template v-else>
                    <!-- TODO: add this to language -->
                    You have no activities yet.
                </template>
            </div>
        </div>

        
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';

    defineProps({
        transactions: Object
    })

    const formatDate = (date) => {
        return Intl.DateTimeFormat(
            'en', 
            { dateStyle: 'medium' }
        ).format(
            Date.parse('2023-04-10T06:04:40.000000Z')
        )
    }
</script>
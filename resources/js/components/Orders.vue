<template>
    <div class="p-2">
        <h2 class="text-2xl font-bold mb-4">Consolidated Orders</h2>
        <button @click="exportOrders" class="bg-gray-800 text-white px-4 py-2 mb-4 rounded cursor-pointer">
            Export to Excel
        </button>
    </div>

    <div class="p-2 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-2">Order ID</th>
                    <th scope="col" class="px-4 py-2">Customer ID</th>
                    <th scope="col" class="px-4 py-2">Customer Name</th>
                    <th scope="col" class="px-4 py-2">Customer Email</th>
                    <th scope="col" class="px-4 py-2">Product ID</th>
                    <th scope="col" class="px-4 py-2">Product Name</th>
                    <th scope="col" class="px-4 py-2">SKU</th>
                    <th scope="col" class="px-4 py-2">Quantity</th>
                    <th scope="col" class="px-4 py-2">Item Price</th>
                    <th scope="col" class="px-4 py-2">Line Total</th>
                    <th scope="col" class="px-4 py-2">Order Date</th>
                    <th scope="col" class="px-4 py-2">Order Status</th>
                    <th scope="col" class="px-4 py-2">Order Total</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="order in orders" :key="order.id"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{
                        order.order_id }}</th>
                    <td class="px-4 py-2">{{ order.customer_id }}</td>
                    <td class="px-4 py-2">{{ order.customer_name }}</td>
                    <td class="px-4 py-2">{{ order.customer_email }}</td>
                    <td class="px-4 py-2">{{ order.product_id }}</td>
                    <td class="px-4 py-2">{{ order.product_name }}</td>
                    <td class="px-4 py-2">{{ order.sku }}</td>
                    <td class="px-4 py-2">{{ order.quantity }}</td>
                    <td class="px-4 py-2">{{ order.item_price }}</td>
                    <td class="px-4 py-2">{{ order.line_total }}</td>
                    <td class="px-4 py-2">{{ order.order_date }}</td>
                    <td class="px-4 py-2">{{ order.order_status }}</td>
                    <td class="px-4 py-2">{{ order.order_total }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <!-- Pagination -->
<nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4">
    <span class="text-sm font-normal mb-4 md:mb-0 block w-full md:inline md:w-auto">
        Showing page <span class="font-semibold">{{ currentPage }}</span> of
        <span class="font-semibold">{{ lastPage }}</span>
    </span>

    <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
        <!-- Previous Button -->
        <li>
            <button @click="fetchOrders(currentPage - 1)" :disabled="currentPage === 1"
                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg
                hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400
                dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                Previous
            </button>
        </li>

        <!-- First Page -->
        <li v-if="currentPage > 5">
            <button @click="fetchOrders(1)"
                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300
                hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400
                dark:hover:bg-gray-700 dark:hover:text-white">
                1
            </button>
        </li>

        <!-- Ellipsis Before Current Page -->
        <li v-if="currentPage > 6">
            <span class="px-3 h-8 flex items-center">...</span>
        </li>

        <!-- Page Numbers -->
        <li v-for="page in visiblePages" :key="page">
            <button @click="fetchOrders(page)" :class="{'bg-blue-50 text-blue-600': page === currentPage}"
                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300
                hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400
                dark:hover:bg-gray-700 dark:hover:text-white">
                {{ page }}
            </button>
        </li>

        <!-- Ellipsis After Current Page -->
        <li v-if="currentPage < lastPage - 5">
            <span class="px-3 h-8 flex items-center">...</span>
        </li>

        <!-- Last Page -->
        <li v-if="currentPage < lastPage - 4">
            <button @click="fetchOrders(lastPage)"
                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300
                hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400
                dark:hover:bg-gray-700 dark:hover:text-white">
                {{ lastPage }}
            </button>
        </li>

        <!-- Next Button -->
        <li>
            <button @click="fetchOrders(currentPage + 1)" :disabled="currentPage === lastPage"
                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg
                hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400
                dark:hover:bg-gray-700 dark:hover:text-white disabled:opacity-50 disabled:cursor-not-allowed">
                Next
            </button>
        </li>
    </ul>
</nav>

    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            orders: [],
            currentPage: 1,
            lastPage: 1,
        };
    },
    mounted() {
        this.fetchOrders();
    },
    methods: {
        async fetchOrders(page = 1) {
            if (page < 1 || page > this.lastPage) return;

            try {
                const response = await axios.get(`/api/consolidated-orders?page=${page}`);
                const data = response.data;

                this.orders = data.data;
                this.currentPage = data.current_page;
                this.lastPage = data.last_page;
            } catch (error) {
                console.error("Error fetching orders:", error);
            }
        },
        exportOrders() {
            window.location.href = "/api/consolidated-orders/export";
        },
    },
    computed: {
        visiblePages() {
            const range = [];
            const start = Math.max(1, this.currentPage - 4);
            const end = Math.min(this.lastPage, this.currentPage + 4);

            for (let i = start; i <= end; i++) {
                range.push(i);
            }
            return range;
        },
    }
};
</script>

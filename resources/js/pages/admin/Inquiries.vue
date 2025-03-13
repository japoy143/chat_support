<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { EllipsisVertical } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Inquiries',
        href: '/admin/inquiries',
    },
];

const inquiryId = ref<null | number>(null);

const setInquiryId = (id: number) => {
    inquiryId.value = id;
};

const clearInquiryId = () => {
    inquiryId.value = null;
};

const submitStatus = (status: string, id: number) => {
    router.patch(route('admin.status.update', id), { data: status }, { preserveState: true });
};

const search = ref('');

watch(
    search,
    debounce((val: string) => router.get('/admin/inquiries', { search: val }, { preserveState: true }), 300),
);

defineProps<{
    name?: string;
    all_inquiries: object;
}>();
</script>

<template>
    <Head title="Inquiries" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 class="font-medium">All Inquiries</h1>

            <h2>Search Inquiries</h2>
            <div class="mt-2 max-w-sm space-y-3 rounded-lg border-2 border-gray-200">
                <input
                    type="text"
                    class="block w-full rounded-lg border-gray-200 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                    placeholder="This is placeholder"
                    v-model="search"
                />
            </div>

            <div class="flex-1">
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="inline-block min-w-full p-1.5 align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                    <thead>
                                        <tr>
                                            <th
                                                scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500 dark:text-neutral-500"
                                            >
                                                Email
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500 dark:text-neutral-500"
                                            >
                                                Plan
                                            </th>

                                            <th
                                                scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500 dark:text-neutral-500"
                                            >
                                                Message
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-6 py-3 text-end text-xs font-medium uppercase text-gray-500 dark:text-neutral-500"
                                            >
                                                Status
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-6 py-3 text-end text-xs font-medium uppercase text-gray-500 dark:text-neutral-500"
                                            >
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="inquiry in all_inquiries"
                                            :key="inquiry.id"
                                            class="odd:bg-white even:bg-gray-100 dark:odd:bg-neutral-900 dark:even:bg-neutral-800"
                                        >
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                {{ inquiry.email }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
                                                {{ inquiry.plan }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
                                                {{ inquiry.message }}
                                            </td>

                                            <td class="whitespace-nowrap px-6 py-4 text-end text-sm text-gray-800 dark:text-neutral-200">
                                                {{ inquiry.status }}
                                            </td>

                                            <td class="relative whitespace-nowrap px-6 py-4 text-end text-sm font-medium">
                                                <button
                                                    v-if="inquiryId === null"
                                                    @click="setInquiryId(inquiry.id)"
                                                    type="button"
                                                    class="focus:outline-hidden inline-flex items-center gap-x-2 rounded-lg border border-transparent text-sm font-semibold text-blue-600 hover:text-blue-800 focus:text-blue-800 disabled:pointer-events-none disabled:opacity-50 dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400"
                                                >
                                                    <EllipsisVertical />
                                                </button>

                                                <button
                                                    v-else
                                                    @click="clearInquiryId"
                                                    type="button"
                                                    class="focus:outline-hidden inline-flex items-center gap-x-2 rounded-lg border border-transparent text-sm font-semibold text-blue-600 hover:text-blue-800 focus:text-blue-800 disabled:pointer-events-none disabled:opacity-50 dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400"
                                                >
                                                    <EllipsisVertical />
                                                </button>
                                            </td>
                                            <div
                                                v-if="inquiry.id === inquiryId"
                                                class="absolute right-2 z-50 mt-10 flex h-[120px] w-[200px] flex-col justify-center space-y-4 rounded bg-white p-4 shadow-md"
                                            >
                                                <button
                                                    class="border-b-2 p-1 font-medium hover:bg-slate-100"
                                                    @click="submitStatus('pending', inquiry.id)"
                                                >
                                                    Pending
                                                </button>
                                                <button
                                                    class="border-b-2 p-1 font-medium hover:bg-slate-100"
                                                    @click="submitStatus('paid', inquiry.id)"
                                                >
                                                    Paid
                                                </button>
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

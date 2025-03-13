<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { EllipsisVertical } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/admin/users',
    },
];

const search = ref('');

const uppercasePlans = (word: string) => {
    return word && String(word[0].toLocaleUpperCase() + word.slice(1));
};
const form = useForm({
    plan: '',
});
const actionId = ref<number | null>(null);
const setActionId = (id: number) => {
    actionId.value = id;
};

const clearActionId = () => {
    actionId.value = null;
};

const submitSubscription = (id: any, val: string) => {
    if (val === 'Business') {
        form.plan = 'Business';
    } else {
        form.plan = 'Start Up';
    }
    form.post(route('admin.users.subscribe', id), { preserveState: true, onSuccess() {}, onError() {} });
    clearActionId();
};

watch(
    search,
    debounce((val: string) => router.get('/admin/users', { search: val }, { preserveState: true }), 300),
);
defineProps<{
    name?: string;
    all_users: object;
}>();
</script>

<template>
    <Head title="Users" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 class="font-medium">All Users</h1>

            <h2>Search Users</h2>
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
                                                Token
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500 dark:text-neutral-500"
                                            >
                                                Plans
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
                                            v-for="user in all_users"
                                            :key="user.id"
                                            class="odd:bg-white even:bg-gray-100 dark:odd:bg-neutral-900 dark:even:bg-neutral-800"
                                        >
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                {{ user.email }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
                                                {{ user.remaining_token_uses }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
                                                {{ uppercasePlans(user.plans) }}
                                            </td>
                                            <td class="relative whitespace-nowrap px-6 py-4 text-end text-sm font-medium">
                                                <button
                                                    v-if="actionId === null"
                                                    @click="setActionId(user.id)"
                                                    type="button"
                                                    class="focus:outline-hidden inline-flex items-center gap-x-2 rounded-lg border border-transparent text-sm font-semibold text-blue-600 hover:text-blue-800 focus:text-blue-800 disabled:pointer-events-none disabled:opacity-50 dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400"
                                                >
                                                    <EllipsisVertical />
                                                </button>

                                                <button
                                                    v-else
                                                    @click="clearActionId"
                                                    type="button"
                                                    class="focus:outline-hidden inline-flex items-center gap-x-2 rounded-lg border border-transparent text-sm font-semibold text-blue-600 hover:text-blue-800 focus:text-blue-800 disabled:pointer-events-none disabled:opacity-50 dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400"
                                                >
                                                    <EllipsisVertical />
                                                </button>
                                            </td>
                                            <div
                                                v-if="user.id === actionId"
                                                class="absolute right-2 z-50 mt-10 flex h-[120px] w-[200px] flex-col justify-center space-y-4 rounded bg-white p-4 shadow-md"
                                            >
                                                <button
                                                    @click="submitSubscription(user.id, 'Business')"
                                                    class="border-b-2 p-1 font-medium hover:bg-slate-100"
                                                >
                                                    Business
                                                </button>
                                                <button
                                                    @click="submitSubscription(user.id, 'Start Up')"
                                                    class="border-b-2 p-1 font-medium hover:bg-slate-100"
                                                >
                                                    Start Up
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

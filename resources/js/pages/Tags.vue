<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { ChatType, TagType, type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { ref, watch } from 'vue';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tags',
        href: '/tags',
    },
];
//toast
const toast = useToast();

//forms
const search = ref('');

const form = useForm({
    tagname: '',
});

const submit = () => {
    if (form.tagname !== '') {
        form.post('tags/add', {
            preserveState: true,
            onError() {},
            onSuccess() {
                form.reset();
            },
        });
        toast.success('Successfully added tag');
    } else {
        toast.error('Please provide tag');
    }
};

const cancel = () => {
    form.reset();
};

const formatTagsForTable = (chats: ChatType[]): string => {
    let result = '';

    for (let index = 0; index < 2; index++) {
        result += chats[index].chat_scripts + ' ';

        // Break at 15 words
        if (index === 14) {
            // 14 because index starts at 0
            result = result.trim();
            return result;
        }

        // Break every 3 words
        if ((index + 1) % 3 === 0) {
            result = result.trim() + '\n';
        }
    }

    return result;
};

watch(
    search,
    debounce((val: string) => router.get('tags', { search: val }, { preserveState: true }), 300),
);

defineProps<{
    name?: string;
    tags: TagType[];
}>();

//methods
</script>

<template>
    <Head title="Tags" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div>
                <div>
                    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                        <!-- text area for chat scripts -->
                        <!-- chat scripts -->
                        <form class="col-span-2 max-w-md space-y-3">
                            <h2 class="font-medium">Add Tags</h2>
                            <div class="mt-2 rounded-lg border-2 border-gray-200">
                                <textarea
                                    class="block w-full rounded-lg border-gray-200 px-4 py-3 text-2xl focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    rows="2"
                                    placeholder="This is a textarea placeholder"
                                    v-model="form.tagname"
                                ></textarea>
                            </div>
                        </form>

                        <!-- Associated Tags -->
                        <div class="mt-1 flex h-full flex-col">
                            <h2 class="font-medium">Search Tags</h2>

                            <input
                                type="text"
                                class="block w-full rounded-lg border-gray-200 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="This is placeholder"
                                v-model="search"
                            />
                        </div>
                    </div>

                    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                        <div class="col-span-2 mt-4 flex w-full justify-end space-x-2 xl:col-span-1">
                            <button
                                type="button"
                                class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black/40 px-4 py-3 text-sm font-medium text-white focus:outline-none disabled:pointer-events-none disabled:opacity-50 dark:bg-gray-400 dark:text-black"
                                @click="cancel"
                            >
                                Cancel
                            </button>
                            <button
                                class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black px-4 py-3 text-sm font-medium text-white disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black"
                                @click="submit"
                            >
                                Add Tag
                            </button>
                        </div>

                        <div class="items- flex h-full flex-col justify-start"></div>
                    </div>

                    <!-- table -->
                    <div class="mt-10 flex flex-col">
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
                                                    Tags
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500 dark:text-neutral-500"
                                                >
                                                    Associated Chat Scripts
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
                                                v-for="tag in tags"
                                                :key="tag.id"
                                                class="odd:bg-white even:bg-gray-100 dark:odd:bg-neutral-900 dark:even:bg-neutral-800"
                                            >
                                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                    {{ tag.tagname }}
                                                </td>

                                                <td class="whitespace-pre-wrap px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
                                                    {{ formatTagsForTable(tag.associated_chats) }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-end text-sm font-medium">
                                                    <Link
                                                        :href="route('tags.delete', tag.id)"
                                                        method="delete"
                                                        type="button"
                                                        class="inline-flex items-center gap-x-2 rounded-lg border border-transparent text-sm font-semibold text-blue-600 hover:text-blue-800 focus:text-blue-800 focus:outline-none disabled:pointer-events-none disabled:opacity-50 dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400"
                                                    >
                                                        Delete
                                                    </Link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

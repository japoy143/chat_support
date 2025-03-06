<script setup lang="ts">
import Dialog from '@/components/ui/dialog/Dialog.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { ChatType, TagType, type BreadcrumbItem } from '@/types';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { ref, watch } from 'vue';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Chats',
        href: '/chats',
    },
];

//toast
const toast = useToast();

//refs

const addedTags = ref(<TagType[]>[]);

const form = useForm({
    chat_scripts: '',
    tags: [{}],
});

const search = ref('');

defineProps<{
    name?: string;
    chats: ChatType[];
    tags: TagType[];
}>();

//methods
const submit = () => {
    form.tags = addedTags.value;
    if (form.chat_scripts !== '') {
        form.post(route('chats.store'), {
            preserveState: true,
            onSuccess() {
                toast.success('Successfully added chat scripts');
                form.reset();
                addedTags.value = [];
            },
            onError() {},
        });
    } else {
        toast.error('Empty chat scripts please provide');
    }
};

const cancel = () => {
    form.reset();
};

// add associate tag
const associateTag = (tag: TagType) => {
    addedTags.value.push(tag);
};

//remove associated tag
const removeAssociatedTag = (index: number) => {
    addedTags.value.splice(index, 1);
};

//split words to format
const formatWordsForTable = (chat: string): string => {
    const words = chat.split(' ');
    let result = '';

    for (let index = 0; index < words.length; index++) {
        result += words[index] + ' ';

        // Break at 15 words
        if (index === 9) {
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

const formatTagsForTable = (tags: TagType[]): string => {
    let result = '';

    for (let index = 0; index < tags.length; index++) {
        result += tags[index].tagname + ' ';

        // Break at 15 words
        if (index === 9) {
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
    debounce((val: string) => router.get('/chats', { search: val }, { preserveState: true }), 300),
);
</script>

<template>
    <Dialog></Dialog>
    <Head title="Chats" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div>
                <div>
                    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                        <!-- text area for chat scripts -->
                        <!-- chat scripts -->
                        <form class="max-w-md space-y-3">
                            <h2 class="font-medium">Chat Scripts</h2>
                            <div class="mt-2 rounded-lg border-2 border-gray-200">
                                <textarea
                                    class="block w-full rounded-lg border-gray-200 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    rows="6"
                                    placeholder="This is a textarea placeholder"
                                    v-model="form.chat_scripts"
                                ></textarea>
                            </div>
                        </form>
                        <!-- search tags
                        for associate tag in chats -->
                        <div>
                            <h2 class="font-medium">Search Tags</h2>
                            <div class="mt-2 max-w-sm space-y-3 rounded-lg border-2 border-gray-200">
                                <input
                                    type="text"
                                    class="block w-full rounded-lg border-gray-200 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="This is placeholder"
                                    v-model="search"
                                />
                            </div>
                            <!-- tags -->
                            <div class="mt-1 overflow-y-scroll">
                                <h2 class="font-medium">Tags</h2>
                                <div v-for="tag in tags" :key="tag.id">
                                    <div class="flex justify-between border-b px-6 py-1">
                                        <p>{{ tag.tagname }}</p>
                                        <button class="font-bold text-blue-400" @click="associateTag(tag)">add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Associated Tags -->
                        <div class="mt-1 flex h-full flex-col">
                            <h2 class="font-medium">Associated Tags</h2>
                            <div class="flex flex-1 flex-wrap items-start space-x-2 rounded-sm border-2 border-gray-200 p-4">
                                <p
                                    v-for="(added, index) in addedTags"
                                    :key="added.id"
                                    class="relative cursor-pointer rounded-md bg-gray-200 p-1 font-medium"
                                    @click="removeAssociatedTag(index)"
                                >
                                    {{ added.tagname }} <small class="absolute top-0 ml-1">x</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex w-full justify-end space-x-2">
                        <button
                            type="button"
                            class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black/40 px-4 py-3 text-sm font-medium text-white focus:outline-none disabled:pointer-events-none disabled:opacity-50 dark:bg-gray-400 dark:text-black"
                            @click="cancel"
                        >
                            Cancel
                        </button>
                        <button
                            @click="submit"
                            class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black px-4 py-3 text-sm font-medium text-white disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black"
                        >
                            Save
                        </button>
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
                                                    Chat Scripts
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-6 py-3 text-start text-xs font-medium uppercase text-gray-500 dark:text-neutral-500"
                                                >
                                                    Tags
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
                                                v-for="chat in chats"
                                                :key="chat.id"
                                                class="odd:bg-white even:bg-gray-100 dark:odd:bg-neutral-900 dark:even:bg-neutral-800"
                                            >
                                                <td class="whitespace-pre-wrap px-6 py-4 text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                    {{ formatWordsForTable(chat.chat_scripts) }}
                                                </td>

                                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
                                                    {{ formatTagsForTable(chat.tags) }}
                                                </td>
                                                <td class="whitespace-nowrap px-6 py-4 text-end text-sm font-medium">
                                                    <Link
                                                        :preserve-scroll="true"
                                                        :href="route('chat.delete', chat.id)"
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

function defineProps
<T></T>

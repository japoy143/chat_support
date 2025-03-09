<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const response = ref('');
const errors = ref('');
const isLoading = ref(false);

const form = useForm({
    text: '',
});

const submit = async () => {
    if (form.text === '') {
        errors.value = 'Please provide before sending';
        return;
    }
    try {
        response.value = '';
        isLoading.value = true;

        const res = await axios.post('chatsupport/prompt', { text: form.text }, { headers: { 'Content-Type': 'application/json' } });
        if (res.data == 'not enough token') {
            response.value = 'Not enough token please subscribe to our plan';
            toast.warning('Not enough token please subscribe to our plan');
            form.reset();
            return;
        }
        response.value = res.data.message;

        errors.value = '';
        form.reset();
    } catch (error) {
        console.log(error);
        errors.value = error;
    } finally {
        isLoading.value = false;
    }

    // form.post('chatsupport.prompt');
};

defineProps<{
    name?: string;
}>();
</script>

<template>
    <Head title="ChatSupport" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <!-- <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div> -->
            <div
                class="relative flex min-h-[100vh] flex-1 flex-col rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border md:min-h-min"
            >
                <form @submit.prevent="submit">
                    <h1 class="text-xl font-medium">Chat Assistant</h1>
                    <textarea
                        class="mt-2 block w-full rounded-lg border-2 border-solid border-black px-4 py-3 text-2xl focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        rows="4"
                        placeholder="This is a textarea placeholder"
                        v-model="form.text"
                    ></textarea>
                    <small v-if="form.text === '' && errors" class="text-red-500">{{ errors }}</small>

                    <div class="mt-2 flex justify-end">
                        <button
                            class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black px-4 py-3 text-sm font-medium text-white disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black"
                            type="submit"
                        >
                            Send
                        </button>
                    </div>
                </form>
                <!-- reply container -->
                <div class="mt-2 flex flex-1 flex-col">
                    <h1 class="text-xl font-medium">Response</h1>
                    <div class="flex-1 overflow-auto whitespace-pre-line rounded-xl border-2 border-solid border-black p-4">
                        <div>
                            <div v-if="isLoading" class="animate-pulse">
                                <p><span class="bg-gray-100 text-xl text-transparent"> Samplee Teext Sample Text</span></p>
                                <p class="mt-2">
                                    <span class="bg-gray-100 text-xl text-transparent"
                                        >Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum enim
                                    </span>
                                </p>
                                <p class="mt-2">
                                    <span class="bg-gray-100 text-xl text-transparent"
                                        >Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum enim consectetur adipisicing
                                    </span>
                                </p>
                                <p class="mt-2">
                                    <span class="bg-gray-100 text-xl text-transparent"
                                        >Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum enim consectetur adipisicing
                                    </span>
                                </p>

                                <p class="mt-10"><span class="bg-gray-100 text-xl text-transparent"> Samplee Teext Sample Text</span></p>
                                <p class="mt-2">
                                    <span class="bg-gray-100 text-xl text-transparent"
                                        >Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum enim
                                    </span>
                                </p>
                                <p class="mt-2">
                                    <span class="bg-gray-100 text-xl text-transparent"
                                        >Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum enim consectetur adipisicing
                                    </span>
                                </p>
                                <p class="mt-2">
                                    <span class="bg-gray-100 text-xl text-transparent"
                                        >Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum enim consectetur adipisicing
                                    </span>
                                </p>
                            </div>
                            {{ response }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

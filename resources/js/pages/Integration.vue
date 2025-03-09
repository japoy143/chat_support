<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Modal :isModalOpen="isModalOpen" @close="closeModal" />
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
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border md:min-h-min">
                <div>
                    <h1 class="font-medium">Client Api Url</h1>
                    <p class="text-sm text-gray-500">This is your unique api url you can copy this and integration to your projects</p>
                    <div class="mt-2 flex space-x-1">
                        <div class="inline-block rounded-md border-2 border-solid border-black p-2">
                            <p>{{ client_api_key }}</p>
                        </div>
                        <button
                            class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black px-4 py-3 text-sm font-medium text-white disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black"
                            @click="submit"
                        >
                            Copy
                        </button>
                    </div>
                </div>

                <div class="mt-2">
                    <h1 class="font-medium">Sample usage of api</h1>
                    <p class="text-sm text-gray-500">Sample usage click the send to get a response</p>
                    <div class="mt-2 flex space-x-1">
                        <div class="inline-block rounded-md border-2 border-solid border-black p-2">
                            <p>{{ sample_usage_api }}</p>
                        </div>
                        <button
                            class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black px-4 py-3 text-sm font-medium text-white disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black"
                            @click="send"
                        >
                            Send
                        </button>
                    </div>
                </div>

                <div class="mt-2">
                    <h1 class="font-medium">Try the api url</h1>
                    <p class="text-sm text-gray-500">Input custom message and get your response</p>
                    <div class="mt-2 flex space-x-1">
                        <div class="flex items-center rounded-md border-2 border-solid border-black p-2">
                            <p>{{ try_client_api }}</p>
                            <input
                                v-model="customMessage"
                                autofocus
                                type="text"
                                placeholder="input your message here"
                                class="ml-1 border-none outline-none"
                            />
                        </div>
                        <button
                            class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black px-4 py-3 text-sm font-medium text-white disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black"
                            @click="sendCustom"
                        >
                            Send
                        </button>
                    </div>
                </div>

                <div class="mt-4">
                    <h1 class="font-medium">Response</h1>
                    <p class="text-sm text-gray-500">your response is generated here</p>
                    <div class="mt-2 max-w-lg space-x-1">
                        <div class="min-h-[200px] w-full items-center overflow-y-auto rounded-md border-2 border-solid border-black p-2">
                            <div v-if="isLoading" class="animate-pulse">
                                <p><span class="bg-gray-100 text-xl text-transparent"> Samplee Teext Sample Text</span></p>
                                <p class="mt-2">
                                    <span class="bg-gray-100 text-xl text-transparent">Lorem ipsum dolor sit amet </span>
                                </p>
                                <p class="mt-2">
                                    <span class="bg-gray-100 text-xl text-transparent">Lorem ipsum dolor sit amet consectetur consectetur</span>
                                </p>
                                <p class="mt-2">
                                    <span class="bg-gray-100 text-xl text-transparent">Lorem ipsum dolor sit amet consectetur consectetur</span>
                                </p>
                                <p class="mt-2">
                                    <span class="bg-gray-100 text-xl text-transparent">Lorem ipsum dolor sit amet consectetur consectetur</span>
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

<script setup lang="ts">
import Modal from '@/components/app/Modal.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref } from 'vue';

import { useToast } from 'vue-toast-notification';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Integration',
        href: '/integration',
    },
];

const toast = useToast();

const customMessage = ref('');

const page = usePage();

const response = ref('');

const isLoading = ref(false);

const client_api_key = `chat/${page.props.auth.user.client_token}/client/{prompt}`;

const try_client_api = `chat/${page.props.auth.user.client_token}/client/`;

const sample_usage_api = `chat/${page.props.auth.user.client_token}/client/What is our Company background?`;
const submit = () => {
    navigator.clipboard.writeText(client_api_key);
    toast.success('Successfully copy client api url');
};

const send = async () => {
    try {
        response.value = '';
        isLoading.value = true;
        const res = await axios.get(`chat/${page.props.auth.user.client_token}/client/What is our Company background?`);
        response.value = res.data.message;
        console.log(res.data);
    } catch (e) {
        console.log(e);
    } finally {
        isLoading.value = false;
    }
};

const sendCustom = async () => {
    try {
        response.value = '';
        isLoading.value = true;
        const res = await axios.get(`chat/${page.props.auth.user.client_token}/client/${customMessage.value}`);
        console.log(`custom message: ${customMessage}`);
        response.value = res.data.message;
        console.log(res.data);
    } catch (e) {
        console.log(e);
    } finally {
        isLoading.value = false;
    }
};

const props = defineProps<{
    name?: string;
}>();
</script>

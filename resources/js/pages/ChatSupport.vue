<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
const form = useForm({
    text: '',
});

const submit = () => {
    // try {
    //     const response = await axios.post('chat/support', { prompt: form.prompt });
    //     console.log(response.data.response);
    // } catch (error) {
    //     console.error('Error:', error.response ? error.response.data : error.message);
    // }

    form.post('sample');
};
defineProps<{
    name?: string;
}>();
</script>

<template>
    <Head title="ChatSupport" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <form
                @submit.prevent="submit"
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min"
            >
                <textarea
                    class="block w-full rounded-lg border-gray-200 px-4 py-3 text-2xl focus:border-blue-500 focus:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                    rows="2"
                    placeholder="This is a textarea placeholder"
                    v-model="form.text"
                ></textarea>
                <button type="submit">Submit</button>
            </form>
        </div>
    </AppLayout>
</template>

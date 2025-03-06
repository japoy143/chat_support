<template>
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <form @submit.prevent="submit" class="h-[340px] w-[600px] max-w-2xl rounded-lg bg-slate-50 p-4 shadow-md">
            <h1 class="text-2xl font-medium">Company Background</h1>
            <p class="text-sm text-gray-400">This helps ai to have some ideas about the company</p>

            <textarea
                class="mt-4 block w-full rounded-lg border-2 border-black px-4 py-3 text-2xl disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                rows="4"
                placeholder="ai assistant background"
                v-model="form.company_background"
            ></textarea>
            <small class="text-red-500">{{ form.errors.company_background }}</small>
            <div class="mt-4 flex w-full justify-end space-x-2">
                <button
                    class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black/40 px-4 py-3 text-sm font-medium text-white focus:outline-none disabled:pointer-events-none disabled:opacity-50 dark:bg-gray-400 dark:text-black"
                    @click="$emit('close')"
                >
                    Cancel
                </button>
                <button
                    class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-black px-4 py-3 text-sm font-medium text-white disabled:pointer-events-none disabled:opacity-50 dark:bg-white dark:text-black"
                    type="submit"
                >
                    Save
                </button>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { defineEmits } from 'vue';
//imports
const emit = defineEmits(['close']);

//props
const props = defineProps<{
    isModalOpen?: boolean;
}>();

//watch

//refs

const form = useForm({
    company_background: '',
});

const submit = () => {
    form.post(route('dashboard.set'), {
        preserveState: true,
        onSuccess() {
            form.reset();
            props.isModalOpen = false;
            emit('close');
        },
        onError() {},
    });
};

//methods
</script>

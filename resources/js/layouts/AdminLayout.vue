<script setup lang="ts">
import type { BreadcrumbItemType } from '@/types';
import AdminLayout from './app/AdminLayout.vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AdminLayout>
</template>

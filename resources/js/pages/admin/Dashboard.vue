<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import Chart from 'chart.js/auto';
import { onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps<{
    name?: string;
    all_users: object;
    free_plan_users: object;
    business_plan_users: object;
    start_up_plan_users: Object;
}>();

const months = ['January', 'February', 'March', 'April', 'May', 'Jun', 'July', 'August', 'September', 'October', 'November', 'December'];
const monthlyUsers = [2, 0, 10, 4, 0, 20, 100, 30, 20, 10, 20, 40];
onMounted(() => {
    const ctx = document.getElementById('myChart');

    const lineChart = document.getElementById('lineChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['All Users', 'Free Plan Users', 'Business Plan Users', 'Start Up Plan Users'],
            datasets: [
                {
                    backgroundColor: ['#F17170', '#74C69D', '#867DBE', '#EFF0C5'],
                    label: '# of Users',
                    data: [props.all_users.length, props.free_plan_users.length, props.business_plan_users.length, props.start_up_plan_users.length],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });

    new Chart(lineChart, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    borderColor: '#F17170',
                    label: '# of Users',
                    data: monthlyUsers,
                    borderWidth: 4,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
});
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <div
                    class="relative flex aspect-video flex-col overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
                >
                    <h1 class="text-lg font-medium xl:text-2xl">All Users</h1>
                    <div class="flex w-full flex-1 flex-col items-center justify-center text-4xl">
                        <p>{{ all_users.length }}</p>
                    </div>
                </div>
                <div
                    class="relative flex aspect-video flex-col overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
                >
                    <h1 class="text-lg font-medium xl:text-2xl">Free Plan Users</h1>
                    <div class="flex w-full flex-1 flex-col items-center justify-center text-4xl">
                        <p>{{ free_plan_users.length }}</p>
                    </div>
                </div>
                <div
                    class="relative flex aspect-video flex-col overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
                >
                    <h1 class="text-lg font-medium xl:text-2xl">Business Plan Users</h1>
                    <div class="flex w-full flex-1 flex-col items-center justify-center text-4xl">
                        <p>{{ business_plan_users.length }}</p>
                    </div>
                </div>
                <div
                    class="relative flex aspect-video flex-col overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
                >
                    <h1 class="text-lg font-medium xl:text-2xl">Start Up Plan Users</h1>
                    <div class="flex w-full flex-1 flex-col items-center justify-center text-4xl">
                        <p>{{ start_up_plan_users.length }}</p>
                    </div>
                </div>
            </div>
            <div
                class="relative grid min-h-[100vh] flex-1 grid-rows-2 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min"
            >
                <div class="flex max-h-[400px] w-full items-center justify-center">
                    <canvas id="myChart"></canvas>
                </div>

                <div class="flex max-h-[400px] w-full items-center justify-center">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookText, ChevronsLeftRightEllipsis, HandCoins, MessagesSquare, TagIcon } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const page = usePage();

const mainNavItems: NavItem[] = [
    {
        title: 'Chats Scripts',
        href: '/chats',
        icon: BookText,
    },
    {
        title: 'Tags',
        href: '/tags',
        icon: TagIcon,
    },
    {
        title: 'ChatSupport',
        href: '/chatsupport',
        icon: MessagesSquare,
    },
    {
        title: 'Integration',
        href: '/integration',
        icon: ChevronsLeftRightEllipsis,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: `Free Token  ${page.props.auth.user.remaining_token_uses}`,
        href: '#',
        icon: HandCoins,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('chats.index')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

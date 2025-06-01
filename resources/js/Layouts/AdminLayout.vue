<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {
    Dropdown,
    DropdownTrigger,
    DropdownContent,
    DropdownItem,
    NavLink,
    Button,
    ThemeSwitcher
} from '@/components';
import Toast from '@/Components/Toast.vue';
import { ToastProvider } from '@/Components/ui/toast';
import { useToast } from '@/Composables/useToast';
import { onMounted } from 'vue';

const showingNavigationDropdown = ref(false);
const { auth } = usePage().props;

const props = defineProps({
    flash: {
        type: Object,
        default: () => ({})
    }
});

const { messages, showSuccess, showError } = useToast();

onMounted(() => {
    if (props.flash?.success) {
        showSuccess(props.flash.success);
    }
    if (props.flash?.error) {
        showError(props.flash.error);
    }
});
</script>

<template>
    <ToastProvider>
        <div>
            <div class="min-h-screen bg-background">
                <nav class="border-b">
                    <!-- Primary Navigation Menu -->
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="flex h-16 justify-between">
                            <div class="flex">
                                <!-- Logo -->
                                <div class="flex shrink-0 items-center">
                                    <Link :href="route('admin.dashboard')">
                                        <ApplicationLogo class="block h-9 w-auto fill-current text-foreground" />
                                    </Link>
                                </div>

                                <!-- Navigation Links -->
                                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                    <NavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')">
                                        Dashboard
                                    </NavLink>
                                    <NavLink :href="route('admin.skills.index')" :active="route().current('admin.skills.*')">
                                        Skills
                                    </NavLink>
                                    <NavLink :href="route('admin.education.index')" :active="route().current('admin.education.*')">
                                        Education
                                    </NavLink>
                                    <NavLink :href="route('admin.projects.index')" :active="route().current('admin.projects.*')">
                                        Projects
                                    </NavLink>
                                    <NavLink :href="route('admin.messages.index')" :active="route().current('admin.messages.*')">
                                        Messages
                                    </NavLink>
                                </div>
                            </div>

                            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                                <!-- Theme Switcher -->
                                <ThemeSwitcher />

                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <DropdownTrigger>
                                                <Button variant="ghost" class="gap-2">
                                                    {{ auth.user.name }}
                                                    <svg
                                                        class="h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </Button>
                                            </DropdownTrigger>
                                        </template>

                                        <DropdownContent>
                                            <DropdownItem>
                                                <Link :href="route('logout')" method="post" as="button" class="w-full text-left">
                                                    Log Out
                                                </Link>
                                            </DropdownItem>
                                        </DropdownContent>
                                    </Dropdown>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-mr-2 flex items-center sm:hidden">
                                <Button
                                    variant="ghost"
                                    size="icon"
                                    @click="showingNavigationDropdown = !showingNavigationDropdown"
                                >
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path
                                            :class="{
                                                hidden: showingNavigationDropdown,
                                                'inline-flex': !showingNavigationDropdown,
                                            }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            :class="{
                                                hidden: !showingNavigationDropdown,
                                                'inline-flex': showingNavigationDropdown,
                                            }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </Button>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Navigation Menu -->
                    <div
                        :class="{
                            block: showingNavigationDropdown,
                            hidden: !showingNavigationDropdown,
                        }"
                        class="sm:hidden"
                    >
                        <div class="space-y-1 pb-3 pt-2">
                            <NavLink :href="route('admin.dashboard')" :active="route().current('admin.dashboard')" class="block px-3 py-2">
                                Dashboard
                            </NavLink>
                            <NavLink :href="route('admin.skills.index')" :active="route().current('admin.skills.*')" class="block px-3 py-2">
                                Skills
                            </NavLink>
                            <NavLink :href="route('admin.education.index')" :active="route().current('admin.education.*')" class="block px-3 py-2">
                                Education
                            </NavLink>
                            <NavLink :href="route('admin.projects.index')" :active="route().current('admin.projects.*')" class="block px-3 py-2">
                                Projects
                            </NavLink>
                            <NavLink :href="route('admin.messages.index')" :active="route().current('admin.messages.*')" class="block px-3 py-2">
                                Messages
                            </NavLink>
                        </div>

                        <!-- Responsive Settings Options -->
                        <div class="border-t pb-1 pt-4">
                            <div class="px-4">
                                <div class="text-base font-medium">{{ auth.user.name }}</div>
                                <div class="text-sm text-muted-foreground">{{ auth.user.email }}</div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <Button
                                    variant="ghost"
                                    class="w-full justify-start px-4 py-2"
                                    @click="$inertia.post(route('logout'))"
                                >
                                    Log Out
                                </Button>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Heading -->
                <header v-if="$slots.header" class="border-b bg-background shadow-sm">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main>
                    <slot />
                </main>
            </div>

            <!-- Toast Messages -->
            <template v-for="msg in messages" :key="msg.id">
                <Toast :variant="msg.type">
                    {{ msg.message }}
                </Toast>
            </template>
        </div>
    </ToastProvider>
</template> 
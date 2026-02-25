<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-gray-50 pt-6 sm:justify-center sm:pt-0"
    >
        <div class="mb-8">
            <Link href="/" class="flex flex-col items-center gap-3 group">
                <img src="/logo.svg" alt="MojiMili Logo" class="h-20 w-auto group-hover:scale-105 transition-transform" />
                <span class="text-3xl font-extrabold brand-text-gradient font-heading tracking-tight">MojiMili</span>
            </Link>
        </div>

        <div
            class="w-full overflow-hidden bg-white px-10 py-12 shadow-brand-lg sm:max-w-md rounded-brand border border-gray-100"
        >
            <slot />
        </div>
    </div>
</template>

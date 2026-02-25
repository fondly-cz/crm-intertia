<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const items = [
    {
        name: 'Nástěnka',
        href: '/',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>',
        component: 'Dashboard'
    },
    {
        name: 'Firmy',
        href: '/companies',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>',
        component: 'Companies/'
    },
    {
        name: 'Kalkulace',
        href: '/calculations',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>',
        component: 'Calculations/'
    },
    {
        name: 'Ceník služeb',
        href: '/services',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        component: 'Services/',
        adminOnly: true
    },
    {
        name: 'Moje firma',
        href: '/my-company',
        icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>',
        component: 'MyCompany/'
    }
];
</script>

<template>
    <div class="fixed inset-y-0 left-0 w-72 bg-white border-r border-gray-100 flex flex-col z-60 shadow-sm">
        <!-- Logo -->
        <div class="p-8 pb-10">
            <Link href="/" class="flex items-center gap-3 group">
                <img src="/logo.svg" alt="MojiMili Logo" class="h-10 w-auto group-hover:scale-105 transition-transform" />
                <span class="text-2xl font-black brand-text-gradient font-heading tracking-tight">MojiMili</span>
            </Link>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto">
            <template v-for="item in items" :key="item.name">
                <Link
                    v-if="!item.adminOnly || $page.props.auth.user?.role === 'admin'"
                    :href="item.href"
                    class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-bold font-heading transition-all duration-300 group"
                    :class="[
                        $page.component.startsWith(item.component) || ($page.component === 'Dashboard' && item.component === 'Dashboard')
                        ? 'brand-gradient text-white shadow-brand translate-x-1' 
                        : 'text-gray-400 hover:text-gray-900 hover:bg-gray-50'
                    ]"
                >
                    <div 
                        class="shrink-0 transition-colors"
                        :class="[
                            $page.component.startsWith(item.component) || ($page.component === 'Dashboard' && item.component === 'Dashboard')
                            ? 'text-white' 
                            : 'text-gray-300 group-hover:text-brand-primary-from'
                        ]"
                        v-html="item.icon"
                    ></div>
                    <span class="text-[15px] leading-none">{{ item.name }}</span>
                </Link>
            </template>
        </nav>

        <!-- Footer / Upgrade Card -->
        <div class="p-6">
            <div class="bg-gray-50 rounded-[2rem] p-6 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:rotate-12 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <h5 class="font-black text-gray-900 font-heading text-sm mb-1 uppercase tracking-wider">MojiMili Pro</h5>
                    <p class="text-xs text-gray-400 font-medium mb-4 leading-relaxed">Upgrade for extra features and premium support.</p>
                    <button class="w-full py-2.5 bg-white text-gray-900 rounded-xl font-bold text-xs shadow-sm border border-gray-100 hover:bg-brand-primary-from hover:text-white hover:border-brand-primary-from transition-all uppercase tracking-widest">Upgrade Now</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Layout from '@/Components/Layout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            companies: 0,
            calculations: 0,
            services: 0
        })
    }
});
</script>

<template>
    <Head title="Nástěnka" />

    <Layout>
        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900 font-heading tracking-tight">Vítejte zpět 👋</h1>
            <p class="text-gray-500 mt-2 font-medium">Zde je přehled vašeho systému MojiMili.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-50 hover:shadow-brand transition-all group overflow-hidden relative">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Firmy</span>
                    <span class="text-5xl font-black text-gray-900 font-heading tracking-tighter">{{ stats.companies }}</span>
                    <Link href="/companies" class="mt-4 text-sm font-bold brand-text-gradient hover:opacity-80 transition-opacity">Zobrazit firmy →</Link>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-50 hover:shadow-brand transition-all group overflow-hidden relative">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Kalkulace</span>
                    <span class="text-5xl font-black text-gray-900 font-heading tracking-tighter">{{ stats.calculations }}</span>
                    <Link href="/calculations" class="mt-4 text-sm font-bold brand-text-gradient hover:opacity-80 transition-opacity">Zobrazit kalkulace →</Link>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-50 hover:shadow-brand transition-all group overflow-hidden relative">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Ceník služeb</span>
                    <span class="text-5xl font-black text-gray-900 font-heading tracking-tighter">{{ stats.services }}</span>
                    <Link href="/services" class="mt-4 text-sm font-bold brand-text-gradient hover:opacity-80 transition-opacity">Upravit ceník →</Link>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-50 mb-10">
            <h2 class="text-2xl font-extrabold text-gray-900 font-heading mb-6">Rychlé akce</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <Link href="/companies/create" class="flex items-center gap-3 p-4 rounded-2xl bg-gray-50 hover:bg-brand-primary-from hover:text-white transition-all group">
                    <div class="h-10 w-10 brand-gradient rounded-xl flex items-center justify-center text-white shadow-sm group-hover:bg-white group-hover:text-brand-primary-from group-hover:from-white group-hover:to-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <span class="font-bold">Nová firma</span>
                </Link>

                <Link href="/calculations/create" class="flex items-center gap-3 p-4 rounded-2xl bg-gray-50 hover:bg-brand-primary-from hover:text-white transition-all group">
                    <div class="h-10 w-10 brand-gradient rounded-xl flex items-center justify-center text-white shadow-sm group-hover:bg-white group-hover:text-brand-primary-from group-hover:from-white group-hover:to-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="font-bold">Nová kalkulace</span>
                </Link>

                <Link v-if="$page.props.auth.user?.role === 'admin'" href="/services" class="flex items-center gap-3 p-4 rounded-2xl bg-gray-50 hover:bg-brand-primary-from hover:text-white transition-all group">
                    <div class="h-10 w-10 brand-gradient rounded-xl flex items-center justify-center text-white shadow-sm group-hover:bg-white group-hover:text-brand-primary-from group-hover:from-white group-hover:to-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="font-bold">Nastavení služeb</span>
                </Link>

                <div class="flex items-center gap-3 p-4 rounded-2xl bg-gray-50 opacity-50 cursor-not-allowed">
                    <div class="h-10 w-10 bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="font-bold text-gray-400">Správa uživatelů</span>
                </div>
            </div>
        </div>
    </Layout>
</template>

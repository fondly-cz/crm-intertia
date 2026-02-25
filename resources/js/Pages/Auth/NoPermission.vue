<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Přístup odepřen" />

    <div class="min-h-screen brand-gradient flex items-center justify-center p-6">
        <div class="bg-white rounded-[2.5rem] shadow-brand-lg p-12 max-w-2xl w-full text-center">
            <div class="h-24 w-24 bg-red-50 rounded-full flex items-center justify-center text-red-500 mx-auto mb-8 border-4 border-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h1 class="text-4xl font-extrabold text-gray-900 font-heading mb-4 tracking-tight">Přístup odepřen</h1>
            
            <p class="text-xl text-gray-500 mb-10 leading-relaxed font-medium">
                You need to ask admin for giving permissions to access the dashboard.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <Link 
                    :href="route('logout')" 
                    method="post" 
                    as="button"
                    class="px-8 py-4 bg-gray-100 text-gray-700 rounded-full font-bold hover:bg-gray-200 transition-all font-heading"
                >
                    Odhlásit se
                </Link>
                <a 
                    href="mailto:spoluprace@fondly.cz"
                    class="px-8 py-4 brand-gradient text-white rounded-full font-bold shadow-brand hover:shadow-brand-lg transition-all hover:-translate-y-1 font-heading"
                >
                    Kontaktovat podporu
                </a>
            </div>
            
            <div class="mt-12 pt-8 border-t border-gray-100">
                <div class="flex items-center justify-center gap-3">
                    <img src="/logo.svg" alt="MojiMili Logo" class="h-8 w-auto" />
                    <span class="text-xl font-extrabold brand-text-gradient font-heading tracking-tight">MojiMili</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <header class="h-24 flex items-center justify-between px-10 bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <!-- Search bar (Visual only) -->
        <div class="hidden lg:flex items-center gap-4 bg-gray-50 px-6 py-3 rounded-2xl w-96 border border-gray-50 focus-within:border-brand-primary-from focus-within:bg-white transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input 
                type="text" 
                placeholder="Hledat..." 
                class="bg-transparent border-none focus:ring-0 text-sm font-semibold text-gray-600 placeholder:text-gray-300 p-0 w-full"
            />
        </div>

        <!-- Right section -->
        <div class="flex items-center gap-6">
            <!-- Notifications (Visual only) -->
            <button class="relative p-3 bg-gray-50 text-gray-400 rounded-2xl hover:bg-brand-primary-from hover:text-white transition-all shadow-sm group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-2.5 right-2.5 h-2.5 w-2.5 bg-brand-primary-to border-2 border-white rounded-full group-hover:border-brand-primary-from transition-all"></span>
            </button>

            <!-- User profile -->
            <div class="flex items-center gap-4 pl-6 border-l border-gray-100">
                <Link :href="route('profile.edit')" class="flex items-center gap-4 hover:opacity-80 transition-opacity">
                    <div class="flex flex-col items-end">
                        <span class="text-sm font-black text-gray-900 leading-none font-heading">{{ user?.name }}</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-1.5 leading-none">
                            {{ user?.role === 'admin' ? 'Administrátor' : 'Manažer' }}
                        </span>
                    </div>
                    
                    <div class="relative group">
                        <div class="h-12 w-12 brand-gradient rounded-2xl flex items-center justify-center text-white font-black shadow-brand group-hover:scale-105 transition-transform cursor-pointer border-2 border-white overflow-hidden">
                            <img v-if="user?.avatar" :src="user.avatar" class="h-full w-full object-cover" />
                            <span v-else>{{ user?.name?.charAt(0) }}</span>
                        </div>
                    </div>
                </Link>

                <Link 
                    :href="route('logout')" 
                    method="post" 
                    as="button"
                    class="p-3 bg-red-50 text-red-400 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-sm"
                    title="Odhlásit se"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </Link>
            </div>
        </div>
    </header>
</template>

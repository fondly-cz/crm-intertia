<script setup>
import { Link } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Header from '@/Components/Header.vue';

defineProps({
    hideNav: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar Navigation (Desktop) -->
        <Sidebar v-if="!hideNav" />

        <!-- Main Content Area -->
        <div 
            class="flex-1 flex flex-col min-w-0 transition-all duration-300"
            :class="[ !hideNav ? 'ml-72' : '' ]"
        >
            <!-- Header -->
            <Header v-if="!hideNav" />

            <!-- Page Content -->
            <main class="flex-1 p-10">
                <div class="max-w-[1600px] mx-auto">
                    <!-- Flash Messages -->
                    <Transition
                        enter-active-class="transform transition ease-out duration-300"
                        enter-from-class="translate-y-2 opacity-0"
                        enter-to-class="translate-y-0 opacity-100"
                        leave-active-class="transition ease-in duration-200"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0"
                    >
                        <div v-if="$page.props.flash?.success" class="mb-10">
                            <div class="bg-green-50 border border-green-100 rounded-[2rem] p-6 shadow-sm flex items-center gap-4">
                                <div class="h-10 w-10 bg-green-500 rounded-full flex items-center justify-center text-white shrink-0 shadow-sm shadow-green-200">
                                    <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-gray-900 font-heading">Akce byla úspěšná</p>
                                    <p class="text-xs font-bold text-green-600 mt-0.5 tracking-wide">{{ $page.props.flash.success }}</p>
                                </div>
                            </div>
                        </div>
                    </Transition>

                    <slot />
                </div>
            </main>

            <!-- Footer (Optional) -->
            <footer v-if="!hideNav" class="px-10 py-8 border-t border-gray-100 bg-white/50 text-center">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    &copy; {{ new Date().getFullYear() }} MojiMili &bull; Všechna práva vyhrazena
                </p>
            </footer>
        </div>
    </div>
</template>

<style>
/* Custom scrolls for sidebar */
::-webkit-scrollbar {
    width: 6px;
}
::-webkit-scrollbar-track {
    background: transparent;
}
::-webkit-scrollbar-thumb {
    background: #f1f1f1;
    border-radius: 10px;
}
::-webkit-scrollbar-thumb:hover {
    background: #e5e5e5;
}
</style>
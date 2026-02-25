<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-100 rounded-full font-bold text-sm text-gray-700 uppercase tracking-widest shadow-sm hover:border-gray-200 hover:bg-gray-50 focus:outline-none transition-all hover:-translate-y-0.5 active:translate-y-0 font-heading"
    >
        <slot />
    </button>
</template>

<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="w-full px-4 py-3 rounded-2xl border-2 border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-primary-from focus:ring-4 focus:ring-brand-primary-from/10 transition-all outline-none text-gray-700 font-medium"
        v-model="model"
        ref="input"
    />
</template>

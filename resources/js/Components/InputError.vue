<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-xs text-red-500 font-bold ml-1">
            {{ message }}
        </p>
    </div>
</template>

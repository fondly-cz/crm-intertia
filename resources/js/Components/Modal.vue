<template>
    <Transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="show" class="fixed inset-0 z-100 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <!-- Backdrop -->
                <div 
                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-md transition-opacity" 
                    @click="closeOnBackdrop ? close() : null"
                ></div>

                <!-- Modal Content -->
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div 
                        v-if="show"
                        :class="[
                            'relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full border border-gray-100',
                            maxWidthClass
                        ]"
                    >
                        <!-- Header / Icon area -->
                        <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div v-if="$slots.icon" class="mx-auto flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl sm:mx-0">
                                    <slot name="icon"></slot>
                                </div>
                                <div :class="['mt-6 text-center sm:mt-0 sm:text-left', $slots.icon ? 'sm:ml-6' : '']">
                                    <h3 v-if="title" class="text-2xl font-black text-gray-900 font-heading tracking-tight leading-none" id="modal-title">
                                        {{ title }}
                                    </h3>
                                    <div class="mt-4">
                                        <slot name="content"></slot>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer / Action area -->
                        <div v-if="$slots.footer" class="bg-gray-50/50 px-8 py-8 sm:flex sm:flex-row-reverse sm:px-10 gap-4 mt-2">
                            <slot name="footer"></slot>
                        </div>
                        
                        <!-- Close button (top right) -->
                        <button 
                            @click="close"
                            class="absolute top-6 right-6 h-10 w-10 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-full transition-all"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </Transition>
            </div>
        </div>
    </Transition>
</template>

<script setup>
import { onMounted, onUnmounted, computed } from 'vue'

const props = defineProps({
    show: Boolean,
    title: String,
    maxWidth: {
        type: String,
        default: 'lg'
    },
    closeOnBackdrop: {
        type: Boolean,
        default: true
    }
})

const emit = defineEmits(['close'])

const close = () => emit('close')

const maxWidthClass = computed(() => {
    return {
        'sm': 'sm:max-w-sm',
        'md': 'sm:max-w-md',
        'lg': 'sm:max-w-lg',
        'xl': 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
    }[props.maxWidth]
})

const onKeyDown = (e) => {
    if (e.key === 'Escape' && props.show) {
        close()
    }
}

onMounted(() => {
    window.addEventListener('keydown', onKeyDown)
    if (props.show) {
        document.body.style.overflow = 'hidden'
    }
})

onUnmounted(() => {
    window.removeEventListener('keydown', onKeyDown)
    document.body.style.overflow = null
})
</script>

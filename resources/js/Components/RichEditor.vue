<template>
    <div class="rich-editor-container">
        <div ref="editorRef" class="rich-editor"></div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch, onUnmounted } from 'vue'
import Editor from '@toast-ui/editor'
import '@toast-ui/editor/dist/toastui-editor.css'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: 'Zadejte popis...'
    },
    height: {
        type: String,
        default: '300px'
    }
})

const emit = defineEmits(['update:modelValue'])

const editorRef = ref(null)
let editor = null

onMounted(() => {
    editor = new Editor({
        el: editorRef.value,
        height: props.height,
        initialEditType: 'wysiwyg',
        previewStyle: 'vertical',
        initialValue: props.modelValue || '',
        placeholder: props.placeholder,
        hideModeSwitch: true, // Keep it simple
        toolbarItems: [
            ['heading', 'bold', 'italic', 'strike'],
            ['hr', 'quote'],
            ['ul', 'ol', 'task', 'indent', 'outdent'],
            ['table', 'link'],
        ],
        events: {
            change: () => {
                const html = editor.getHTML()
                if (html === '<p><br></p>') {
                    emit('update:modelValue', '')
                } else {
                    emit('update:modelValue', html)
                }
            }
        }
    })
})

watch(() => props.modelValue, (newValue) => {
    if (editor && newValue !== editor.getHTML()) {
        editor.setHTML(newValue || '')
    }
})

onUnmounted(() => {
    if (editor) {
        editor.destroy()
    }
})
</script>

<style>
/* Custom styling to match our premium UI */
.toastui-editor-defaultUI {
    border-radius: 1.5rem !important;
    border: 2px solid #f3f4f6 !important;
    overflow: hidden !important;
    background: #f9fafb !important;
}

.toastui-editor-toolbar {
    background-color: #f9fafb !important;
    border-bottom: 2px solid #f3f4f6 !important;
    padding: 8px 16px !important;
}

.toastui-editor-main {
    background-color: #fff !important;
}

.toastui-editor-ww-container {
    padding: 8px !important;
}

.toastui-editor-contents {
    font-family: inherit !important;
    font-size: 0.875rem !important;
}

.rich-editor-container {
    width: 100%;
}
</style>

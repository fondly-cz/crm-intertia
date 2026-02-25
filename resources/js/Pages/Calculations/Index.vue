<template>
    <Layout>
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 font-heading tracking-tight">Historie kalkulací</h1>
                <p class="text-gray-500 mt-2 font-medium">Seznam všech vygenerovaných cenových nabídek pro klienty.</p>
            </div>
            <div>
                <Link
                    href="/calculations/create"
                    class="inline-flex items-center gap-2 brand-gradient px-8 py-4 rounded-full font-bold text-white shadow-brand hover:shadow-brand-lg transition-all hover:-translate-y-1 font-heading"
                >
                    ✨ Nová kalkulace
                </Link>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-50 overflow-hidden">
            <div class="overflow-x-auto min-h-[400px]">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-gray-50">
                            <th class="px-8 py-6 text-left w-10">
                                <input 
                                    type="checkbox" 
                                    :checked="selectedIds.length === calculations.length && calculations.length > 0"
                                    @change="toggleSelectAll"
                                    class="rounded border-gray-300 text-brand-primary-from focus:ring-brand-primary-from"
                                >
                            </th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Zákazník</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Kontakt</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Celková cena</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Čas</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Datum</th>
                            <th class="px-8 py-6 text-right text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Akce</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-for="calc in calculations" :key="calc.id" :class="{'bg-brand-primary-from/5': selectedIds.includes(calc.id)}" class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <input 
                                    type="checkbox" 
                                    v-model="selectedIds" 
                                    :value="calc.id"
                                    class="rounded border-gray-300 text-brand-primary-from focus:ring-brand-primary-from"
                                >
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-base font-bold text-gray-900 font-heading leading-tight">
                                    {{ calc.customer_name }}
                                </div>
                                <div class="text-xs font-semibold text-gray-400 mt-1">
                                    {{ calc.customer_company }}
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-sm font-bold text-gray-900">{{ calc.customer_email }}</div>
                                <div class="text-xs font-semibold text-gray-400 mt-1">{{ calc.customer_phone }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-base font-black brand-text-gradient font-heading">
                                    {{ formatCurrency(calc.total_price) }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-sm font-bold text-gray-700 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-50">
                                    {{ calc.total_days }} dní
                                </span>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-400">
                                {{ formatDate(calc.created_at) }}
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <button 
                                        @click="copyLink(calc.public_url)" 
                                        class="p-2.5 bg-gray-50 text-gray-400 rounded-xl hover:text-brand-primary-from hover:bg-white hover:shadow-sm transition-all"
                                        title="Kopírovat veřejný odkaz"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                    <Link 
                                        :href="`/calculations/${calc.id}`"
                                        class="p-2.5 bg-gray-50 text-gray-400 rounded-xl hover:text-brand-primary-to hover:bg-white hover:shadow-sm transition-all"
                                        title="Zobrazit detail"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </Link>
                                    <button
                                        @click="deleteCalculation(calc)"
                                        class="p-2.5 bg-gray-50 text-gray-400 rounded-xl hover:text-red-500 hover:bg-white hover:shadow-sm transition-all"
                                        title="Smazat"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bulk Actions Bar -->
        <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="translate-y-20 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-20 opacity-0"
        >
            <div v-if="selectedIds.length > 0" class="fixed bottom-10 left-1/2 -translate-x-1/2 z-50">
                <div class="bg-gray-900 text-white px-8 py-4 rounded-full shadow-2xl flex items-center gap-6 border border-white/10 backdrop-blur-xl">
                    <div class="flex items-center gap-3 pr-6 border-r border-white/10">
                        <span class="h-6 w-6 bg-brand-primary-from rounded-full flex items-center justify-center text-[10px] font-black">{{ selectedIds.length }}</span>
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Vybráno</span>
                    </div>
                    <button 
                        @click="bulkDelete"
                        class="text-xs font-black uppercase tracking-widest text-red-400 hover:text-red-300 transition-colors flex items-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Smazat vybrané
                    </button>
                    <button 
                        @click="selectedIds = []"
                        class="text-xs font-bold text-gray-500 hover:text-white transition-colors"
                    >
                        Zrušit
                    </button>
                </div>
            </div>
        </Transition>

        <!-- Confirmation Modal -->
        <ConfirmModal
            :show="confirmDelete.show"
            :title="confirmDelete.title"
            :message="confirmDelete.message"
            @close="confirmDelete.show = false"
            @confirm="executeDelete"
        />
    </Layout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import Layout from '../../Components/Layout.vue'
import ConfirmModal from '../../Components/ConfirmModal.vue'

const props = defineProps({
    calculations: Array
})

const selectedIds = ref([])

const confirmDelete = reactive({
    show: false,
    title: '',
    message: '',
    type: 'single',
    item: null
})

const deleteCalculation = (calc) => {
    confirmDelete.title = 'Smazat kalkulaci'
    confirmDelete.message = `Opravdu chcete smazat kalkulaci pro "${calc.customer_name}"?`
    confirmDelete.type = 'single'
    confirmDelete.item = calc
    confirmDelete.show = true
}

const toggleSelectAll = (e) => {
    if (e.target.checked) {
        selectedIds.value = props.calculations.map(c => c.id)
    } else {
        selectedIds.value = []
    }
}

const bulkDelete = () => {
    confirmDelete.title = 'Hromadné smazání'
    confirmDelete.message = `Opravdu chcete smazat ${selectedIds.value.length} vybraných kalkulací?`
    confirmDelete.type = 'bulk'
    confirmDelete.show = true
}

const executeDelete = () => {
    if (confirmDelete.type === 'single') {
        router.delete(`/calculations/${confirmDelete.item.id}`, {
            onSuccess: () => confirmDelete.show = false
        })
    } else if (confirmDelete.type === 'bulk') {
        router.post('/calculations/bulk-delete', { ids: selectedIds.value }, {
            onSuccess: () => {
                confirmDelete.show = false
                selectedIds.value = []
            }
        })
    }
}

const formatCurrency = (value) => {
    return new Intl.NumberFormat('cs-CZ', { style: 'currency', currency: 'CZK' }).format(value)
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('cs-CZ')
}

const copyLink = (url) => {
    navigator.clipboard.writeText(url)
    alert('Odkaz byl zkopírován do schránky!')
}
</script>

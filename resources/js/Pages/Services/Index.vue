<template>
    <Layout>
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 font-heading tracking-tight">Ceník služeb</h1>
                <p class="text-gray-500 mt-2 font-medium">Správa nabízených služeb, jejich nákladů a marží pro automatické výpočty.</p>
            </div>
            <div class="flex gap-3">
                <button
                    @click="showBulkModal = true"
                    class="inline-flex items-center gap-2 bg-white border-2 border-gray-100 px-8 py-4 rounded-full font-bold text-gray-400 hover:text-gray-600 hover:border-gray-200 transition-all font-heading"
                >
                    📦 Hromadné přidání
                </button>
                <button
                    @click="openCreateModal"
                    class="inline-flex items-center gap-2 brand-gradient px-8 py-4 rounded-full font-bold text-white shadow-brand hover:shadow-brand-lg transition-all hover:-translate-y-1 font-heading"
                >
                    ➕ Přidat službu
                </button>
            </div>
        </div>

        <!-- Stats -->
        <div class="mb-10 grid grid-cols-1 gap-6 sm:grid-cols-3">
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-50 hover:shadow-brand transition-all group overflow-hidden relative">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2 font-heading">Aktivních služeb</span>
                    <span class="text-5xl font-black text-gray-900 font-heading tracking-tighter">{{ services.length }}</span>
                </div>
            </div>
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-50 hover:shadow-brand transition-all group overflow-hidden relative">
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-2 font-heading">Průměrná marže</span>
                    <span class="text-5xl font-black text-gray-900 font-heading tracking-tighter">{{ averageMargin }}%</span>
                </div>
            </div>
            <div class="brand-gradient p-8 rounded-[2rem] shadow-brand hover:shadow-brand-lg transition-all group overflow-hidden relative text-white">
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:rotate-12 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex flex-col relative z-10">
                    <span class="text-xs font-black text-white/50 uppercase tracking-[0.2em] mb-2 font-heading">Stav ceníku</span>
                    <span class="text-3xl font-black font-heading tracking-tight">Aktuální k dnešku</span>
                </div>
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
                                    :checked="selectedIds.length === services.length && services.length > 0"
                                    @change="toggleSelectAll"
                                    class="rounded border-gray-300 text-brand-primary-from focus:ring-brand-primary-from"
                                >
                            </th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Služba</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Kategorie</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Platba</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Náklady</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Marže</th>
                            <th class="px-8 py-6 text-left text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Dny</th>
                            <th class="px-8 py-6 text-right text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 font-heading">Akce</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-for="service in services" :key="service.id" :class="{'bg-brand-primary-from/5': selectedIds.includes(service.id)}" class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <input 
                                    type="checkbox" 
                                    v-model="selectedIds" 
                                    :value="service.id"
                                    class="rounded border-gray-300 text-brand-primary-from focus:ring-brand-primary-from"
                                >
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 bg-gray-50 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-white transition-colors">
                                        {{ service.icon }}
                                    </div>
                                    <div class="text-base font-bold text-gray-900 font-heading">{{ service.name }}</div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center px-4 py-1.5 text-[10px] font-black uppercase tracking-wider rounded-full bg-blue-50 text-brand-accent shadow-sm border border-blue-100">
                                    {{ service.category }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <span 
                                    class="inline-flex items-center px-4 py-1.5 text-[10px] font-black uppercase tracking-wider rounded-full shadow-sm border"
                                    :class="getPeriodStyles(service.payment_period)"
                                >
                                    {{ getPeriodLabel(service.payment_period) }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-600">
                                {{ formatCurrency(service.cost) }}
                            </td>
                            <td class="px-8 py-6 text-sm font-black brand-text-gradient font-heading">
                                {{ service.margin }}%
                            </td>
                            <td class="px-8 py-6 text-sm font-bold text-gray-700">
                                <span class="bg-gray-50/50 px-3 py-1.5 rounded-xl">
                                    {{ service.days }} dní
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <button 
                                        @click="openEditModal(service)" 
                                        class="p-2.5 bg-gray-50 text-gray-400 rounded-xl hover:text-brand-primary-from hover:bg-white hover:shadow-sm transition-all"
                                        title="Upravit"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button
                                        @click="deleteService(service)"
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

        <!-- Modal for Bulk Add -->
        <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showBulkModal" class="fixed inset-0 z-100 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" @click="showBulkModal = false"></div>
                    
                    <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white shadow-2xl transition-all w-full max-w-2xl border border-gray-100">
                        <div class="bg-white p-10 pb-6">
                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <h3 class="text-2xl font-black text-gray-900 font-heading tracking-tight">Hromadné přidání služeb</h3>
                                    <p class="text-gray-400 text-xs font-bold mt-1">Co řádek, to nová služba. Oddělujte sloupce pomocí roury (|).</p>
                                </div>
                                <button @click="showBulkModal = false" type="button" class="text-gray-400 hover:text-gray-900 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-6">
                                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Formát:</p>
                                    <code class="text-xs font-bold text-gray-600 block bg-white p-3 rounded-lg border border-gray-50">
                                        Název|Ikona|Kategorie|Náklady|Marže|Dny|Platba
                                    </code>
                                    <p class="text-[10px] font-medium text-gray-400 mt-2 italic">Příklad: Logo Design|🎨|design|5000|30|3|once</p>
                                    <p class="text-[10px] font-medium text-gray-400 mt-1 italic">Možnosti platby: once (jednorázově), monthly (měsíčně), yearly (ročně)</p>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Data ke vložení</label>
                                    <textarea 
                                        v-model="bulkForm.data" 
                                        rows="10" 
                                        class="block w-full px-5 py-4 bg-gray-50 border-gray-50 rounded-2xl text-sm font-mono text-gray-700 focus:bg-white focus:ring-brand-primary-from focus:border-brand-primary-from transition-all"
                                        placeholder="Název|🎨|design|1000|30|1"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="px-10 py-8 bg-gray-50/50 flex gap-4">
                            <button 
                                @click="submitBulk"
                                type="button" 
                                :disabled="!bulkForm.data"
                                class="flex-1 brand-gradient py-4 rounded-2xl font-black text-white shadow-brand hover:shadow-brand-lg transition-all hover:-translate-y-1 font-heading uppercase tracking-widest text-[10px] disabled:opacity-50 disabled:translate-y-0"
                            >
                                🚀 Hromadně importovat
                            </button>
                            <button @click="showBulkModal = false" type="button" class="px-8 py-4 border-2 border-gray-100 rounded-2xl font-black text-gray-400 hover:text-gray-600 hover:border-gray-200 transition-all font-heading uppercase tracking-widest text-[10px]">
                                Zrušit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>

        <!-- Modal for Create/Edit -->
        <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="showModal" class="fixed inset-0 z-100 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>
                    
                    <div class="relative transform overflow-hidden rounded-[2.5rem] bg-white shadow-2xl transition-all w-full max-w-xl border border-gray-100">
                        <form @submit.prevent="submit">
                            <div class="bg-white p-10 pb-6">
                                <div class="flex items-center justify-between mb-8">
                                    <h3 class="text-2xl font-black text-gray-900 font-heading tracking-tight">
                                        {{ editingService ? 'Upravit službu' : 'Přidat novou službu' }}
                                    </h3>
                                    <button @click="showModal = false" type="button" class="text-gray-400 hover:text-gray-900 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="space-y-6">
                                    <div class="grid grid-cols-12 gap-6">
                                        <div class="col-span-8">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Název služby</label>
                                            <input v-model="form.name" type="text" required class="block w-full px-5 py-3.5 bg-gray-50 border-gray-50 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-brand-primary-from focus:border-brand-primary-from transition-all" placeholder="Např. Tvorba webu">
                                        </div>
                                        <div class="col-span-4">
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Ikona</label>
                                            <input v-model="form.icon" type="text" class="block w-full px-5 py-3.5 bg-gray-50 border-gray-50 rounded-2xl text-center text-xl focus:bg-white focus:ring-brand-primary-from focus:border-brand-primary-from transition-all">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Kategorie</label>
                                        <select v-model="form.category" required class="block w-full px-5 py-3.5 bg-gray-50 border-gray-50 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-brand-primary-from focus:border-brand-primary-from transition-all appearance-none cursor-pointer">
                                            <option value="design">Design</option>
                                            <option value="vyvoj">Vývoj</option>
                                            <option value="obsah">Obsah</option>
                                            <option value="marketing">Marketing</option>
                                            <option value="hosting">Hosting</option>
                                        </select>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Náklady (Kč)</label>
                                            <input v-model="form.cost" type="number" required class="block w-full px-5 py-3.5 bg-gray-50 border-gray-50 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-brand-primary-from focus:border-brand-primary-from transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Marže (%)</label>
                                            <input v-model="form.margin" type="number" required class="block w-full px-5 py-3.5 bg-gray-50 border-gray-50 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-brand-primary-from focus:border-brand-primary-from transition-all">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Odhadovaný čas (dny)</label>
                                            <input v-model="form.days" type="number" required class="block w-full px-5 py-3.5 bg-gray-50 border-gray-50 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-brand-primary-from focus:border-brand-primary-from transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Periodicita platby</label>
                                            <select v-model="form.payment_period" required class="block w-full px-5 py-3.5 bg-gray-50 border-gray-50 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-brand-primary-from focus:border-brand-primary-from transition-all appearance-none cursor-pointer">
                                                <option value="once">Jednorázově</option>
                                                <option value="monthly">Měsíčně</option>
                                                <option value="yearly">Ročně</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-10 py-8 bg-gray-50/50 flex gap-4">
                                <button type="submit" class="flex-1 brand-gradient py-4 rounded-2xl font-black text-white shadow-brand hover:shadow-brand-lg transition-all hover:-translate-y-1 font-heading uppercase tracking-widest text-[10px]">
                                    {{ editingService ? 'Uložit změny' : 'Vytvořit službu' }}
                                </button>
                                <button @click="showModal = false" type="button" class="px-8 py-4 border-2 border-gray-100 rounded-2xl font-black text-gray-400 hover:text-gray-600 hover:border-gray-200 transition-all font-heading uppercase tracking-widest text-[10px]">
                                    Zrušit
                                </button>
                            </div>
                        </form>
                    </div>
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
import { ref, reactive, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import Layout from '../../Components/Layout.vue'
import ConfirmModal from '../../Components/ConfirmModal.vue'

const props = defineProps({
    services: Array
})

const selectedIds = ref([])

const averageMargin = computed(() => {
    if (props.services.length === 0) return 0
    const sum = props.services.reduce((acc, service) => acc + parseFloat(service.margin), 0)
    return Math.round(sum / props.services.length)
})

const showModal = ref(false)
const showBulkModal = ref(false)
const editingService = ref(null)

const confirmDelete = reactive({
    show: false,
    title: '',
    message: '',
    type: 'single', // 'single' or 'bulk'
    item: null
})

const form = reactive({
    name: '',
    category: 'design',
    description: '',
    cost: 0,
    margin: 30,
    days: 0,
    icon: '⚡',
    payment_period: 'once'
})

const bulkForm = reactive({
    data: ''
})

const submitBulk = () => {
    router.post('/services/bulk', bulkForm, {
        onSuccess: () => {
            showBulkModal.value = false
            bulkForm.data = ''
        }
    })
}

const openCreateModal = () => {
    editingService.value = null
    Object.assign(form, {
        name: '',
        category: 'design',
        description: '',
        cost: 0,
        margin: 30,
        days: 0,
        icon: '⚡',
        payment_period: 'once'
    })
    showModal.value = true
}

const openEditModal = (service) => {
    editingService.value = service
    Object.assign(form, {
        name: service.name,
        category: service.category,
        description: service.description,
        cost: service.cost,
        margin: service.margin,
        days: service.days,
        icon: service.icon,
        payment_period: service.payment_period
    })
    showModal.value = true
}

const submit = () => {
    if (editingService.value) {
        router.put(`/services/${editingService.value.id}`, form, {
            onSuccess: () => showModal.value = false
        })
    } else {
        router.post('/services', form, {
            onSuccess: () => showModal.value = false
        })
    }
}

const deleteService = (service) => {
    confirmDelete.title = 'Smazat službu'
    confirmDelete.message = `Opravdu chcete smazat službu "${service.name}"?`
    confirmDelete.type = 'single'
    confirmDelete.item = service
    confirmDelete.show = true
}

const toggleSelectAll = (e) => {
    if (e.target.checked) {
        selectedIds.value = props.services.map(s => s.id)
    } else {
        selectedIds.value = []
    }
}

const bulkDelete = () => {
    confirmDelete.title = 'Hromadné smazání'
    confirmDelete.message = `Opravdu chcete smazat ${selectedIds.value.length} vybraných služeb?`
    confirmDelete.type = 'bulk'
    confirmDelete.show = true
}

const executeDelete = () => {
    if (confirmDelete.type === 'single') {
        router.delete(`/services/${confirmDelete.item.id}`, {
            onSuccess: () => confirmDelete.show = false
        })
    } else if (confirmDelete.type === 'bulk') {
        router.post('/services/bulk-delete', { ids: selectedIds.value }, {
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

const getPeriodLabel = (period) => {
    const labels = {
        once: 'Jednorázově',
        monthly: 'Měsíčně',
        yearly: 'Ročně'
    }
    return labels[period] || period
}

const getPeriodStyles = (period) => {
    const styles = {
        once: 'bg-gray-50 text-gray-500 border-gray-100',
        monthly: 'bg-blue-50 text-blue-600 border-blue-100',
        yearly: 'bg-purple-50 text-purple-600 border-purple-100'
    }
    return styles[period] || 'bg-gray-50 text-gray-500 border-gray-100'
}
</script>

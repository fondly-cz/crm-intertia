<template>
    <Layout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="hero text-center py-12 mb-8 brand-gradient rounded-[2.5rem] text-white shadow-brand-lg">
                <h1 class="text-4xl font-black tracking-tight sm:text-5xl font-heading uppercase">Tvorba nové kalkulace</h1>
                <p class="mt-4 text-xl opacity-90 font-medium italic">Sestavte projekt na míru z našich služeb</p>
            </div>

            <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start relative">
                <!-- Toggle Open Button (Visible when closed) -->
                <div v-if="!isCatalogOpen" class="hidden lg:flex absolute -left-4 top-8 -ml-6 z-20">
                    <button @click="isCatalogOpen = true" class="h-12 w-12 bg-white rounded-full shadow-brand border border-gray-100 flex items-center justify-center text-brand-primary-from hover:scale-110 transition-all" title="Zobrazit katalog">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 font-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Catalog of Services -->
                <div v-show="isCatalogOpen" class="lg:col-span-7 transition-all">
                    <div class="mb-8 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <h2 class="text-2xl font-black text-gray-900 font-heading">Katalog služeb</h2>
                            <button @click="isCatalogOpen = false" class="hidden lg:flex h-8 w-8 bg-gray-50 rounded-full items-center justify-center text-gray-400 hover:text-brand-primary-from hover:bg-brand-primary-from/10 transition-colors hover:scale-110" title="Skrýt katalog">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex gap-2">
                             <div class="px-4 py-2 bg-gray-50 rounded-xl text-xs font-bold text-gray-400 uppercase tracking-widest border border-gray-100">
                                {{ services.length }} položek
                             </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <input 
                            v-model="searchQuery" 
                            type="text" 
                            placeholder="Vyhledat službu..." 
                            class="w-full px-5 py-3.5 bg-white border-2 border-transparent focus:border-brand-primary-from/30 rounded-3xl text-sm font-semibold text-gray-700 shadow-sm focus:bg-white focus:ring-0 transition-all"
                        >
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-50 overflow-hidden">
                        <div>
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50/50 sticky top-0 z-10 backdrop-blur-md border-b border-gray-50">
                                    <tr>
                                        <th class="py-4 pl-6 pr-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Služba</th>
                                        <th class="py-4 px-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Cena</th>
                                        <th class="py-4 px-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Čas</th>
                                        <th class="py-4 pl-3 pr-6 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Přidat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 bg-white">
                                    <tr 
                                        v-for="service in paginatedServices" 
                                        :key="service.id" 
                                        @click="addService(service)"
                                        class="hover:bg-brand-primary-from/5 transition-colors cursor-pointer group"
                                    >
                                        <td class="py-4 pl-6 pr-3">
                                            <div class="flex items-center gap-4">
                                                <div class="h-10 w-10 bg-gray-50 rounded-xl flex items-center justify-center text-xl shadow-sm group-hover:bg-white transition-colors shrink-0">
                                                    {{ service.icon }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-black text-gray-900 font-heading">{{ service.name }}</div>
                                                    <div class="text-xs text-gray-500 line-clamp-1 mt-0.5 max-w-sm">{{ service.description }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-3 text-right">
                                            <div class="text-sm font-black brand-text-gradient font-heading">{{ formatCurrency(calculatePrice(service) * (form.show_vat ? 1.21 : 1)) }}</div>
                                            <div class="text-[8px] font-black uppercase tracking-widest text-gray-400 mt-0.5">{{ getPeriodLabel(service.payment_period) }} {{ form.show_vat ? 's DPH' : '' }}</div>
                                        </td>
                                        <td class="py-4 px-3 text-center">
                                            <div class="text-xs font-black text-gray-700">{{ service.days }} dní</div>
                                        </td>
                                        <td class="py-4 pl-3 pr-6 text-center">
                                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-brand-primary-from group-hover:bg-brand-primary-from group-hover:text-white transition-all shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 font-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="filteredServices.length === 0">
                                        <td colspan="4" class="py-12 text-center text-gray-400 font-bold text-sm">Nic nenalezeno</td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <!-- Pagination Controls -->
                            <div v-if="filteredServices.length > 0" class="flex flex-col sm:flex-row items-center justify-between border-t border-gray-100 bg-gray-50/50 px-6 py-4">
                                <div class="flex items-center gap-3 text-sm text-gray-500 font-medium">
                                    Zobrazeno {{ paginationStart }} - {{ paginationEnd }} z {{ filteredServices.length }}
                                    <select v-model="perPage" class="ml-2 text-xs font-bold bg-white border-gray-200 rounded-lg focus:ring-brand-primary-from focus:border-brand-primary-from">
                                        <option disabled value="">Zobrazit po...</option>
                                        <option :value="20">20 na stránku</option>
                                        <option :value="50">50 na stránku</option>
                                        <option :value="100">100 na stránku</option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-2 mt-4 sm:mt-0">
                                    <button 
                                        @click="currentPage--" 
                                        :disabled="currentPage === 1"
                                        class="px-3 py-1.5 text-sm font-bold bg-white border border-gray-200 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                                    >Předchozí</button>
                                    <span class="text-sm font-bold text-gray-700 mx-2">{{ currentPage }} / {{ totalPages }}</span>
                                    <button 
                                        @click="currentPage++" 
                                        :disabled="currentPage >= totalPages"
                                        class="px-3 py-1.5 text-sm font-bold bg-white border border-gray-200 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                                    >Další</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Structure and Summary -->
                <div class="mt-16 lg:mt-0 space-y-8 transition-all duration-300" :class="isCatalogOpen ? 'lg:col-span-5' : 'lg:col-span-12'">
                    <!-- Added Items (Hierarchical Builder) -->
                    <div class="bg-white rounded-[2.5rem] shadow-brand overflow-hidden border border-gray-50">
                        <div class="bg-gray-900 px-8 py-8 text-white relative overflow-hidden">
                            <div class="absolute right-0 top-0 h-full w-32 brand-gradient opacity-20 blur-3xl pointer-events-none"></div>
                            <div class="flex justify-between items-center relative z-10">
                                <div>
                                    <h3 class="text-xl font-bold font-heading uppercase tracking-widest">Struktura projektu</h3>
                                    <p class="text-gray-400 text-xs mt-1 font-medium">Kliknutím na "➕" u položky přidáte podslužbu</p>
                                </div>
                                <label class="flex items-center gap-2 cursor-pointer group/vat bg-white/5 hover:bg-white/10 px-4 py-2 rounded-2xl transition-all border border-white/10">
                                    <div class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" v-model="form.show_vat" class="sr-only peer">
                                        <div class="w-8 h-4 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:inset-s-[2px] after:bg-white after:border-gray-600 after:border after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-brand-primary-from"></div>
                                    </div>
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest group-hover/vat:text-white transition-colors">Ceny s DPH</span>
                                </label>
                            </div>
                        </div>

                        <div class="p-8">
                            <!-- Drop Zone for Root Level -->
                            <div 
                                v-if="form.services.length > 0"
                                @dragover.prevent="dropTargetIndex = 'root'"
                                @dragleave="dropTargetIndex = null"
                                @drop="handleDrop(null)"
                                class="mb-6 p-4 rounded-2xl border-2 border-dashed transition-all flex items-center justify-center gap-3 group/root"
                                :class="dropTargetIndex === 'root' ? 'border-brand-primary-from bg-brand-primary-from/5 scale-[1.02]' : 'border-gray-100 opacity-40 hover:opacity-100'"
                            >
                                <span class="text-xl">🏠</span>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-hover/root:text-brand-primary-from transition-colors">Přetáhněte sem pro hlavní úroveň</span>
                            </div>

                            <div v-if="form.services.length === 0" class="py-16 text-center border-2 border-dashed border-gray-100 rounded-[2.5rem] bg-gray-50/50">
                                <div class="text-5xl mb-6 grayscale opacity-30">📂</div>
                                <p class="text-gray-400 font-bold font-heading uppercase tracking-widest text-xs">Zatím jste nic nevybrali</p>
                            </div>

                            <div v-else class="space-y-4">
                                <!-- N-level Nested Items Display -->
                                <CalculationItemNode 
                                    v-for="item in rootItems" 
                                    :key="item.unique_id"
                                    :item="item"
                                    :all-items="form.services"
                                    :dragged-id="draggedId"
                                    :drop-target-id="dropTargetId"
                                    :show-vat="form.show_vat"
                                    @drag-start="handleNodeDragStart"
                                    @set-drop-target="dropTargetId = $event"
                                    @clear-drop-target="dropTargetId = null"
                                    @drop-item="handleDrop"
                                    @remove-item="removeService"
                                />
                                </div>

                            <div class="mt-10 pt-8 border-t-2 border-gray-100 space-y-4">
                                    <div class="flex justify-between items-center bg-brand-primary-from/5 p-6 rounded-3xl border border-brand-primary-from/10">
                                        <span class="text-xs font-black text-gray-500 uppercase tracking-[0.2em] font-heading">
                                            Investice (jednorázově) {{ form.show_vat ? 's DPH' : 'bez DPH' }}
                                        </span>
                                        <span class="text-4xl font-black brand-text-gradient font-heading line-height-none tracking-tighter">
                                            {{ formatCurrency(totalsByPeriod.once * (form.show_vat ? 1.21 : 1)) }}
                                        </span>
                                    </div>

                                    <!-- Recurring Costs UI -->
                                    <div v-if="totalsByPeriod.monthly > 0 || totalsByPeriod.yearly > 0" class="p-6 bg-gray-50 rounded-3xl border border-gray-100">
                                        <div class="flex justify-between items-center">
                                            <div class="flex flex-col">
                                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-heading mb-2">Provozní náklady</span>
                                                <div class="flex bg-white p-1 rounded-xl shadow-sm border border-gray-100">
                                                    <button 
                                                        @click="recurringPeriod = 'monthly'"
                                                        class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all"
                                                        :class="recurringPeriod === 'monthly' ? 'bg-brand-primary-from text-white shadow-sm' : 'text-gray-400 hover:text-gray-600'"
                                                    >Měsíčně</button>
                                                    <button 
                                                        @click="recurringPeriod = 'yearly'"
                                                        class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all"
                                                        :class="recurringPeriod === 'yearly' ? 'bg-brand-primary-from text-white shadow-sm' : 'text-gray-400 hover:text-gray-600'"
                                                    >Ročně</button>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-2xl font-black text-gray-900 font-heading">
                                                    {{ formatCurrency(recurringTotal * (form.show_vat ? 1.21 : 1)) }}
                                                </div>
                                                <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest">
                                                    {{ recurringPeriod === 'monthly' ? '/ měsíc' : '/ rok' }} {{ form.show_vat ? 's DPH' : '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price Breakdown -->
                                    <div v-if="form.services.length > 0" class="px-6 py-2 space-y-2">
                                        <div v-if="totalsByPeriod.once > 0" class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                            <span>Jednorázově</span>
                                            <span class="text-gray-900">{{ formatCurrency(totalsByPeriod.once * (form.show_vat ? 1.21 : 1)) }}</span>
                                        </div>
                                        <div v-if="totalsByPeriod.monthly > 0" class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                            <span>Měsíčně</span>
                                            <span class="text-gray-900">{{ formatCurrency(totalsByPeriod.monthly * (form.show_vat ? 1.21 : 1)) }}</span>
                                        </div>
                                        <div v-if="totalsByPeriod.yearly > 0" class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                            <span>Ročně</span>
                                            <span class="text-gray-900">{{ formatCurrency(totalsByPeriod.yearly * (form.show_vat ? 1.21 : 1)) }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-4 px-6">
                                        <div class="grow h-0.5 bg-gray-50"></div>
                                        <div class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">Shrnutí času</div>
                                        <div class="grow h-0.5 bg-gray-50"></div>
                                    </div>

                                    <div class="flex justify-center items-center gap-3 py-2">
                                        <span class="text-3xl font-black text-gray-900 font-heading">{{ totalDays }}</span>
                                        <span class="text-xs font-black text-gray-400 uppercase tracking-widest mt-1">pracovních dní</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Customer Data -->
                    <div class="bg-white rounded-[2.5rem] shadow-brand p-10 border border-gray-50 relative overflow-hidden">
                        <div class="absolute -right-20 -top-20 h-64 w-64 brand-gradient opacity-10 rounded-full blur-3xl pointer-events-none"></div>
                        
                        <h2 class="text-lg font-black text-gray-900 mb-8 border-b-2 border-gray-50 pb-6 font-heading uppercase tracking-widest relative z-10">Detaily poptávky</h2>
                        <div class="space-y-6 relative z-10">
                            <!-- autocomplete block -->
                            <div class="relative">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Vybrat firmu z databáze (nebo vyplnit ručně)</label>
                                <input 
                                    v-model="companySearchQuery" 
                                    type="text" 
                                    class="w-full px-5 py-3.5 bg-gray-50 border-gray-100 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-2 focus:ring-brand-primary-from focus:border-brand-primary-from transition-all pr-10" 
                                    placeholder="Hledat podle názvu nebo IČO..."
                                    @focus="showCompanyResults = companySearchQuery.length > 1"
                                    @input="onSearchInput"
                                >
                                <div v-if="isSearching" class="absolute right-3 top-10 flex items-center pr-1 h-full">
                                    <svg class="animate-spin h-5 w-5 text-brand-primary-from" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <div 
                                    v-if="showCompanyResults && companySearchResults.length > 0" 
                                    class="absolute z-20 w-full mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
                                >
                                    <ul class="max-h-60 overflow-y-auto">
                                        <li 
                                            v-for="company in companySearchResults" 
                                            :key="company.id"
                                            @click="selectCompany(company)"
                                            class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-0"
                                        >
                                            <div class="font-bold text-gray-900 text-sm">{{ company.name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">
                                                <span v-if="company.ico">IČO: {{ company.ico }}</span>
                                                <span v-if="company.ico && company.email"> • </span>
                                                <span v-if="company.email">{{ company.email }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div 
                                    v-if="showCompanyResults && companySearchQuery.length > 1 && companySearchResults.length === 0 && !isSearching" 
                                    class="absolute z-20 w-full mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden px-4 py-3 text-sm text-gray-500 text-center"
                                >
                                    Žádná firma nebyla nalezena
                                </div>
                            </div>
                            <!-- end autocomplete block -->

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Jméno klienta</label>
                                <input v-model="form.customer_name" type="text" required class="w-full px-5 py-3.5 bg-gray-50 border-gray-100 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-2 focus:ring-brand-primary-from focus:border-brand-primary-from transition-all" placeholder="Napoleon Bonaparte">
                                <div v-if="form.errors.customer_name" class="mt-2 text-xs text-red-500 font-bold ml-1">{{ form.errors.customer_name }}</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">E-mail</label>
                                    <input v-model="form.customer_email" type="email" required class="w-full px-5 py-3.5 bg-gray-50 border-gray-100 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-2 focus:ring-brand-primary-from focus:border-brand-primary-from transition-all" placeholder="e@mail.cz">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Telefon</label>
                                    <input v-model="form.customer_phone" type="tel" required class="w-full px-5 py-3.5 bg-gray-50 border-gray-100 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-2 focus:ring-brand-primary-from focus:border-brand-primary-from transition-all" placeholder="+420 000 000 000">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Firma (nepovinné)</label>
                                <input v-model="form.customer_company" type="text" class="w-full px-5 py-3.5 bg-gray-50 border-gray-100 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-2 focus:ring-brand-primary-from focus:border-brand-primary-from transition-all" placeholder="Název firmy">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Interní poznámka</label>
                                <textarea v-model="form.note" rows="3" class="w-full px-5 py-3.5 bg-gray-50 border-gray-100 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-2 focus:ring-brand-primary-from focus:border-brand-primary-from transition-all" placeholder="Např. klient spěchá na logo..."></textarea>
                            </div>

                            <button 
                                @click="submit"
                                :disabled="form.processing || form.services.length === 0"
                                class="mt-4 w-full brand-gradient text-white font-black py-5 rounded-3xl shadow-brand hover:shadow-brand-lg transition-all hover:-translate-y-1 flex justify-center items-center font-heading text-lg uppercase tracking-widest disabled:opacity-50 disabled:translate-y-0"
                            >
                                <span v-if="form.processing">Zpracovávám...</span>
                                <span v-else>🚀 Vytvořit kalkulaci</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { computed, ref, watch, onMounted, onUnmounted } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import Layout from '../../Components/Layout.vue'
import CalculationItemNode from '../../Components/CalculationItemNode.vue'
import debounce from 'lodash/debounce'

const props = defineProps({
    services: Array
})

const user = usePage().props.auth.user

const isCatalogOpen = ref(true)
const searchQuery = ref('')
const perPage = ref(20)
const currentPage = ref(1)

const filteredServices = computed(() => {
    let result = props.services
    if (searchQuery.value) {
        const q = searchQuery.value.toLowerCase()
        result = result.filter(s => 
            s.name.toLowerCase().includes(q) || 
            (s.description && s.description.toLowerCase().includes(q))
        )
    }
    return result
})

// Reset array when filters change
watch(searchQuery, () => {
    currentPage.value = 1
})
watch(perPage, () => {
    currentPage.value = 1
})

const companySearchQuery = ref('')
const companySearchResults = ref([])
const isSearching = ref(false)
const showCompanyResults = ref(false)

const performCompanySearch = debounce(async () => {
    if (companySearchQuery.value.length < 2) {
        showCompanyResults.value = false
        companySearchResults.value = []
        isSearching.value = false
        return
    }

    isSearching.value = true
    try {
        const response = await fetch(`/api/companies/search?q=${encodeURIComponent(companySearchQuery.value)}`)
        const data = await response.json()
        companySearchResults.value = data
        showCompanyResults.value = true
    } catch (error) {
        console.error('Error fetching companies:', error)
    } finally {
        isSearching.value = false
    }
}, 300)

const onSearchInput = () => {
    isSearching.value = true
    showCompanyResults.value = true
    performCompanySearch()
}

const selectCompany = (company) => {
    form.customer_name = company.name
    form.customer_company = company.name
    if (company.email) form.customer_email = company.email
    if (company.phone) form.customer_phone = company.phone
    
    companySearchQuery.value = company.name
    showCompanyResults.value = false
}

// Close autocomplete when clicking outside
const handleClickOutside = (e) => {
    if (!e.target.closest('.relative')) {
        showCompanyResults.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})

const totalPages = computed(() => {
    return Math.ceil(filteredServices.value.length / perPage.value) || 1
})

const paginatedServices = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    return filteredServices.value.slice(start, start + perPage.value)
})

const paginationStart = computed(() => {
    if (filteredServices.value.length === 0) return 0
    return ((currentPage.value - 1) * perPage.value) + 1
})

const paginationEnd = computed(() => {
    const end = currentPage.value * perPage.value
    return end > filteredServices.value.length ? filteredServices.value.length : end
})

const form = useForm({
    customer_name: user?.name || '',
    customer_email: user?.email || '',
    customer_phone: user?.phone || '',
    customer_company: user?.company || '',
    note: '',
    show_vat: false,
    services: [] // { unique_id, parent_id: null }
})

const draggedId = ref(null)
const dropTargetId = ref(null)

const rootItems = computed(() => {
    return form.services.filter(s => s.parent_id === null)
})

const handleNodeDragStart = (data) => {
    draggedId.value = data.id
    data.event.dataTransfer.effectAllowed = 'move'
}

const handleDrop = (targetId) => {
    if (!draggedId.value || targetId === draggedId.value) return
    
    // Prevent cycle: Don't allow dropping on a target that is already a child of the dragged item
    const isDescendant = (parentUniqueId, targetUniqueId) => {
        const children = form.services.filter(s => s.parent_id === parentUniqueId)
        for (const child of children) {
            if (child.unique_id === targetUniqueId) return true
            if (isDescendant(child.unique_id, targetUniqueId)) return true
        }
        return false
    }

    if (targetId !== null && isDescendant(draggedId.value, targetId)) return

    const dragItem = form.services.find(s => s.unique_id === draggedId.value)
    
    if (targetId === null) {
        dragItem.parent_id = null
    } else {
        dragItem.parent_id = targetId
    }
    
    draggedId.value = null
    dropTargetId.value = null
}

const addService = (service) => {
    form.services.push({ 
        unique_id: Math.random().toString(36).substr(2, 9),
        id: service.id, 
        parent_id: null,
        is_required: false,
        name: service.name,
        icon: service.icon,
        description: service.description,
        price: calculatePrice(service),
        days: service.days,
        payment_period: service.payment_period
    })
}

const removeService = (idToRemove) => {
    // Collect all descendants to remove them too
    const idsToRemove = [idToRemove]
    
    const collectDescendants = (parentId) => {
        form.services.forEach(s => {
            if (s.parent_id === parentId) {
                idsToRemove.push(s.unique_id)
                collectDescendants(s.unique_id)
            }
        })
    }
    collectDescendants(idToRemove)
    
    form.services = form.services.filter(s => !idsToRemove.includes(s.unique_id))
}

const calculatePrice = (service) => {
    return parseFloat(service.cost) * (1 + parseFloat(service.margin) / 100)
}

const totalPrice = computed(() => {
    return form.services.reduce((total, s) => total + (parseFloat(s.price) || 0), 0)
})

const totalDays = computed(() => {
    return form.services.reduce((total, s) => total + (parseInt(s.days) || 0), 0)
})

const totalsByPeriod = computed(() => {
    const totals = { once: 0, monthly: 0, yearly: 0 }
    form.services.forEach(s => {
        if (totals[s.payment_period] !== undefined) {
            totals[s.payment_period] += (parseFloat(s.price) || 0)
        }
    })
    return totals
})

const recurringPeriod = ref('monthly')

const recurringTotal = computed(() => {
    if (recurringPeriod.value === 'monthly') {
        return totalsByPeriod.value.monthly + (totalsByPeriod.value.yearly / 12)
    } else {
        return (totalsByPeriod.value.monthly * 12) + totalsByPeriod.value.yearly
    }
})

const submit = () => {
    // Before submission, we might want to clean up helper metadata but Inertia handles data just fine
    form.post('/calculations')
}

const formatCurrency = (value) => {
    return new Intl.NumberFormat('cs-CZ', { style: 'currency', currency: 'CZK', minimumFractionDigits: 0 }).format(value)
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

<style scoped>
.brand-text-gradient {
    background: linear-gradient(135deg, var(--color-brand-primary-from), var(--color-brand-primary-to));
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>

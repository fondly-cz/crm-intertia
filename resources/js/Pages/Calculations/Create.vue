<template>
    <Layout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="hero text-center py-12 mb-8 brand-gradient rounded-[2.5rem] text-white shadow-brand-lg">
                <h1 class="text-4xl font-black tracking-tight sm:text-5xl font-heading uppercase">Tvorba nové kalkulace</h1>
                <p class="mt-4 text-xl opacity-90 font-medium italic">Sestavte projekt na míru z našich služeb</p>
            </div>

            <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
                <!-- Catalog of Services -->
                <div class="lg:col-span-7">
                    <div class="mb-8 flex items-center justify-between">
                        <h2 class="text-2xl font-black text-gray-900 font-heading">Katalog služeb</h2>
                        <div class="flex gap-2">
                             <div class="px-4 py-2 bg-gray-50 rounded-xl text-xs font-bold text-gray-400 uppercase tracking-widest border border-gray-100">
                                {{ services.length }} položek
                             </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div 
                            v-for="service in services" 
                            :key="service.id"
                            @click="addService(service)"
                            class="group relative rounded-3xl border-2 p-6 cursor-pointer transition-all hover:shadow-brand bg-white border-gray-50 hover:border-brand-primary-from/50 overflow-hidden"
                        >
                            <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity text-gray-900 group-hover:scale-110 duration-500">
                                <span class="text-7xl">{{ service.icon }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between relative z-10">
                                <div class="h-14 w-14 bg-gray-50 rounded-2xl flex items-center justify-center text-3xl group-hover:bg-white transition-colors shadow-sm border border-gray-100/50">
                                    {{ service.icon }}
                                </div>
                                <div class="p-2 bg-brand-primary-from/5 text-brand-primary-from rounded-xl opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 font-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="mt-6 relative z-10">
                                <h3 class="text-lg font-black text-gray-900 font-heading tracking-tight leading-none">{{ service.name }}</h3>
                                <p class="mt-2 text-xs text-gray-500 font-medium line-clamp-2 leading-relaxed h-8">{{ service.description }}</p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-50 flex items-center justify-between relative z-10">
                                <span class="text-lg font-black brand-text-gradient font-heading">{{ formatCurrency(calculatePrice(service)) }}</span>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">⏱ {{ service.days }} dní</span>
                                    <span 
                                        class="text-[8px] font-black uppercase tracking-widest px-1.5 py-0.5 rounded border"
                                        :class="getPeriodStyles(service.payment_period)"
                                    >
                                        {{ getPeriodLabel(service.payment_period) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Structure and Summary -->
                <div class="mt-16 lg:mt-0 lg:col-span-5 space-y-8">
                    <!-- Added Items (Hierarchical Builder) -->
                    <div class="bg-white rounded-[2.5rem] shadow-brand overflow-hidden border border-gray-50">
                        <div class="bg-gray-900 px-8 py-8 text-white relative overflow-hidden">
                            <div class="absolute right-0 top-0 h-full w-32 brand-gradient opacity-20 blur-3xl pointer-events-none"></div>
                            <h3 class="text-xl font-bold font-heading uppercase tracking-widest relative z-10">Struktura projektu</h3>
                            <p class="text-gray-400 text-xs mt-1 font-medium relative z-10">Kliknutím na "➕" u položky přidáte podslužbu</p>
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

                            <div v-else class="space-y-8">
                                <!-- Grouped Items Display -->
                                <div v-for="(group, index) in groupedSelectedItems" :key="index" class="space-y-4">
                                    <!-- Parent Item Card -->
                                    <div 
                                        draggable="true"
                                        @dragstart="handleDragStart($event, group.originalIndex)"
                                        @dragover.prevent="isValidDropTarget(group.originalIndex) ? dropTargetIndex = group.originalIndex : null"
                                        @dragleave="dropTargetIndex = null"
                                        @drop="handleDrop(group.originalIndex)"
                                        class="relative group bg-white border-2 rounded-3xl p-5 transition-all shadow-sm flex items-center gap-4 cursor-move"
                                        :class="[
                                            dropTargetIndex === group.originalIndex ? 'border-brand-primary-from bg-brand-primary-from/5 scale-[1.02]' : 'border-gray-100 hover:border-brand-primary-from/30',
                                            draggedIndex === group.originalIndex ? 'opacity-30' : ''
                                        ]"
                                    >
                                        <button @click="removeService(group.originalIndex)" class="absolute -right-2 -top-2 h-7 w-7 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg hover:scale-110 z-20">
                                            <span class="text-xs font-bold">×</span>
                                        </button>

                                        <div class="h-10 w-10 bg-gray-50 rounded-xl flex items-center justify-center text-xl shadow-sm group-hover:bg-white transition-colors">
                                            {{ group.icon }}
                                        </div>
                                        <div class="grow">
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-sm font-black text-gray-900 font-heading leading-tight">{{ group.name }}</h4>
                                                <span 
                                                    class="px-2 py-0.5 text-[8px] font-black rounded-lg uppercase tracking-widest border"
                                                    :class="getPeriodStyles(group.payment_period)"
                                                >
                                                    {{ getPeriodLabel(group.payment_period) }}
                                                </span>
                                                <span v-if="group.children.length > 0" class="px-2 py-0.5 bg-gray-100 text-[8px] font-black rounded-lg text-gray-400 uppercase tracking-widest">{{ group.children.length }} podslužeb</span>
                                            </div>
                                            <div class="flex items-center gap-3 mt-2">
                                                <div class="relative">
                                                    <input 
                                                        v-model.number="form.services[group.originalIndex].price" 
                                                        type="number" 
                                                        class="w-24 px-2 py-1 text-xs font-black brand-text-gradient bg-gray-50 border-none rounded-lg focus:ring-1 focus:ring-brand-primary-from transition-all"
                                                        placeholder="Cena"
                                                    >
                                                    <div class="absolute right-2 top-1.5 text-[8px] font-black pointer-events-none opacity-30">Kč</div>
                                                </div>
                                                <div class="relative">
                                                    <input 
                                                         v-model.number="form.services[group.originalIndex].days" 
                                                         type="number" 
                                                         class="w-16 px-2 py-1 text-xs font-black text-gray-500 bg-gray-50 border-none rounded-lg focus:ring-1 focus:ring-brand-primary-from transition-all"
                                                         placeholder="Dny"
                                                     >
                                                     <div class="absolute right-1 top-1.5 text-[8px] font-black pointer-events-none opacity-30">dní</div>
                                                 </div>
                                             </div>
                                             <div class="mt-3">
                                                 <textarea 
                                                     v-model="form.services[group.originalIndex].description" 
                                                     rows="2" 
                                                     class="w-full px-3 py-2 text-xs text-gray-500 bg-gray-50 border-none rounded-xl focus:ring-1 focus:ring-brand-primary-from transition-all resize-none"
                                                     placeholder="Popis služby (zobrazí se zákazníkovi)..."
                                                 ></textarea>
                                             </div>
                                         </div>
                                        <div class="p-2 text-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 8h16M4 16h16" />
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Indented Children -->
                                    <div v-if="group.children.length > 0" class="ml-8 pl-6 border-l-2 border-dashed border-gray-100 space-y-3">
                                        <div 
                                            v-for="child in group.children" 
                                            :key="child.originalIndex"
                                            draggable="true"
                                            @dragstart="handleDragStart($event, child.originalIndex)"
                                            class="relative group bg-gray-50/50 rounded-2xl p-4 flex items-center gap-3 cursor-move hover:bg-white border-2 border-transparent hover:border-brand-primary-from/20 transition-all"
                                            :class="draggedIndex === child.originalIndex ? 'opacity-30' : ''"
                                        >
                                            <button @click="removeService(child.originalIndex)" class="absolute -right-2 -top-2 h-6 w-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm hover:scale-110 z-20">
                                                <span class="text-xs font-bold">×</span>
                                            </button>
                                            <span class="text-lg">{{ child.icon }}</span>
                                            <div class="grow">
                                                <div class="flex items-center gap-2">
                                                    <h5 class="text-xs font-bold text-gray-700 leading-tight">{{ child.name }}</h5>
                                                    <span 
                                                        class="px-1.5 py-0.5 text-[7px] font-black rounded-md uppercase tracking-widest border"
                                                        :class="getPeriodStyles(child.payment_period)"
                                                    >
                                                        {{ getPeriodLabel(child.payment_period) }}
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <input 
                                                        v-model.number="form.services[child.originalIndex].price" 
                                                        type="number" 
                                                        class="w-20 px-1.5 py-0.5 text-[10px] font-black brand-text-gradient bg-white border-none rounded-md focus:ring-1 focus:ring-brand-primary-from transition-all"
                                                    >
                                                    <input 
                                                        v-model.number="form.services[child.originalIndex].days" 
                                                        type="number" 
                                                        class="w-12 px-1.5 py-0.5 text-[10px] font-black text-gray-400 bg-white border-none rounded-md focus:ring-1 focus:ring-brand-primary-from transition-all"
                                                    >
                                                </div>
                                                <div class="mt-2">
                                                    <textarea 
                                                        v-model="form.services[child.originalIndex].description" 
                                                        rows="1" 
                                                        class="w-full px-2 py-1 text-[10px] text-gray-500 bg-white border-none rounded-lg focus:ring-1 focus:ring-brand-primary-from transition-all resize-none"
                                                        placeholder="Popis služby..."
                                                    ></textarea>
                                                </div>
                                            </div>
                                            <div class="p-1 text-gray-200 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 8h16M4 16h16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-10 pt-8 border-t-2 border-gray-100 space-y-4">
                                    <div class="flex justify-between items-center bg-brand-primary-from/5 p-6 rounded-3xl border border-brand-primary-from/10">
                                        <span class="text-xs font-black text-gray-500 uppercase tracking-[0.2em] font-heading">Celková cena</span>
                                        <span class="text-3xl font-black brand-text-gradient font-heading line-height-none">{{ formatCurrency(totalPrice) }}</span>
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
                    </div>

                    <!-- Customer Data -->
                    <div class="bg-white rounded-[2.5rem] shadow-brand p-10 border border-gray-50 relative overflow-hidden">
                        <div class="absolute -right-20 -top-20 h-64 w-64 brand-gradient opacity-10 rounded-full blur-3xl pointer-events-none"></div>
                        
                        <h2 class="text-lg font-black text-gray-900 mb-8 border-b-2 border-gray-50 pb-6 font-heading uppercase tracking-widest relative z-10">Detaily poptávky</h2>
                        <div class="space-y-6 relative z-10">
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
                                <input v-model="form.customer_company" type="text" class="w-full px-5 py-3.5 bg-gray-50 border-gray-100 rounded-2xl text-sm font-semibold text-gray-700 focus:bg-white focus:ring-2 focus:ring-brand-primary-from focus:border-brand-primary-from transition-all">
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
import { computed, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import Layout from '../../Components/Layout.vue'

const props = defineProps({
    services: Array
})

const user = usePage().props.auth.user

const form = useForm({
    customer_name: user?.name || '',
    customer_email: user?.email || '',
    customer_phone: user?.phone || '',
    customer_company: user?.company || '',
    note: '',
    services: [] // { id, parent_index: null }
})

const draggedIndex = ref(null)
const dropTargetIndex = ref(null)

const handleDragStart = (e, index) => {
    draggedIndex.value = index
    e.dataTransfer.effectAllowed = 'move'
}

const handleDrop = (targetIndex) => {
    if (draggedIndex.value === null) return
    
    const dragIdx = draggedIndex.value
    
    // targetIndex is null if dropped on root zone
    if (targetIndex === null) {
        form.services[dragIdx].parent_index = null
    } else if (targetIndex !== dragIdx && isValidDropTarget(targetIndex)) {
        form.services[dragIdx].parent_index = targetIndex
    }
    
    draggedIndex.value = null
    dropTargetIndex.value = null
}

const isValidDropTarget = (targetIndex) => {
    if (draggedIndex.value === null) return false
    if (draggedIndex.value === targetIndex) return false
    
    // Enforce 1-level limit:
    // 1. Target must be a root item
    const targetIsRoot = form.services[targetIndex].parent_index === null
    if (!targetIsRoot) return false
    
    // 2. Dragged item must not have children (to prevent 2nd level)
    // Or we could allow it but it would detach its children? 
    // Let's check for children:
    const hasChildren = form.services.some(s => s.parent_index === draggedIndex.value)
    if (hasChildren) return false
    
    return true
}

const addService = (service) => {
    form.services.push({ 
        id: service.id, 
        parent_index: null,
        // Helper metadata for UI
        name: service.name,
        icon: service.icon,
        description: service.description,
        price: calculatePrice(service),
        days: service.days,
        payment_period: service.payment_period
    })
}

const removeService = (index) => {
    // If we remove an item, we must update all parent_indexes that point to something after this index
    const removedIndex = index
    
    // First, clear any children of this item (set them to main)
    form.services.forEach((s, i) => {
        if (s.parent_index === removedIndex) {
            s.parent_index = null
        }
    })

    // Remove the item
    form.services.splice(index, 1)

    // Adjust remaining indexes
    form.services.forEach((s, i) => {
        if (s.parent_index !== null && s.parent_index > removedIndex) {
            s.parent_index--
        }
    })
}



// Logic to group items for hierarchical visual display in the builder
const groupedSelectedItems = computed(() => {
    // Items that have no parent
    const parents = form.services
        .map((s, i) => ({ ...s, originalIndex: i }))
        .filter(s => s.parent_index === null)
    
    return parents.map(p => {
        const children = form.services
            .map((s, i) => ({ ...s, originalIndex: i }))
            .filter(s => s.parent_index === p.originalIndex)
        
        const totalGroupPrice = p.price + children.reduce((sum, c) => sum + c.price, 0)
        
        return {
            ...p,
            children,
            totalGroupPrice
        }
    })
})

const calculatePrice = (service) => {
    return parseFloat(service.cost) * (1 + parseFloat(service.margin) / 100)
}

const totalPrice = computed(() => {
    return form.services.reduce((total, s) => total + s.price, 0)
})

const totalDays = computed(() => {
    return form.services.reduce((total, s) => total + s.days, 0)
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

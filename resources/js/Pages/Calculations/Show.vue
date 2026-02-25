<template>
    <Layout :hideNav="is_public">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8 flex justify-between items-center">
                <Link v-if="!is_public" href="/calculations" class="text-gray-500 hover:text-brand-primary-from flex items-center gap-2 font-bold font-heading transition-colors">
                    <span class="text-xl">←</span> Zpět na seznam
                </Link>
                <div v-else class="flex items-center gap-3">
                    <img src="/logo.svg" alt="MojiMili Logo" class="h-10 w-auto" />
                    <span class="text-xl font-extrabold brand-text-gradient font-heading">MojiMili</span>
                </div>

                <div class="flex gap-4">
                    <div v-if="calculation.status === 'confirmed'" class="px-5 py-2.5 bg-green-50 text-green-600 rounded-full flex items-center gap-2 font-bold text-sm border border-green-100 shadow-sm animate-pulse-slow">
                        <span>✓ Nabídka potvrzena</span>
                    </div>
                    <button @click="print" class="inline-flex items-center px-6 py-3 border-2 border-gray-100 shadow-sm text-sm font-bold rounded-full text-gray-700 bg-white hover:bg-gray-50 transition-all font-heading">
                        🖨️ PDF / Tisk
                    </button>
                    <button v-if="!is_public" @click="shareEmail" class="inline-flex items-center px-6 py-3 brand-gradient text-sm font-bold rounded-full shadow-brand text-white hover:shadow-brand-lg transition-all hover:-translate-y-0.5 font-heading">
                        ✉️ Poslat klientovi
                    </button>
                </div>
            </div>

            <!-- The Quote Card -->
            <div id="print-area" class="bg-white shadow-brand-lg rounded-brand overflow-hidden border border-gray-50 relative">
                <!-- Status Overlay for Confirmed -->
                <div v-if="calculation.status === 'confirmed'" class="absolute -right-16 top-10 bg-green-500 text-white px-20 py-2 rotate-45 font-bold shadow-lg z-10 uppercase tracking-widest text-xs pointer-events-none">
                    Potvrzeno
                </div>
                <div class="brand-gradient px-10 py-12 text-white flex justify-between items-end">
                    <div>
                        <h1 class="text-4xl font-extrabold font-heading">Cenová nabídka</h1>
                        <p class="text-white/70 mt-1 font-medium italic">Referenční číslo: #{{ calculation.id.toString().padStart(6, '0') }}</p>
                    </div>
                </div>

                <div class="p-10">
                    <div class="grid grid-cols-2 gap-12 mb-16">
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 font-heading">Pro zákazníka</h3>
                            <div class="text-xl font-extrabold text-gray-900 font-heading">{{ calculation.customer_name }}</div>
                            <div class="text-gray-600 font-medium mt-1">{{ calculation.customer_company }}</div>
                            <div class="text-gray-500 text-sm mt-3 flex flex-col gap-1">
                                <span>📧 {{ calculation.customer_email }}</span>
                                <span>📞 {{ calculation.customer_phone }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 font-heading">Detaily</h3>
                            <div class="text-xl font-extrabold text-gray-900 font-heading">{{ formatDate(calculation.created_at) }}</div>
                            <div class="text-gray-500 font-medium mt-1 italic">Platnost nabídky 30 dní</div>
                        </div>
                    </div>

                    <div v-if="is_public && calculation.status !== 'confirmed'" class="mb-10 p-5 bg-indigo-50/50 rounded-2xl border border-indigo-100 flex items-center gap-4">
                        <div class="h-12 w-12 brand-gradient rounded-full flex items-center justify-center text-white text-2xl shadow-brand">✨</div>
                        <p class="text-sm text-indigo-900 font-medium leading-relaxed">
                            <strong>Interaktivní výběr:</strong> Zaškrtněte služby, o které máte zájem. Cena a čas se okamžitě přepočítají. Jakmile budete hotovi, potvrďte výběr tlačítkem dole.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div v-for="group in groupedItems" :key="group.id" class="border-b border-gray-50 last:border-0 pb-6">
                            <!-- Parent Item -->
                            <div 
                                :class="{ 
                                    'opacity-50 grayscale bg-gray-50/50': is_public && !isSelected(group.id),
                                    'cursor-pointer hover:bg-gray-50/80 rounded-2xl p-4 -mx-4 transition-all': is_public && calculation.status !== 'confirmed'
                                }"
                                @click="toggleItem(group)"
                                class="flex items-center gap-6"
                            >
                                <div v-if="is_public" class="shrink-0">
                                    <div 
                                        class="h-6 w-6 rounded-full border-2 flex items-center justify-center transition-all"
                                        :class="isSelected(group.id) ? 'brand-gradient border-transparent text-white shadow-sm' : 'border-gray-200 bg-white'"
                                    >
                                        <span v-if="isSelected(group.id)" class="text-[10px] font-bold">✓</span>
                                    </div>
                                </div>
                                <div class="grow">
                                    <div class="font-bold text-gray-900 text-lg font-heading">{{ group.name }}</div>
                                    <div class="text-sm text-gray-500 max-w-md mt-1 leading-relaxed">{{ group.description }}</div>
                                </div>
                                <div class="text-right shrink-0">
                                    <div class="font-extrabold text-gray-900 text-lg font-heading">
                                        {{ formatCurrency(group.price) }}
                                    </div>
                                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-1">
                                        {{ getPeriodLabel(group.payment_period) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Child Items -->
                            <div v-if="group.children.length > 0" class="ml-10 mt-4 space-y-3 pl-6 border-l-2 border-dashed border-gray-100">
                                <div 
                                    v-for="child in group.children" 
                                    :key="child.id"
                                    :class="{ 
                                        'opacity-50 grayscale': is_public && !isSelected(child.id),
                                        'cursor-pointer hover:bg-gray-50/50 rounded-xl p-3 -mx-3 transition-all': is_public && calculation.status !== 'confirmed'
                                    }"
                                    @click.stop="toggleItem(child)"
                                    class="flex items-center gap-4"
                                >
                                    <div v-if="is_public" class="shrink-0">
                                        <div 
                                            class="h-5 w-5 rounded-full border-2 flex items-center justify-center transition-all"
                                            :class="isSelected(child.id) ? 'bg-brand-primary-to border-transparent text-white' : 'border-gray-100 bg-white'"
                                        >
                                            <span v-if="isSelected(child.id)" class="text-[8px] font-bold">✓</span>
                                        </div>
                                    </div>
                                    <div class="grow">
                                        <div class="font-bold text-gray-700 text-base font-heading">{{ child.name }}</div>
                                        <div v-if="child.description" class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ child.description }}</div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="font-bold text-gray-900 text-base font-heading">
                                            {{ formatCurrency(child.price) }}
                                        </div>
                                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">
                                            {{ getPeriodLabel(child.payment_period) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end pt-10 border-t-2 border-gray-100 gap-8">
                        <div class="p-6 bg-gray-50 rounded-brand border border-gray-100">
                            <div class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-1">Předpokládaná realizace</div>
                            <div class="text-3xl font-extrabold text-gray-900 font-heading">
                                {{ is_public ? currentTotalDays : calculation.total_days }} pracovních dní
                            </div>
                        </div>
                        
                        <div class="w-full sm:w-80 space-y-4">
                            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <span class="text-sm font-bold text-gray-400 uppercase tracking-widest font-heading">Celkem</span>
                                <span class="text-4xl font-extrabold brand-text-gradient font-heading">
                                    {{ formatCurrency(is_public ? currentTotalPrice : calculation.total_price) }}
                                </span>
                            </div>
                            
                            <button 
                                v-if="is_public && calculation.status !== 'confirmed'"
                                @click.stop="confirmSelection"
                                class="w-full px-6 py-4 brand-gradient text-white rounded-full font-extrabold shadow-brand hover:shadow-brand-lg transition-all hover:-translate-y-1 font-heading text-lg"
                            >
                                ✅ Potvrdit výběr
                            </button>
                            <div v-else-if="is_public && calculation.status === 'confirmed'" class="w-full px-6 py-4 bg-green-500 text-white rounded-full font-extrabold text-center font-heading text-lg shadow-sm">
                                ✓ Nabídka byla potvrzena
                            </div>
                        </div>
                    </div>

                    <div v-if="calculation.note" class="mt-16 p-8 bg-indigo-50/30 rounded-brand border border-indigo-100 text-indigo-900">
                        <h4 class="font-bold mb-3 font-heading uppercase tracking-wide text-xs">Poznámka k realizaci:</h4>
                        <p class="italic leading-relaxed">"{{ calculation.note }}"</p>
                    </div>

                    <div v-if="$page.props.my_company" class="mt-20 text-center">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest leading-loose">
                            Děkujeme za projevenou důvěru. Tato nabídka je právně nezávazná.<br>
                            <template v-if="$page.props.my_company.name">{{ $page.props.my_company.name }}</template>
                            <template v-if="$page.props.my_company.ico"> | IČ: {{ $page.props.my_company.ico }}</template>
                            <template v-if="$page.props.my_company.dic"> | DIČ: {{ $page.props.my_company.dic }}</template>
                            <br v-if="$page.props.my_company.address || $page.props.my_company.email || $page.props.my_company.phone">
                            <template v-if="$page.props.my_company.address">{{ $page.props.my_company.address }}, {{ $page.props.my_company.city }}</template>
                            <template v-if="$page.props.my_company.email"> | {{ $page.props.my_company.email }}</template>
                            <template v-if="$page.props.my_company.phone"> | {{ $page.props.my_company.phone }}</template>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import Layout from '../../Components/Layout.vue'

const props = defineProps({
    calculation: Object,
    is_public: {
        type: Boolean,
        default: false
    }
})

// Interactive Selection State
const selectedIds = ref(
    props.calculation.items
        .filter(item => item.is_accepted)
        .map(item => item.id)
)

// Hierarchy Logic
const groupedItems = computed(() => {
    const parents = props.calculation.items.filter(item => !item.parent_id)
    return parents.map(p => ({
        ...p,
        children: props.calculation.items.filter(item => item.parent_id === p.id)
    }))
})

const toggleItem = (item) => {
    if (!props.is_public || props.calculation.status === 'confirmed') return
    
    // If it's a child and parent is not selected, don't allow selection
    if (item.parent_id) {
        if (!selectedIds.value.includes(item.parent_id)) return
    }

    const index = selectedIds.value.indexOf(item.id)
    if (index > -1) {
        // Deselecting
        selectedIds.value.splice(index, 1)
        
        // If it was a parent, deselect all its children
        const children = props.calculation.items.filter(i => i.parent_id === item.id)
        children.forEach(child => {
            const childIndex = selectedIds.value.indexOf(child.id)
            if (childIndex > -1) {
                selectedIds.value.splice(childIndex, 1)
            }
        })
    } else {
        // Selecting
        selectedIds.value.push(item.id)
    }
}

const isSelected = (id) => selectedIds.value.includes(id)

const currentTotalPrice = computed(() => {
    return props.calculation.items
        .filter(item => isSelected(item.id))
        .reduce((sum, item) => sum + parseFloat(item.price), 0)
})

const currentTotalDays = computed(() => {
    return props.calculation.items
        .filter(item => isSelected(item.id))
        .reduce((sum, item) => sum + parseInt(item.days), 0)
})

const confirmSelection = () => {
    if (!confirm('Opravdu chcete tento výběr potvrdit? Tato akce uzavře vaši kalkulaci.')) return
    
    router.post(`/c/${props.calculation.access_token}/confirm`, {
        accepted_items: selectedIds.value
    })
}

const formatCurrency = (value) => {
    return new Intl.NumberFormat('cs-CZ', { style: 'currency', currency: 'CZK', minimumFractionDigits: 0 }).format(value)
}

const getPeriodLabel = (period) => {
    const labels = {
        once: 'Jednorázově',
        monthly: '/ měsíc',
        yearly: '/ rok'
    }
    return labels[period] || period
}


const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('cs-CZ')
}

const print = () => {
    window.print()
}

const shareEmail = () => {
    const subject = `Cenová nabídka - ${props.calculation.customer_name}`
    const companyName = usePage().props.my_company?.name || 'MojiMili'
    const body = `Dobrý den,\n\nv příloze Vám zasíláme cenovou nabídku.\n\nCelková cena: ${formatCurrency(props.calculation.total_price)}\nRealizace: ${props.calculation.total_days} dní.\n\nS pozdravem,\n${companyName}`
    window.location.href = `mailto:${props.calculation.customer_email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`
}
</script>

<style scoped>
@keyframes pulse-slow {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
.animate-pulse-slow {
    animation: pulse-slow 3s infinite ease-in-out;
}

@media print {
    :deep(nav), :deep(footer), button, a, .bg-indigo-50\/50 {
        display: none !important;
    }
    #print-area {
        box-shadow: none !important;
        border: none !important;
    }
    .rounded-brand { border-radius: 0 !important; }
    .max-w-4xl {
        max-width: 100% !important;
    }
    .grayscale { filter: none !important; }
    .opacity-50 { opacity: 1 !important; }
}
</style>

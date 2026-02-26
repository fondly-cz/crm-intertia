<template>
    <div class="border-gray-50 last:border-0 pb-6" :class="{ 'ml-10 mt-4 border-l-2 border-dashed pl-6 border-b-0 pb-3': item.parent_id, 'border-b': !item.parent_id }">
        <div 
            :class="{ 
                'opacity-50 blur-[0.5px] grayscale bg-gray-50/50': isPublic && !isSelected,
                'cursor-pointer hover:bg-gray-50/80 rounded-2xl transition-all': isPublic && !isStatusConfirmed && (!item.is_required || !parentSelected),
                'p-4 -mx-4': !item.parent_id && isPublic && !isStatusConfirmed,
                'p-3 -mx-3': item.parent_id && isPublic && !isStatusConfirmed,
            }"
            @click.stop="handleClick"
            class="flex items-center gap-6"
        >
            <div v-if="isPublic" class="shrink-0 flex items-center gap-2">
                <div 
                    class="rounded-full border-2 flex items-center justify-center transition-all bg-white"
                    :class="[
                        isSelected ? 'brand-gradient border-transparent text-white shadow-sm' : 'border-gray-200',
                        item.parent_id ? 'h-5 w-5' : 'h-6 w-6',
                        item.is_required ? 'opacity-70 cursor-not-allowed' : ''
                    ]"
                >
                    <span v-if="isSelected" class="font-bold" :class="item.parent_id ? 'text-[8px]' : 'text-[10px]'">✓</span>
                </div>
                <span v-if="item.is_required" class="text-[8px] font-black uppercase text-red-500 tracking-widest bg-red-50 px-1.5 py-0.5 rounded border border-red-100">Povinné</span>
            </div>
            <div class="grow">
                <div class="font-bold text-gray-900 font-heading" :class="item.parent_id ? 'text-base text-gray-700' : 'text-lg'">{{ item.name }}</div>
                <div v-if="item.description" class="text-xs text-gray-500 max-w-xl mt-1 leading-relaxed">{{ item.description }}</div>
            </div>
            <div class="text-right shrink-0">
                <div class="font-extrabold text-gray-900 font-heading" :class="item.parent_id ? 'text-base' : 'text-lg'">
                    {{ formatCurrency(item.price) }}
                </div>
                <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-1">
                    {{ getPeriodLabel(item.payment_period) }}
                </div>
            </div>
        </div>

        <!-- Children -->
        <template v-if="children.length > 0">
            <CalculationItemDisplay 
                v-for="child in children" 
                :key="child.id"
                :item="child"
                :all-items="allItems"
                :is-public="isPublic"
                :is-status-confirmed="isStatusConfirmed"
                :selected-ids="selectedIds"
                @toggle="$emit('toggle', $event)"
            />
        </template>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    item: Object,
    allItems: Array,
    isPublic: Boolean,
    isStatusConfirmed: Boolean,
    selectedIds: Array
})

const emit = defineEmits(['toggle'])

const children = computed(() => props.allItems.filter(i => i.parent_id === props.item.id))

const isSelected = computed(() => props.selectedIds.includes(props.item.id))

const parentSelected = computed(() => {
    if (!props.item.parent_id) return true
    return props.selectedIds.includes(props.item.parent_id)
})

const handleClick = () => {
    if (props.isPublic && !props.isStatusConfirmed) {
        // Cannot uniquely toggle required subitems if their parent is selected (they are forced selected)
        if (props.item.is_required && parentSelected.value) return
        emit('toggle', props.item)
    }
}

const formatCurrency = (value) => new Intl.NumberFormat('cs-CZ', { style: 'currency', currency: 'CZK', minimumFractionDigits: 0 }).format(value)

const getPeriodLabel = (period) => {
    const labels = {
        once: 'Jednorázově',
        monthly: '/ měsíc',
        yearly: '/ rok'
    }
    return labels[period] || period
}
</script>

<template>
    <div :class="{ 'ml-10 mt-4 border-l-2 border-dashed border-brand-primary-from pl-6 pb-3': item.parent_id, 'mb-10': !item.parent_id }">
        <div 
            :class="[
                isPublic && !isSelected ? 'opacity-50 blur-[0.1px] grayscale' : '',
                isSelected 
                    ? 'bg-white border-2 border-brand-primary-from shadow-sm shadow-brand/10' 
                    : 'bg-indigo-50/50 border border-indigo-100',
                isPublic && !isStatusConfirmed && (!item.is_required || !parentSelected) ? 'cursor-pointer hover:border-brand-primary-from/50 group/item' : '',
                'p-5 rounded-2xl flex flex-col gap-3 transition-all duration-200'
            ]"
            @click.stop="handleClick"
        >
            <!-- Row 1: Name -->
            <div class="font-bold text-gray-900 font-heading leading-tight" :class="item.parent_id ? 'text-base text-gray-700' : 'text-lg'">
                {{ item.name }}
            </div>

            <!-- Row 2: Checkmark + Price -->
            <div class="flex items-center justify-between gap-4">
                <div v-if="isPublic" class="flex items-center gap-3">
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
                
                <div class="text-right shrink-0 ml-auto">
                    <div class="font-extrabold text-gray-900 font-heading" :class="item.parent_id ? 'text-base' : 'text-lg'">
                        {{ formatCurrency(showVat ? item.price * 1.21 : item.price) }}
                    </div>
                    <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mt-0.5">
                        {{ getPeriodLabel(item.payment_period) }} {{ showVat ? 's DPH' : '' }}
                    </div>
                </div>
            </div>

            <!-- Row 3: Description -->
            <div v-if="item.description" class="text-xs text-gray-500 max-w-xl leading-relaxed pt-1 border-t border-indigo-100/30">
                {{ item.description }}
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
                :show-vat="showVat"
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
    selectedIds: Array,
    showVat: Boolean
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

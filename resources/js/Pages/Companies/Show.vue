<template>
    <Layout>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{ company.name }}
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <span 
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                :class="{
                                    'bg-green-100 text-green-800': company.status === 'active',
                                    'bg-red-100 text-red-800': company.status === 'inactive',
                                    'bg-yellow-100 text-yellow-800': company.status === 'prospect'
                                }"
                            >
                                {{ company.status }}
                            </span>
                        </div>
                        <div v-if="company.industry" class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ company.industry }}
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <Link
                        :href="`/companies/${company.id}/edit`"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Edit Company
                    </Link>
                    <Link
                        href="/companies"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Back to Companies
                    </Link>
                </div>
            </div>

            <div class="mt-8">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Company Information</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Details and contact information.</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <!-- Contact Information -->
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Contact Information</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="space-y-2">
                                        <div v-if="company.email" class="flex items-center">
                                            <svg class="flex-shrink-0 mr-2 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                            <a :href="`mailto:${company.email}`" class="text-indigo-600 hover:text-indigo-900">
                                                {{ company.email }}
                                            </a>
                                        </div>
                                        <div v-if="company.phone" class="flex items-center">
                                            <svg class="flex-shrink-0 mr-2 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                            </svg>
                                            <a :href="`tel:${company.phone}`" class="text-indigo-600 hover:text-indigo-900">
                                                {{ company.phone }}
                                            </a>
                                        </div>
                                        <div v-if="company.website" class="flex items-center">
                                            <svg class="flex-shrink-0 mr-2 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd" />
                                            </svg>
                                            <a :href="company.website" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                                {{ company.website }}
                                            </a>
                                        </div>
                                        <div v-if="!company.email && !company.phone && !company.website" class="text-gray-500 italic">
                                            No contact information available
                                        </div>
                                    </div>
                                </dd>
                            </div>

                            <!-- Address -->
                            <div v-if="hasAddress" class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div v-if="company.address" class="mb-2">{{ company.address }}</div>
                                    <div class="space-x-2">
                                        <span v-if="company.city">{{ company.city }}</span>
                                        <span v-if="company.city && company.state">,</span>
                                        <span v-if="company.state">{{ company.state }}</span>
                                        <span v-if="company.postal_code">{{ company.postal_code }}</span>
                                    </div>
                                    <div v-if="company.country" class="mt-1">{{ company.country }}</div>
                                </dd>
                            </div>

                            <!-- Company Details -->
                            <div v-if="company.employee_count || company.annual_revenue" class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Company Details</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div class="space-y-2">
                                        <div v-if="company.employee_count">
                                            <span class="font-medium">Employees:</span> {{ company.employee_count }}
                                        </div>
                                        <div v-if="company.annual_revenue">
                                            <span class="font-medium">Annual Revenue:</span> ${{ formatCurrency(company.annual_revenue) }}
                                        </div>
                                    </div>
                                </dd>
                            </div>

                            <!-- Notes -->
                            <div v-if="company.notes" class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 whitespace-pre-wrap">
                                    {{ company.notes }}
                                </dd>
                            </div>

                            <!-- Timestamps -->
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ formatDate(company.created_at) }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ formatDate(company.updated_at) }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import Layout from '../../Components/Layout.vue'

const props = defineProps({
    company: Object,
})

const hasAddress = computed(() => {
    return props.company.address || props.company.city || props.company.state || 
           props.company.postal_code || props.company.country
})

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US').format(amount)
}

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}
</script>
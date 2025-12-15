<template>
    <div class="min-h-screen bg-gray-50 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div class="absolute inset-0 bg-gradient-to-r from-cyan-400 to-light-blue-500 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl"></div>
            <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
                <div class="max-w-md mx-auto">
                    <div>
                        <img src="/img/logo.svg" class="h-7 sm:h-8" alt="CRM Logo" />
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                            <h1 class="text-2xl font-bold text-gray-900 mb-6">Welcome to CRM</h1>
                            <p>Your Inertia.js CRM application is ready!</p>
                            <ul class="list-disc space-y-2">
                                <li class="flex items-start">
                                    <span class="h-6 flex items-center sm:h-7">
                                        <svg class="flex-shrink-0 h-5 w-5 text-cyan-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <p class="ml-2">Laravel {{ laravelVersion }} backend</p>
                                </li>
                                <li class="flex items-start">
                                    <span class="h-6 flex items-center sm:h-7">
                                        <svg class="flex-shrink-0 h-5 w-5 text-cyan-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <p class="ml-2">Vue.js 3 with Composition API</p>
                                </li>
                                <li class="flex items-start">
                                    <span class="h-6 flex items-center sm:h-7">
                                        <svg class="flex-shrink-0 h-5 w-5 text-cyan-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <p class="ml-2">Inertia.js for seamless SPA experience</p>
                                </li>
                                <li class="flex items-start">
                                    <span class="h-6 flex items-center sm:h-7">
                                        <svg class="flex-shrink-0 h-5 w-5 text-cyan-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <p class="ml-2">Tailwind CSS for styling</p>
                                </li>
                                <li class="flex items-start">
                                    <span class="h-6 flex items-center sm:h-7">
                                        <svg class="flex-shrink-0 h-5 w-5 text-cyan-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <p class="ml-2">Vite for fast development</p>
                                </li>
                                <li class="flex items-start">
                                    <span class="h-6 flex items-center sm:h-7">
                                        <svg class="flex-shrink-0 h-5 w-5 text-cyan-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <p class="ml-2">pnpm for efficient package management</p>
                                </li>
                            </ul>
                        </div>
                        <div class="pt-6 text-base leading-6 font-bold sm:text-lg sm:leading-7">
                            <p class="text-gray-600">Ready to start building your CRM?</p>
                            <div class="space-y-2">
                                <p>
                                    <Link href="/companies" class="text-cyan-600 hover:text-cyan-700"> Manage Companies &rarr; </Link>
                                </p>
                                <p>
                                    <a href="/dashboard" class="text-cyan-600 hover:text-cyan-700"> View Dashboard &rarr; </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    laravelVersion: String,
})
</script>
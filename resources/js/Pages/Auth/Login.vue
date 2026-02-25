<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <div v-if="status" class="mb-6 p-4 bg-green-50 border border-green-100 rounded-2xl text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <div class="mb-8">
            <h1 class="text-2xl font-extrabold text-gray-900 font-heading">Vítejte zpět</h1>
            <p class="text-gray-500 mt-1">Přihlaste se do svého systému MojiMili</p>
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="E-mailová adresa" class="font-bold text-gray-700 ml-1 mb-1" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-6">
                <InputLabel for="password" value="Heslo" class="font-bold text-gray-700 ml-1 mb-1" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-6 block">
                <label class="flex items-center cursor-pointer group">
                    <Checkbox name="remember" v-model:checked="form.remember" class="rounded-lg border-2 border-gray-200 text-brand-primary-from focus:ring-brand-primary-from/20" />
                    <span class="ms-3 text-sm text-gray-600 font-medium group-hover:text-gray-900 transition-colors"
                        >Zapamatovat si mě</span
                    >
                </label>
            </div>

            <div class="mt-10 flex items-center justify-between">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-gray-400 font-medium hover:text-brand-primary-from transition-colors"
                >
                    Zapomenuté heslo?
                </Link>

                <PrimaryButton
                    class="px-10"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Přihlásit se
                </PrimaryButton>
            </div>

            <div class="mt-10 relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-100"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-white text-gray-400 font-medium">Nebo pokračujte přes</span>
                </div>
            </div>

            <div class="mt-8">
                <a
                    :href="route('social.redirect', { provider: 'google' })"
                    class="w-full flex items-center justify-center gap-3 px-6 py-4 border-2 border-gray-100 rounded-full font-bold text-gray-700 hover:bg-gray-50 transition-all font-heading shadow-sm"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Přihlásit se přes Google
                </a>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    phone: user.phone || '',
    company: user.company || '',
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-2xl font-black text-gray-900 font-heading">
                Osobní údaje
            </h2>

            <p class="mt-1 text-sm text-gray-500 font-medium">
                Aktualizujte své jméno, profilové informace a kontaktní údaje.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="name" value="Jméno" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="phone" value="Telefon" />

                <TextInput
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    autocomplete="tel"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div>
                <InputLabel for="company" value="Firma" />

                <TextInput
                    id="company"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.company"
                    autocomplete="organization"
                />

                <InputError class="mt-2" :message="form.errors.company" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Váš e-mail zatím není ověřený.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-brand-primary-from underline hover:text-brand-primary-to focus:outline-none"
                    >
                        Klikněte zde pro opětovné odeslání e-mailu s ověřením.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-bold text-green-600"
                >
                    Nový odkaz pro ověření byl odeslán na vaši e-mailovou adresu.
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <PrimaryButton :disabled="form.processing">Uložit změny</PrimaryButton>

                <Transition
                    enter-active-class="ease-out duration-300 transition-all"
                    enter-from-class="opacity-0 translate-x-2"
                    enter-to-class="opacity-100 translate-x-0"
                    leave-active-class="ease-in duration-200 transition-all"
                    leave-from-class="opacity-100 translate-x-0"
                    leave-to-class="opacity-0 translate-x-2"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm font-bold text-green-500 flex items-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        Uloženo
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>

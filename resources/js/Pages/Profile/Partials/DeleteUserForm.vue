<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-2xl font-black text-red-600 font-heading">
                Smazat účet
            </h2>

            <p class="mt-1 text-sm text-gray-500 font-medium">
                Při smazání účtu dojde k trvalému odstranění všech prostředků a dat spojených s tímto účtem.
                Doporučujeme si stáhnout všechny data nebo informace, které si přejete uchovat.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">Smazat účet</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-2xl font-black text-gray-900 font-heading tracking-tight"
                >
                    Opravdu chcete smazat svůj účet?
                </h2>

                <p class="mt-4 text-sm text-gray-500 font-medium leading-relaxed">
                    Při smazání účtu dojde k trvalému odstranění všech prostředků a dat spojených s tímto účtem.
                    Prosím zadejte své heslo pro potvrzení, že chcete trvale smazat svůj účet.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Heslo"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Heslo"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-8 flex justify-end gap-3 bg-gray-50/50 -mx-6 -mb-6 p-6">
                    <SecondaryButton @click="closeModal">
                        Zrušit
                    </SecondaryButton>

                    <DangerButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Smazat účet
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

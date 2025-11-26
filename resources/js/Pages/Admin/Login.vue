<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('admin.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Admin Log in" />

    <div class="flex min-h-screen items-center justify-center bg-gray-100 p-6 dark:bg-gray-900">
        <div class="w-full max-w-md overflow-hidden rounded-lg bg-white p-8 shadow-xl dark:bg-gray-800">

            <div class="mb-8 flex items-center justify-center">
                <img src="/images/LOGO.png" alt="Kubikal Logo" class="h-16 w-auto mr-3">
                <h1 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Kubikal Admin</h1>
            </div>

            <h2 class="mb-6 text-center text-lg font-medium text-gray-800 dark:text-gray-100">
                Selamat Datang Kembali
            </h2>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                {{ status }}
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <InputLabel for="email" value="Email" class="dark:text-gray-300" />
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </span>
                        <TextInput id="email" type="email"
                            class="block w-full rounded-md border-gray-300 bg-gray-200 pl-10 pr-4 py-2 text-gray-700 placeholder-gray-500 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:placeholder-gray-400 dark:focus:border-indigo-600 dark:focus:bg-gray-900 dark:focus:ring-indigo-600"
                            v-model="form.email" required autofocus autocomplete="email"
                            placeholder="Masukkan username Anda" />
                    </div>
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel for="password" value="Password" class="dark:text-gray-300" />
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </span>
                        <TextInput id="password" type="password"
                            class="block w-full rounded-md border-gray-300 bg-gray-200 pl-10 pr-4 py-2 text-gray-700 placeholder-gray-500 focus:border-indigo-500 focus:bg-white focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:placeholder-gray-400 dark:focus:border-indigo-600 dark:focus:bg-gray-900 dark:focus:ring-indigo-600"
                            v-model="form.password" required autocomplete="current-password"
                            placeholder="Masukkan password Anda" />
                    </div>
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                    <PrimaryButton
                        class="w-full justify-center rounded-md bg-gray-700 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-700 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus-visible:outline-gray-600"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Masuk
                    </PrimaryButton>
                </div>
            </form>

        </div>
    </div>
</template>

<style scoped>
input:focus {
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5);
}
</style>
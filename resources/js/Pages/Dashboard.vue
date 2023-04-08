<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="text-3xl mb-5 font-semibold text-gray-900 ">Hi, {{ $page.props.auth.user.name }}!</div>
                <div class=" sm:w-96 p-6 bg-gradient-to-r from-blue-800 to-cyan-500 text-white rounded-lg mb-5">
                    <div class="text-md">Balance</div>
                    <div class="text-2xl">Php {{ wallet.balance }} </div>
                </div>
                <div class="flex flex-row space-x-4">
                    <button class="px-6 py-2 rounded-lg text-white bg-gray-800" @click="showSendModal">Send</button>
                    <button class="px-6 py-2 rounded-lg text-white bg-gray-800">Request</button>
                </div>
                
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Recent Activities Component -->
                <div class="text-lg mb-5 font-semibold text-gray-900 "> Recent activity</div>
                <div v-for="transaction in transactions">
                    <template v-if="transaction.from == $page.props.auth.user.id">
                        <span class=" text-red-500 font-bold">-{{ transaction.amount }} PHP</span> <span class=" text-gray-900">Sent <span class=" text-gray-500">{{ transaction.diffForHumans }}</span></span> 
                    </template>

                    <template v-else-if="transaction.to == $page.props.auth.user.id">
                        <span class=" text-green-500 font-bold">+{{ transaction.amount }} PHP</span> <span class=" text-gray-900">Received <span class=" text-gray-500">{{ transaction.diffForHumans }}</span></span> 
                    </template>
                </div>
                
            </div>
        </div>
        
        <Modal :show="showingSendmodal" @close="closeModal">
            <div class="p-6" id="sendCreditModal">
                <h2 class="text-lg font-medium text-gray-900">
                    Send payment to
                </h2>

                <div class="mt-6">
                    <div class="mb-4">
                        <InputLabel for="email" value="Email" class="sr-only" />

                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="text"
                            class="mt-1 block w-3/4"
                            placeholder="Email"
                        />
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>
                    

                    <TextInput
                        id="amount"
                        v-model="form.amount"
                        type="number"
                        class="mt-1 block w-3/4"
                        placeholder="Amount"
                    />
                    <InputError :message="form.errors.amount" class="mt-2" />

                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                    <PrimaryButton id="send" class="ml-3" @click="send">Send</PrimaryButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import InputLabel from '@/Components/InputLabel.vue';
    import Modal from '@/Components/Modal.vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    import { useForm } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    defineProps({
        wallet: Object,
        transactions: Object
    })

    const showingSendmodal = ref(false)

    const form = useForm({
        email: '',
        amount: ''
    });

    const showSendModal = () => {
        showingSendmodal.value = true
    };


    const closeModal = () => {
        showingSendmodal.value = false
        form.clearErrors()
        form.reset()
    };

    const send = () => {
        form.post(route('send'), {
            preserveScroll: true,
            onSuccess: () => closeModal()
        })
    }

</script>
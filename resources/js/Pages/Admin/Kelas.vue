<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import NumberInput from "@/Components/NumberInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Combobox from "@/Components/Combobox.vue";
import Multiselect from "@vueform/multiselect";

defineProps({
    kelas: {
        type: Object,
    },
});

const form = useForm({
    nama_kelas: "",
});

const dialogCreateKelas = ref(false);
const dialogEditKelas = ref(false);
const itemKelas = ref(null);
const dialogDeleteKelas = ref(false);

const createKelas = () => {
    if (dialogCreateKelas.value) {
        form.post(route("admin.kelas.store"), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => nama_kelasInput.value.focus(),
            onFinish: () => form.reset(),
        });
    } else {
        dialogCreateKelas.value = true;
    }
};

const editKelas = (item = null) => {
    if (dialogEditKelas.value) {
        form.patch(route("admin.kelas.update", { id: item }), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => nama_kelasInput.value.focus(),
            onFinish: () => form.reset(),
        });
    } else {
        dialogEditKelas.value = true;
        itemKelas.value = item;
        let findKelas = usePage().props.kelas.find(
            (item) => item.id == itemKelas.value
        );

        form.nama_kelas = findKelas.nama_kelas;
    }
};

const deleteKelas = (item = null) => {
    if (dialogDeleteKelas.value) {
        form.delete(route("admin.kelas.destroy", { id: item }), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => nama_kelasInput.value.focus(),
            onFinish: () => form.reset(),
        });
    } else {
        dialogDeleteKelas.value = true;
        itemKelas.value = item;
    }
};

const closeModal = () => {
    dialogCreateKelas.value = false;
    dialogEditKelas.value = false;
    dialogDeleteKelas.value = false;
    itemKelas.value = null;
    form.reset();
};
</script>

<style src="@vueform/multiselect/themes/tailwind.css"></style>

<template>

    <Head title="Setting Kelas" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div class="shadow-md sm:shadow-lg p-4 sm:p-8 bg-white">
                    <div
                        class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Kelas
                            </h2>
                        </header>
                        <PrimaryButton @click="createKelas">Create</PrimaryButton>
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Kelas</th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="kelas in kelas" :key="kelas.id">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ kelas.nama_kelas }}
                                    </th>
                                    <td class="px-6 py-4 flex gap-2">
                                        <button @click="editKelas(kelas.id)"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                        <button @click="deleteKelas(kelas.id)" class="text-red-600 hover:text-red-900">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <Modal :show="dialogCreateKelas || dialogEditKelas || dialogDeleteKelas
                " @close="closeModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ dialogCreateKelas ? "Create" : "Edit" }}
                    </h2>

                    <div class="mt-6 grid grid-cols-1 gap-4" v-if="!dialogDeleteKelas">
                        <div>
                            <InputLabel for="nama_kelas" value="Nama Kelas" />
                            <TextInput id="nama_kelas" ref="nameInput" v-model="form.nama_kelas" type="text"
                                class="mt-1 block w-full" placeholder="Reguler / Karyawan" />
                            <InputError :message="form.errors.nama_kelas" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <PrimaryButton @click="createKelas" v-if="dialogCreateKelas">Create</PrimaryButton>
                            <PrimaryButton @click="editKelas(itemKelas)" v-if="dialogEditKelas">Edit</PrimaryButton>

                            <SecondaryButton @click="closeModal" class="ml-2">
                                Cancel
                            </SecondaryButton>
                        </div>
                    </div>

                    <div v-else>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Are you sure you want to delete this kelas?
                        </h2>

                        <div class="mt-6">
                            <PrimaryButton @click="deleteKelas(itemKelas)" v-if="dialogDeleteKelas">Delete
                            </PrimaryButton>

                            <SecondaryButton @click="closeModal" class="ml-2">
                                Cancel
                            </SecondaryButton>
                        </div>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>

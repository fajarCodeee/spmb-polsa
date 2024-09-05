<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SearchForm from "@/Components/SearchForm.vue";
import FilterDropdown from "@/Components/FilterDropdown.vue";
import Modal from "@/Components/Modal.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import {
    Chart,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";
import { computed, handleError, onMounted, ref } from "vue";

Chart.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

const props = defineProps({
    peserta: {
        type: Array
    },
    wave: {
        type: Object
    }
});

const form = useForm({
    term: ''
})

const searchFilter = ref('');

const filterItems = computed(() => {
    if(searchFilter.value !== '') {
        return props.peserta.filter(peserta => peserta.name.includes(searchFilter.value) || peserta.get_form.national_id.includes(searchFilter.value));
    }

    return props.peserta;
});

const handleSearch = (search) => {
    searchFilter.value = search;
};

</script>

<template>

    <Head title="Daftar Peserta" />
    <AuthenticatedLayout>
        <div>
            <div class="max-w-7xl mx-auto">
                <div class="shadow-md sm:shadow-lg p-4 sm:p-8 bg-white">
                    <div
                        class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between gap-3 pb-4">
                        <header class="flex flex-row items-center">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                Daftar Peserta
                            </h2>
                            <!-- search form -->
                            <SearchForm @search="handleSearch"/>
                            <!-- filter dropdown -->
                        </header>

                        <div class="flex flex-columm justify-between">
                            <FilterDropdown :items="peserta"/>
                        </div>

                    </div>

                    <Modal :show="dialogExportPDF" @close="closeModal">
                        <div class="p-6">
                            <select v-model="selectedYear">
                                <option v-for="wave in wave" :value="wave">{{ wave.tahun_akademik }}</option>
                            </select>
                            <button @click="exportData">Ekspor Data</button>
                        </div>
                    </Modal>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 capitalize">Nama lengkap</th>
                                    <th scope="col" class="px-6 py-3">
                                        NIK
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tahun Akademik
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Alamat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Prodi Pilihan
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Kelas
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nomer WhatsApp
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama Ibu
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <!-- {{ }} -->
                            <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                    v-for="peserta in filterItems" :key="peserta.id">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ peserta.name }}
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ peserta.get_form.national_id ?? '(Belum Dilengkapi)' }}
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{ peserta.get_form.wave.tahun_akademik }}
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ peserta.get_form.address ?? '(Belum Dilengkapi)' }}
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ peserta.get_form.prodi.nama_prodi ?? '(Belum Dilengkapi)' }}
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ peserta.get_form.kelas.nama_kelas ?? '(Belum Dilengkapi)' }}
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ peserta.get_form.phone_number ?? '(Belum Dilengkapi)' }}
                                    </th>

                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                                        {{ peserta.get_form.mother_name ?? '(Belum Dilengkapi)' }}
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ peserta.email }}
                                    </th>

                                    <td class="px-6 py-4 flex gap-2">
                                        <button @click="editProdi(peserta.id)"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                        <button @click="deleteProdi(peserta.id)"
                                            class="text-red-600 hover:text-red-900">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

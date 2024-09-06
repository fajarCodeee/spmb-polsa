<script setup>
import { computed, ref } from 'vue';

const emit = defineEmits(['filter']);

const show = ref(false);

const props = defineProps({
    items: {
        type: Array,
        required: true
    }
});

const tahun_akademik = computed(() => {
    return [...new Set(props.items.map(peserta => peserta.get_form.wave.tahun_akademik))];
});

const prodi = computed(() => {
    return [...new Set(props.items.map(peserta => peserta.get_form.prodi.nama_prodi))];
});

const kelas = computed(() => {
    return [...new Set(props.items.map(peserta => peserta.get_form.kelas.nama_kelas))];
});

const wave = computed(() => {
    return [...new Set(props.items.map(peserta => peserta.get_form.wave.gelombang))];
});

const filter = (e) => {
    emit('filter', {
        tahunAkademik: selectedTahunAkademik.value,
        prodi: selectedProdi.value,
        kelas: selectedKelas.value,
        wave: selectedWave.value,
    });

};

const selectedTahunAkademik = ref([]);
const selectedProdi = ref([]);
const selectedKelas = ref([]);
const selectedWave = ref([]);

</script>

<template>
    <div class="relative flex items-center w-full px-4">
        <button @click="show = !show"
            class="w-full flex items-center justify-center py-2 px-4 text-sm font-semibold text-gray-900 border-2 rounded-md hover:bg-gray-100">
            <i class="fas fa-filter me-1"></i>Filter
        </button>

        <div v-if="show" class="absolute top-12 right-0 z-10 w-96 p-3 bg-white rounded-lg shadow-md">
            <div class="grid grid-cols-2 gap-2">
                <div class="mb-3">
                    <h6 class="mb-3 text-sm font-semibold text-gray-900">Tahun Akademik</h6>
                    <ul class="space-y-2 text-sm">
                        <li v-for="(tahun_akademik, index) in tahun_akademik" :key="index">
                            <input type="checkbox" :id="`filter_options_${index}`" @change="filter"
                                v-model="selectedTahunAkademik" :value="tahun_akademik"
                                class="w-4 h-4 bg-gray-50 rounded-sm" />
                            <label :for="`filter_options_${index}`" class="ml-2 text-sm font-medium text-gray-900">{{
                                tahun_akademik }}</label>
                        </li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="mb-3 text-sm font-semibold text-gray-900">Gelombang</h6>
                    <ul class="space-y-2 text-sm">
                        <li v-for="(wave, index) in wave" :key="index">
                            <input type="checkbox" :id="`wave_filter_options_${index}`" @change="filter"
                                v-model="selectedWave" :value="wave" class="w-4 h-4 bg-gray-50 rounded-sm" />
                            <label :for="`wave_filter_options_${index}`"
                                class="ml-2 text-sm font-medium text-gray-900">{{
                                    wave }}</label>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">

                <div class="mb-3">
                    <h6 class="mb-3 text-sm font-semibold text-gray-900">Program Studi</h6>
                    <ul class="space-y-2 text-sm">
                        <li v-for="(prodi, index) in prodi" :key="index">
                            <input type="checkbox" :id="`prodi_filter_options_${index}`" @change="filter"
                                v-model="selectedProdi" :value="prodi" class="w-4 h-4 bg-gray-50 rounded-sm" />
                            <label :for="`prodi_filter_options_${index}`"
                                class="ml-2 text-sm font-medium text-gray-900">{{
                                    prodi }}</label>
                        </li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="mb-3 text-sm font-semibold text-gray-900">Kelas</h6>
                    <ul class="space-y-2 text-sm">
                        <li v-for="(kelas, index) in kelas" :key="index">
                            <input type="checkbox" :id="`kelas_filter_options_${index}`" @change="filter"
                                v-model="selectedKelas" :value="kelas" class="w-4 h-4 bg-gray-50 rounded-sm" />
                            <label :for="`kelas_filter_options_${index}`"
                                class="ml-2 text-sm font-medium text-gray-900">{{
                                    kelas }}</label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

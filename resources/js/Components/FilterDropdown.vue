<script setup>
import { computed, ref } from 'vue';


const show = ref(false);

const props = defineProps({
    items: {
        type: Array,
        required: true
    }
});

const tahun_akademik = computed(() => {
    return [...new Set(props.items.map(peserta => peserta.get_form.wave.tahun_akademik))]
});

</script>

<template>
    <div class="relative flex items-center w-full px-4">
        <button @click="show = !show"
            class="w-full flex items-center justify-center py-2 px-4 text-sm font-semibold text-gray-900 border-2 rounded-md hover:bg-gray-100">
            Filter
        </button>
        <div v-if="show" class="absolute top-12 right-0 z-10 w-48 p-3 bg-white rounded-lg shadow-md">
            <h6 class="mb-3 text-sm font-semibold text-gray-900">Tahun Akademik</h6>
            <!-- <hr class="mb-3"> -->
            <ul class="space-y-2 text-sm">
                <li v-for="(tahun_akademik, index) in tahun_akademik">
                    <input type="checkbox" :id="`filter_options_${index}`" :value="tahun_akademik" class="w-4 h-4 bg-gray-50 rounded-sm"/>
                    <label :for="`filter_options_${index}`" class="ml-2 text-sm font-medium text-gray-900">{{ tahun_akademik }}</label>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>

const emit = defineEmits(['search']);

const search = (e) => {
    // console.log(e.target.value);
    emit('search', e.target.value);

};
</script>

<template>
    <form class="px-4 flex items-center">
        <label for="search" class="sr-only">Cari berdasarkan Nama, NIK</label>
        <div class="relative w-full">
            <input type="text" placeholder="Search by Nama, NIK" @input="search"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-md">
        </div>
    </form>
</template>

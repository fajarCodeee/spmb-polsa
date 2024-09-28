<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-xs font-bold text-red-600 dark:text-red-400 uppercase">
            {{ message }}
        </p>
    </div>
</template>

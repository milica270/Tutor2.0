<template>
    <div class="mb-3 mt-3">
        <label for="name" class="form-label fw-bold text-secondary">{{ name }}</label>
        <input :class="{'border-danger' : message}" class="form-control" :type="type" id="name" placeholder="" name="name" v-model="model">
        <small v-if="message">{{ message }}</small>
    </div>
</template>

<script setup>
    const model = defineModel({
        type: null,
        required: true
    });
    defineProps({
        name: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: 'text',
        },
        message: {
            type: String,
        }
    });
</script>
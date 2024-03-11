<template>
    <div class="mb-3">
        <label v-if="label.length > 0">{{ label }}:</label>
        <input
            class="form-control"
            v-bind:class="{ 'is-invalid': error != null }"
            type="text"
            :value="modelValue"
            @input="updateInput"
            :placeholder="placeholder">

        <div v-if="error != null" class="invalid-feedback">{{ error }}</div>
    </div>
</template>

<script>
export default {
    props: {
        error: {
            type: String | null,
            default: null,
        },
        label: {
            type: String,
            default: "",
        },
        placeholder: {
            type: String,
            default: "",
        },
        modelValue: {
            type: [String, Number],
            default: "",
        },
    },

    methods: {
        updateInput(event) {
            this.$emit("update:modelValue", event.target.value);
        }
    }
};
</script>


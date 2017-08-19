<template>
    <div class="form-group" :class="{ 'has-error': error }">
        <template v-if="inputType === 'checkbox'">
            <div class="checkbox">
                <label><input type="checkbox" :value="value" :disabled="disabled"> {{ text }}</label>
            </div>
        </template>

        <template v-else-if="inputType === 'select'">
            <label :for="fieldName" class="control-label">{{ text }}</label>
            <select class="form-control" :id="fieldName" :value="value" @input="updateValue($event.target.value)" :disabled="disabled">
                <option value="">-- Select --</option>
                <option v-for="option in options" :value="option.value">{{ option.text }}</option>
            </select>
        </template>

        <template v-else-if="inputType === 'textarea'">
            <label :for="fieldName" class="control-label">{{ text }}</label>
            <textarea class="form-control" :rows="textareaRows" :id="fieldName" :value="value" @input="updateValue($event.target.value)" :disabled="disabled"></textarea>
        </template>

        <template v-else>
            <label :for="fieldName" class="control-label">{{ text }}</label>
            <input
                    class="form-control"
                    :value="value"
                    :id="fieldName"
                    :autofocus="autofocus"
                    type="email"
                    :disabled="disabled"
                    v-if="inputType === 'email'"
                    @input="updateValue($event.target.value)"
            >
            <input
                    class="form-control"
                    :value="value"
                    :id="fieldName"
                    :autofocus="autofocus"
                    type="password"
                    :disabled="disabled"
                    v-if="inputType === 'password'"
                    @input="updateValue($event.target.value)"
            >
            <input
                    class="form-control"
                    :value="value"
                    :id="fieldName"
                    :autofocus="autofocus"
                    type="number"
                    :disabled="disabled"
                    v-if="inputType === 'number'"
                    @input="updateValue($event.target.value)"
            >
            <input
                    class="form-control"
                    :value="value"
                    :id="fieldName"
                    :autofocus="autofocus"
                    type="text"
                    :disabled="disabled"
                    v-if="inputType === 'text'"
                    @input="updateValue($event.target.value)"
                    :placeholder="placeholder"
            >
        </template>

        <div class="help-block input-error" v-if="error">{{ error }}</div>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                required: true
            },
            fieldName: {
                required: true
            },
            error: {
                required: true
            },
            text: {
                required: true
            },
            inputType: {
                required: true
            },
            autofocus: {
                type: Boolean,
                default: false
            },
            options: {
                type: Array
            },
            disabled: {
                type: Boolean,
                default: false
            },
            textareaRows: {
                type: Number,
                default: 3
            },
            placeholder: {
                required: false
            }
        },

        methods: {
            updateValue(value) {
                this.$emit('input', value)
            }
        }
    }
</script>

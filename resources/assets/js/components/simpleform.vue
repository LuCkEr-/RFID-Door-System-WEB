<template>
    <div style="position:relative" :class="{'has-error': error, 'has-success': success}">
        <label for="Input" class="control-label">{{ label }}</label>
        <div class="form-group input-group">

            <input if="Input" class="form-control" type="text" :placeholder="placeholder" style="height: 42px" v-model="input.text"
                @keydown.enter = "updateDB"
                @blur = "updateDB"
            />

            <span class="input-group-btn">
                <button class="btn btn-primary" style="height: 42px" type="button" @click="updateDB">Uuenda
                </button>
            </span>
        </div>
    </div>
</template>


<script>
    export default {

        props: {
            selectedid: {
                type: Number,
                required: true
            },
            selectedvalue: {
                type: String,
                required: false
            },
            label: {
                type: String,
                required: true
            },
            placeholder: {
                type: String,
                required: false
            },
            submiturl: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                input: {},
                error: false,
                success: false
            };
        },

        created() {
            if (this.selectedvalue || this.selectedid) {
                this.input.id = this.selectedid;
                this.input.text = this.selectedvalue;
            } else
                console.log('Make sure to get bot selectedid and selectedvalue');
        },

        methods: {
            updateDB() {
                axios.post(this.submiturl, {
                    id: this.input.id,
                    text: this.input.text
                })
                .then (response => {
                    this.onSuccess();
                })
                .catch(error => {
                    if (error.response) {
                        this.onFail();
                    }
                });
            },

            onSuccess() {
                this.error = false;
                this.success = true;
                setTimeout(this.onReset, 2000);
            },

            onFail() {
                this.success = false;
                this.error = true;
            },

            onReset() {
                this.success = false;
            },
        }
    }
</script>

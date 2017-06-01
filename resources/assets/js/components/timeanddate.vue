<template>
    <div>

        <div class="form-group">
            <el-date-picker
                v-if="!weekly"
                v-model="DateTime"
                type="datetimerange"
                placeholder="Select time range">
            </el-date-picker>

            <div v-if="weekly">
                <div class="form-group input-group">
                    <input type="checkbox" id="monday" value="1" v-model="daysChecked">
                    <label for="monday">Esmaspäev</label>

                    <input type="checkbox" id="tuesday" value="2" v-model="daysChecked">
                    <label for="tuesday">Teisipäev</label>

                    <input type="checkbox" id="wednesday" value="3" v-model="daysChecked">
                    <label for="wednesday">Kolmapäev</label>

                    <input type="checkbox" id="thursday" value="4" v-model="daysChecked">
                    <label for="thursday">Neljapäev</label>

                    <input type="checkbox" id="friday" value="5" v-model="daysChecked">
                    <label for="friday">Reede</label>

                    <input type="checkbox" id="saturday" value="6" v-model="daysChecked">
                    <label for="saturday">Laupäev</label>

                    <input type="checkbox" id="sunday" value="0" v-model="daysChecked">
                    <label for="sunday">Pühapäev</label>
                </div>

                <div class="form-group input-group">

                    <el-time-picker
                        is-range
                        v-model="DateTime"
                        placeholder="Pick a time range">
                    </el-time-picker>

                </div>
            </div>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" v-model="weekly">Korda iga nädal
            </label>
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-primary" @click="submit()">Salvesta</button>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            submiturl: {
                type: String,
                required: true,
            },
            id: {
                type: Number,
                required: true
            }
        },

        data() {
            return {
                DateTime: [new Date().now, new Date().now],
                daysChecked: [],
                weekly: false
            };
        },

        methods: {
            submit() {
                if (this.weekly) {
                    this.daysChecked.forEach(this.submitEach);
                } else {
                    axios.post(this.submiturl, {
                        id: this.id,
                        startTime: this.DateTime[0].toISOString().substring(0, 19).replace('T', ' '),
                        endTime: this.DateTime[1].toISOString().substring(0, 19).replace('T', ' '),
                        weekly: this.weekly
                    });
                }
                window.location.href = window.location.href;
            },
            submitEach(day) {
                axios.post(this.submiturl, {
                    id: this.id,
                    day: day,
                    startTime: this.DateTime[0].toISOString().substring(0, 19).replace('T', ' '),
                    endTime: this.DateTime[1].toISOString().substring(0, 19).replace('T', ' '),
                    weekly: this.weekly
                });
            },
            allowedDate(date) {
                console.log(date);
                return false;
            }
        }
    }
</script>

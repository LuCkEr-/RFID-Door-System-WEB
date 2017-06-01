<template>
    <div style="position:relative" :class="{'open':openSuggestion}">
        <label for="acInput" class="control-label">{{ label }}</label>
        <ul class="list-group" v-show="selected.length > 0">
            <li v-for="(item, index) in selected" class="list-group-item bg-info">
                {{ item.text }}
                <button type="button" class="close" aria-label="Close" @click="removeSelected(index)"><span aria-hidden="true" style="color:#d9534f">&times;</span></button>
            </li>
        </ul>

        <div class="form-group input-group" v-show="allowInput">
            <input if="acInput" class="form-control" type="text" :placeholder="placeholder" style="height: 42px" v-model="search"
                @keydown.enter = "enter"
                @keydown.down = "down"
                @keydown.up = "up"
                @input = "change"
            />

            <span class="input-group-btn">
                <button class="btn btn-primary" style="height: 42px" type="button" @click="enter">Uuenda
                </button>
            </span>
        </div>

        <ul class="dropdown-menu" style="width:100%">
            <li v-for="(item, index) in matches"
                :class="{'active': isActive(index)}"
                @click="suggestionClick(index)"
            >
                <a href="#">{{ item.text }}</a>
            </li>
        </ul>

    </div>
</template>


<script>
    export default {

        props: {
            maxselected: {
                type: Number,
                required: true
            },
            id: {
                type: Number,
                required: true
            },
            defualtvalue: {
                type: String,
                required: true,
            },
            label: {
                type: String,
                required: true
            },
            placeholder: {
                type: String,
                required: false
            },
            apisearch: {
                type: String,
                required: true
            },
            submiturl: {
                type: String,
                required: true,
            },
            removeurl: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                search: '',
                open: false,
                suggestions: [],
                selected:[],
                current: 0
            };
        },

        computed: {

            //Filtering the suggestion based on the input
            matches() {
                return this.suggestions.filter((str) => {
                    //true yes
                    var match = false;
                    this.selected.forEach(function(item) {
                        if (str.text === item.text) {
                            match = true;
                        }
                    });
                    return !match;
                });
            },

            // Allow input?
            allowInput() {
                return this.maxselected > this.selected.length;
            },

            // The flag
            openSuggestion() {
                return this.search &&
                       this.matches.length > 0 &&
                       this.open &&
                       this.allowInput;
            }
        },

        created() {
            this.getSuggestions = debounce(this.getSuggestions, 150);
            axios.post(this.defualtvalue, {
                id: this.id
            })
            .then(response => response.data.forEach(this.addDefualtValues))
            .catch(error => console.log(error));
        },

        methods: {
            //When enter pressed on the input
            enter() {
                if(this.open && this.matches.length > 0) {
                    this.updateUser(this.matches[this.current]);
                    this.selected.push(this.matches[this.current]);

                    this.search = '';
                    this.open = false;
                }
            },

            //When up pressed while suggestions are open
            up() {
                if(this.current > 0)
                    this.current--;
            },

            //When up pressed while suggestions are open
            down() {
                if(this.current < this.matches.length - 1)
                    this.current++;
            },

            //For highlighting element
            isActive(index) {
                return index === this.current;
            },

            //When the user changes input
            change() {
                if (!this.open) {
                    this.open = true;
                    this.current = 0;
                }

                this.getSuggestions();
            },

            // Add already selected values
            addDefualtValues(item) {
                this.selected.push(item);
            },

            getSuggestions() {
                if (this.search) {
                    axios.get(this.apisearch + this.search)
                    .then(response => this.suggestions = response.data)
                    .catch(error => console.log(error));
                }
            },

            //When one of the suggestion is clicked
            suggestionClick(index) {
                if (this.open && this.matches.length > 0) {
                    this.updateUser(this.matches[index]);
                    this.selected.push(this.matches[index]);

                    this.search = '';
                    this.open = false;
                }
            },

            removeSelected(index) {
                var removed = this.selected.splice(index, 1);
                axios.post(this.removeurl, {
                    id: this.id,
                    removeid: removed[0].id
                });
            },

            updateUser(item) {
                axios.post(this.submiturl, {
                    id: this.id,
                    newid: item.id,
                    text: item.text,
                });
            }
        }
    }
</script>

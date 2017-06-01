<template>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">{{ title }}</div>

                <div class="panel-body">
                    {{ body }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: [
            'title',
            'body'
        ],

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

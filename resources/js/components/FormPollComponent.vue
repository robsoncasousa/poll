<template>
    <div class="col-md-4 col-12 col-sm-6">
        <div class="card text-white bg-info">
            <div class="card-header">New Poll</div>

            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" v-model="description">
                    </div>
                    
                    <div class="form-group">
                        <div class="d-flex d-flex-row">
                            <label for="description">Options</label>
                            <button v-on:click="qtyOptions++" class="btn btn-secondary btn-sm ml-2" type="button">New Option</button>
                        </div>
                        
                        <input v-for="index in qtyOptions" :key="index" type="text" class="form-control mt-1" v-model="options[index-1]">
                    </div>

                    <button v-on:click="save()" type="button" class="btn btn-success"
                    :disabled="(description == '' || options.length < 1 ) ? true : false">Save</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                description: '',
                options: [],
                qtyOptions: 2
            }
        },
        methods: {
            save() {
                console.log('method save');
                axios.post('/api/v1/poll', {
                    "poll_description": this.description,
                    "options": this.options
                }).then(response => {
                    this.$root.$emit('SavedPoll');
                });
            }
        }
    }
</script>

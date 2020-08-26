<template>
    <div>
        <div class="container my-4 d-flex flex-row">
            <h1 class="h3 mr-auto">Polls</h1>
            <button v-on:click="showFormPoll()" class="btn btn-success btn-sm ml-2" type="button">New Poll</button>
        </div>

        <div class="container">
            <div class="row">
                
                <formPoll v-if="newFormPoll"></formPoll>

                <pollElement v-for="poll in polls" :key="poll.id" :pollId="poll.id"></pollElement>
            
            </div>
        </div>
    </div>
</template>

<script>
    import pollElement from './PollElementComponent.vue';
    import formPoll from './FormPollComponent.vue';

    export default {
        components: {
            pollElement,
            formPoll
        },
        data() {
            return {
                polls: [],
                newPoll: [],
                newFormPoll: false
            }
        },
        mounted() {
            this.getPolls();
            
            this.$root.$on('SavedPoll', () => {
                this.hideFormPoll();
                this.getPolls();
            })
        },
        methods: {
            getPolls() {
                axios.get('/api/v1/poll').then(response => {
                    this.polls = response.data;
                });
            },
            showFormPoll() {
                if(!this.newFormPoll) {
                    this.newFormPoll = true
                }
            },
            hideFormPoll() {
                if(this.newFormPoll) {
                    this.newFormPoll = false
                }
            }
        }
    }
</script>

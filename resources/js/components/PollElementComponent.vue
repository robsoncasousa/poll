<template>
    <div class="col-md-6 col-12 col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">Poll - <b>ID: {{ pollId }}</b></div>

            <div v-if="poll != ''" class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Id</b>: {{ poll.poll_id }}</li>
                    <li class="list-group-item"><b>Description</b>: {{ poll.poll_description }}</li>
                    <li class="list-group-item">
                        <b>Options</b>
                        <ul class="list-group list-group-flush" v-for="option in poll.options" :key="option.option_id">
                            <li class="list-group-item">
                                <div class="d-flex flex-row">
                                    <div class="mr-2">
                                        <input class="mt-3" type="radio" name="vote" :id="'option-' + option.option_id"
                                        :value="option.option_id" v-model="poll.optionSelected">
                                    </div>
                                    <div>
                                        <div><b>Id</b>: {{ option.option_id }}</div>
                                        <div><b>Description</b>: {{ option.option_description }}</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div v-if="stats != ''" class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Views</b>: {{ stats.views }}</li>
                    <li class="list-group-item">
                        <b>Votes</b>
                        <ul class="list-group list-group-flush" v-for="vote in stats.votes" :key="vote.option_id">
                            <li class="list-group-item">
                                <div>
                                    <div><b>Id</b>: {{ vote.option_id }}</div>
                                    <div><b>Quantity</b>: {{ vote.qty }}</div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <p v-if="voted" class="text-success">Vote Computed!</p>
            </div>

            <div class="card-body">
                <a v-on:click="getPoll(pollId)" class="btn btn-secondary">View</a>
                <a v-on:click="getStats(pollId)" class="btn btn-primary">Stats</a>
                
                <button v-on:click="vote(pollId, poll.optionSelected)" type="button" class="btn btn-success"
                :disabled="(poll == '' || !poll.optionSelected || poll.optionSelected == '') ? true : false">Vote</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            pollId: '',
        },
        data() {
            return {
                poll: '',
                stats: '',
                voted: false
            }
        },
        methods: {
            getPoll(id) {
                axios.get('/api/v1/poll/' + id).then(response => {
                    this.poll = response.data;
                    this.stats = '';
                    this.voted = false;
                });
            },
            getStats(id) {
                axios.get('/api/v1/poll/' + id + '/stats').then(response => {
                    this.stats = response.data;
                    this.poll = '';
                });
            },
            vote(pollId, optionId) {
                axios.post('/api/v1/poll/' + pollId + '/vote', { "option_id": optionId })
                .then(response => {
                    this.voted = true;
                    this.getStats(pollId);
                });
            }
        }
    }
</script>

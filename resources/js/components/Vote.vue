<template>
    <div class="d-felx flex-column vote-controls">
        <a @click.prevent="voteUp" :title="title('up')" :class="classes">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>
        <span class="vote-count">{{ count }}</span>
        <a @click.prevent="voteDown" :title="title('down')" :class="classes">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>

        <favorite v-if="name == 'question'" :question="model"></favorite>
        <accept v-else :answer="model"></accept>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import Accept from './Accept.vue';

    export default {
        props: ['name', 'model'],

        computed: {
            classes() {
                return this.signedIn ? '' : 'off';
            },

            endpoint() {
                return `/${this.name}s/${this.id}/vote`;
            }
        },

        components: {
            Favorite,
            Accept
        },

        data() {
            return {
                count: this.model.votes_count || 0,
                id: this.model.id
            }
        },
        
        methods: {
            title(voteType){
                let titles = {
                    up: `this ${this.name} is useful`,
                    down: `this ${this.name} is not useful`
                };

                return titles[voteType];
            },

            voteUp() {
                this._vote(1);
            },

            voteDown() {
                this._vote(-1);
            },

            _vote(vote) {
                if(!this.signedIn) {
                    this.$toast.warning(`Please login to vote the ${this.name}`, "Warning", {
                        timeout: 5000,
                        position: 'bottomLeft'
                    });

                    return; //type return agar tidak terus proses ke bawah.
                }

                axios.post(this.endpoint, {vote})
                .then(res => {
                    this.$toast.success(res.data.message, "Success", {
                        timeout: 5000,
                        position: 'bottomLeft'
                    });

                    // this.count += vote;
                    this.count = res.data.votesCount;
                })
            }
        }
    }
</script>
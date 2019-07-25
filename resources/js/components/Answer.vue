<template>
    <div class="media post">
        <!-- Voting system -->
        <vote :model="answer" name="answer"></vote>

        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea rows="10" v-model="body" class="form-control" required></textarea>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
            </form>
            <div v-else>
                
                <div v-html="bodyHtml"></div>
    
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <!-- Edit and delete button -->
                            <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info" style="cursor: pointer;">Edit</a>

                            <button v-if="authorize('modify', answer)" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                        </div>
                    </div>
                    <div class="col-4"></div>
        
                    <!-- Autho gravatar -->
                    <div class="col-4">
                        <user-info :model="answer" label="Answered"></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import Vote from './Vote.vue';
    import UserInfo from './UserInfo.vue';

    export default {
        components: { Vote, UserInfo },

        props: ['answer'],

        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEditCache: null
            }
        },

        methods : {
            edit() {
                this.beforeEditCache = this.body;
                this.editing = true;
            },

            cancel() {
                this.body = this.beforeEditCache;
                this.editing = false;
            },

            update() {
                axios.patch(this.endpoint, {
                    body: this.body
                })
                .then(res => {
                    this.editing = false;
                    this.bodyHtml = res.data.body_html;
                    this.$toast.success(res.data.message, "Success", {timeout: 10000});
                })
                .catch(err => {
                    this.$toast.error(err.response.data.message, "Error", {timeout: 10000});
                })
            },

            destroy () {
                // using izitoast
                this.$toast.question("Are you sure want to delete this ?", "Confirm", {
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {
                            axios.delete(this.endpoint)
                            .then(res => {
                                /* instance method $emit, untuk custom event. Yang mana custom event akan dipancarkan dari komponen child dan di-Listen oleh komponen parent.
                                emitting event-nya dari child komponen ke parent komponen. */
                                this.$emit('deleted');
                            });
                            instance.hide({ tansitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                
                        }],
                    ]
                });
            }
        },

        computed: {
            
            /*Jika button update isInvali dan diproses oleh return this dst. maka attribut :disabled menjadi true, dan lawannya menjadi false. */
            isInvalid() {
                return this.body.length < 10;
            },

            endpoint() {
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        }
    }
</script>
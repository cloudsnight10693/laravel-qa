<template>
    
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3>Your Answer</h3>
                        </div>

                        <hr>

                        <!-- v-on atau @ ==> @click.prevent="" merupakan method untuk memproses input data. cek the URI terlebih dahulu untuk membuat methodnya -->
                        <form @submit.prevent="create">
                            <div class="form-group">
                                <!-- Binding body with v-model in textarea -->
                                <textarea v-model="body" class="form-control" name="body" rows="7" required></textarea>
                            </div>
                            <div class="form-group">
                                <!-- :disabled ==> when isInvalid then disabled -->
                                <button :disabled="isInvalid" type="submit" class="btn btn-lg btn-outline-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
</template>

<script>
    export default {
        props: ['questionId'],

        methods: {
            create(){
                axios.post(`/questions/${this.questionId}/answers`, {
                    body: this.body
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message, "Error");
                })
                .then(({data}) => {
                    this.$toast.success(data.message, "Success");
                    this.body = '';
                    this.$emit('created', data.answer);
                })
            }
        },

        data(){
            return{
                body: ''
            }
        },

        computed: {
            isInvalid(){
                /* if not signed in or less than ten maka tombol submit tidak akan aktif. pada kasus ini setidak salah satunya cocok maka isInvalid. */
                return !this.signedIn || this.body.length < 10;
            }
        }
    }
</script>
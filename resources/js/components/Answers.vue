// This is index.blade.php from answers

<template>
    <div>
        <div class="row mt-4" v-cloak v-if="count">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                        <h2>{{ title }}</h2>
                        </div>
                        <hr>
                        <!-- v-on komponen atau @ untuk me-Listen komponen dari child komponen. Dengan ini child dan parent komponen dapat saling mengirim data. -->
                        <answer @deleted="remove(index)" v-for="(answer, index) in answers" :answer="answer" :key="answer.id"></answer>

                        <!-- v-if="nextUrl" untuk bilamana memiliki next url untuk direload maka akan muncul, selain itu tidak akan muncul -->
                        <div class="div text-center mt-3" v-if="nextUrl">
                            <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load More Answer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <new-answer @created="add" :question-id="question.id"></new-answer>
    </div>
</template>

<script>
    import Answer from './Answer.vue';
    import NewAnswer from './NewAnswer.vue';

    export default {
        props: ['question'],

        data(){
            return {
                questionId: this.question.id,
                count: this.question.answers_count,
                answers: [],
                nextUrl: null
            }
        },

        // untuk mengetest endpoint dibawah ini
        created(){
            this.fetch(`/questions/${this.questionId}/answers`);
        },

        methods: {
            add(answer){
                this.answers.push(answer);
                this.count++;
            },

            remove(index){
                /* argumen index menandakan posisi yang mana untuk menghapus item, argumen angka 1 merupakan berapa item yang ingin dihapus. Pada kasus ini adalah akan mengahpus satu item. */
                this.answers.splice(index, 1);
                /* decrement count property setiap delete */
                this.count--;
            },

            fetch(endpoint){
                axios.get(endpoint)
                // ({res} => {}) untuk mengambil data property ny saja
                .then(({data}) => {
                    // ...data.data >>> fungsi triple dot untuk menggabungkan antara aray jadi satu array dari pada menjadi array dalam array
                    this.answers.push(...data.data);

                    // next_page_url merupakan sebuah fungsi bawaan yang mana untuk menunjukkan url selanjutnya
                    this.nextUrl = data.next_page_url;
                })
            }
        },

        computed: {
            title() {
                return this.count + " " + (this.count > 1 ? 'Answers' : 'Answer')
            }
        },

        components: { Answer, NewAnswer }
    }
</script>
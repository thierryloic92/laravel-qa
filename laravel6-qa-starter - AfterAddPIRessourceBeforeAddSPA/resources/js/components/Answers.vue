<template>
<div>
<div class="row mt-4" v-cloak v-if="count">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2> {{ title }}
                    </h2>
                </div>
                <hr>
                <answer v-for="(answer,index) in answers" :answer="answer" :key="answer.id" @deleted="remove(index)"></answer>
                <div class="text-center mt-3" v-if="nextUrl">
                    <div class="btn btn-outline-secondary" @click.prevent="fetch(nextUrl)">Load more answers</div>
                </div>
            </div>
        </div>
    </div>
</div>
<new-answer @created="add" :question_id="question.id"></new-answer>
</div>
    
</template>

<script>
import Answer from './Answer.vue'
import NewAnswer from './NewAnswer'
import highlight from '../mixins/highlight'
export default {
  components: { Answer , NewAnswer},
  mixins : [highlight],
  data () {
      return {
          questionId : this.question.id,
          count : this.question.answers_count,
          answers : [],
          answerIds : [],
          nextUrl : null
      }
  },
  props : {
      question : {
          type : [Object,Array]
      }
    //   count : {
    //       type : [Number]
    //   }
  },

  created () {
this.fetch(`/questions/${this.questionId}/answers`);
  },

  methods : {
      add(answer){
          this.answers.push(answer);
          this.count++;
           this.$nextTick(()=>{
               this.highlight(`answer-${answer.id}`);
           });
      },
      remove(index) {
          this.answers.splice(index,1);// index où retirer l'élement 1: nombre d'élements à retirer.
          this.count --;
      },

      fetch (endpoint) {
          axios.get(endpoint)
          .then(({data})=>{
              console.log(data);
              this.answerIds = data.data.map(a => a.id);
              this.answers.push(...data.data);
              this.nextUrl = data.next_page_url;
          })
          .then(()=>{
              console.log(this.answerIds);
              this.answerIds.forEach(id => {
                  this.highlight(`answer-${id}`);
              });
          });
      }
  },

  computed: {
      title () {
          return this.count + " " + ( this.count > 1 ? 'Answers' : 'Answer');
      }
  }
    
}
</script>

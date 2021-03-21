<template>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3> Your answer</h3>
                </div>
                <hr>
                <form @submit.prevent="create">
                    <div class="form-group">
                        <m-editor :body="body" name="new-answer">
                        <textarea class="form-control" name="body" row="10" v-model="body" required>                         
                        </textarea>
                        </m-editor>

                    </div>
                    <div class="form-group">
                        <button class="btn btn-outline-primary btn-lg" :disabled="isInvalid">Submit</button>
                    </div>
                    
                </form>
        </div>
        
    </div>
</div>
</div>
</template>

<script>
import MEditor from './MEditor.vue';
export default {
  components: { MEditor },
    data () {
        return {
            body : ""
        }
    },
    
    props: {
        question_id : {
            type : [Number]
        }
    },
// questions/{question}/answers 
    computed : {
        isInvalid() {
             return !this.signedIn || this.body.length < 10;
        }
    },

    methods : {
        create () {
            axios.post(`/questions/${this.question_id}/answers`,{
                body : this.body
            })
            .then(({data})=>{
                this.$toast.success(data.message,"Success");
                this.body='';
                this.$emit('created',data.answer);
            })
            .catch(error => {
                this.$toast.error(error.response.data.message,"Error");
            });
        }
    }
}
</script>
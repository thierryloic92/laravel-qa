<template>
  <div>
    <a :class="classes" @click.prevent="toggle">
      <i class="fas fa-star fa-2x"></i>
      <span class="favorites-count"> {{ count }}</span>
    </a>
  </div>
</template>

<script>
export default {

    data () {
        return {
            is_favorited : this.question.is_favorited,
            count : this.question.favorites_count,
            id: this.question.id
        }

    },
    props : {
        question : {
            type : [Array,Object]
        }
    },
    computed : {
        classes () {
            return [
                'favorite', 'mt-2' , ! this.signedIn ? 'off' : (this.is_favorited ? 'favorited' : '')
            ];
        },

        endpoint () {
            return `/questions/${this.id}/favorites`;
        }


    },

    methods : {
        toggle () {
            if(! this.signedIn) {
                this.$toast.warning("Please login to favorite this question","warning",{
                    timeout : 3000,
                    position : "bottomLeft"
                });
                return ;
            }
            this.is_favorited ? this.destroy () : this.create () ;
        },

        destroy (){
            axios.delete(this.endpoint)
            .then(res=>{
                this.count--;
                this.is_favorited = false;

            });
        },

        create () {
            axios.post(this.endpoint)
            .then(res=>{
                this.count++;
                this.is_favorited = true;

            });
        }
    }
    
}
</script>
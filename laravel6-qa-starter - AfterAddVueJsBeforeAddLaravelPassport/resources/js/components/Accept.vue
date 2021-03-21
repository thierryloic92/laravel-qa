<template>
  <div>
    <a
      v-if="canAccept"
      :class="classes"
      title="Mark this answer as best answer"
      @click="create"
    >
      <i class="fas fa-check fa-2x"></i>
    </a>

    <a
      v-if="accepted"
      :class="classes"
      title="The question owner accepted  this answer as best answer"
    >
      <i class="fas fa-check fa-2x"></i>
    </a>
  </div>
</template>

<script>
import eventBus from '../event-bus';
export default {
  data() {
    return {
        is_best : this.answer.is_best,
        id : this.answer.id
    };
  },

  props: {
    answer: {
      type: [Array, Object],
    },
  },

  created () {
    eventBus.$on('accepted', id =>{
      this.is_best = (this.id === id);
    });
  },

  methods : {
      create () {
          axios.post(`/answers/${this.id}/accept`)
          .then(res=>{
              this.$toast.success(res.data.message,"Success",{
                  timeout : 3000,
                  position:"bottomLeft"
              });

              this.is_best = true;
              eventBus.$emit('accepted',this.id);
          });
      }
  },

  computed: {
    canAccept() {
      return this.authorize('accept',this.answer);
    },

    accepted() {
      return !this.canAccept && this.is_best;
    },
    
    classes () {
        return [ this.is_best ?  'vote-accepted' : '', 'mt-2'];
        // return [ this.accepted ?  'vote-accepted' : '', 'mt-2'];
    }
  },
};
</script>
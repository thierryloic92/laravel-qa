<template>
  <div>
    <div class="d-flex flex-column vote-controls">
      <a
        class="vote-up"
        :class="classes"
        :title="title('up')"
        @click.prevent="voteUp"
      >
        <i class="fas fa-caret-up fa-3x"></i>
      </a>
      <span class="votes-count"> {{ count }}</span>
      <a
        class="vote-down"
        :class="classes"
        :title="title('down')"
        @click.prevent="voteDown"
      >
        <i class="fas fa-caret-down fa-3x"></i>
      </a>
      <favorite v-if="name === 'question'" :question="model"></favorite>
      <accept v-else :answer="model"></accept>
    </div>
  </div>
</template>

<script>
// import Favorite from './Favorite';
// import Accept from './Accept';
export default {
  data() {
    return {
      count: this.model.votes_count ||0,
      id: this.model.id,
    };
  },

  props: {
    name: {
      type: [String, Object],
    },

    model: {
      type: [String, Object],
    },
  },

  methods: {
    title(voteType) {
      let titles = {
        up: `This ${this.name} is useful`,
        down: `This ${this.name} is not useful`,
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
      if (!this.signedIn) {
          this.$toast.warning(`Please login to vote the ${this.name}`,"warning",{
              timeout : 3000,
              position : "bottomLeft"
          });

          return;
      }  
      axios.post(this.endpoint, { vote }).then((res) => {
        this.$toast.success(res.data.message, "Success", {
                    timeout : 3000,
                    position : "bottomLeft"
        });
        this.count = res.data.votesCount;
      });
    },
  },

  computed: {
    classes() {
      return this.signedIn ? "" : "off";
    },

    endpoint() {
      return `/${this.name}s/${this.id}/vote`;
    },
  },

  // components : {
  //     Favorite : Favorite,
  //     Accept : Accept
  // }
};
</script>
<template>
  <div>
    <div class="media post">
      <vote :model="answer" name="answer"></vote>
      <div class="media-body">
        <form v-show="authorize('modify',answer) && editing" @submit.prevent="update">
          <div class="form-group">
            <m-editor :body="body" :name="uniqueName">
            <textarea class="form-control" row="10" v-model="body" required>
            </textarea>
            </m-editor>
          </div>
          <button class="btn btn-outline-primary" :disabled="isInvalid">
            Update
          </button>
          <button @click="cancel" class="btn btn-outline-primary" type="button">
            Cancel
          </button>
        </form>
        <div v-show="!editing">
          <div v-html="bodyHtml" ref="bodyHtml" :id="uniqueName"></div>
          <div class="row">
            <div class="col-4">
              <div class="ml-auto">
                <a
                  v-if="authorize('modify', answer)"
                  @click.prevent="edit"
                  class="btn btn-sm btn-outline-info"
                  >Edit</a
                >
                <button
                  v-if="authorize('modify', answer)"
                  class="btn btn-sm btn-outline-danger"
                  @click="destroy"
                >
                  Delete
                </button>
              </div>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
              <user-info label="Answered" :model="answer"> </user-info>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MEditor from './MEditor';
import modification from "../mixins/modification";
export default {
  components: { MEditor },
  data() {
    return {
      body: this.answer.body,
      bodyHtml: this.answer.body_html,
      id: this.answer.id,
      question_id: this.answer.question_id,
      before_edit_cache: null,
    };
  },

  mixins: [modification],
  props: {
    answer: {
      type: [Array, Object],
    },
  },

  methods: {
    setEditCache() {
      this.before_edit_cache = this.body;
    },
    restoreFromCache() {
      this.body = this.before_edit_cache;
    },

    payload() {
      return {
        body: this.body,
      };
    },

    refreshRender(data) {
      this.editing = false;
      this.bodyHtml = data.body_html;
      this.$toast.success(data.message, "Success", { timeout: 3000 });
    },
    update_old() {
      axios
        .patch(this.endpoint, {
          body: this.body,
        })
        .then((res) => {
          console.log(res);
          this.editing = false;
          this.bodyHtml = res.data.body_html;
          this.$toast.success(res.data.message, "Success", { timeout: 3000 });
        })
        .catch((err) => {
          this.$toast.error(err.response.data.message, "Error", {
            timeout: 3000,
          });
        });
    },

    delete() {
      axios.delete(this.endpoint).then(({ data }) => {
        this.$emit("deleted");
        this.$toast.success(data.message, "Success", { timeout: 3000 });
      });
    },

    destroy_old() {
      this.$toast.question("Are you sure about that?", "Confirm", {
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: "once",
        id: "question",
        zindex: 999,
        title: "Hey",
        position: "center",
        buttons: [
          [
            "<button><b>YES</b></button>",
            (instance, toast) => {
              axios.delete(this.endpoint).then(({ data }) => {
                this.$emit("deleted");
                this.$toast.success(data.message, "Success", { timeout: 3000 });
                // $(this.$el).fadeOut(500, () => {
                //   alert(res.data.message);
                // });
              });

              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            },
            true,
          ],
          [
            "<button>NO</button>",
            (instance, toast) => {
              instance.hide({ transitionOut: "fadeOut" }, toast, "button");
            },
          ],
        ],
      });

      //   if (confirm("Are you sure?")) {
      //     axios.delete(this.endpoint).then((res) => {
      //       $(this.$el).fadeOut(500, () => {
      //         alert(res.data.message);
      //       });
      //     });
      //   }
    },
  },
  computed: {
    isInvalid() {
      return this.body.length < 10;
    },
    endpoint() {
      return `/questions/${this.question_id}/answers/${this.id}`;
    },

    uniqueName () {
      return `answer-${this.id}`;
    }
  },
};
</script>

<style>
</style>
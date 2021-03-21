<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <form class="card-body" v-show="authorize('modify',question) && editing" @submit.prevent="update">
          <div class="card-title">
            <input
              type="text"
              class="form-control form-control-lg"
              v-model="title"
            />
          </div>
          <hr />
          <div class="media">
            <div class="media-body">
              <div class="form-group">
                <m-editor :body="body" :name="uniqueName">
                <textarea class="form-control" row="10" v-model="body" required>
                </textarea>
                </m-editor>
              </div>
              <button class="btn btn-outline-primary" :disabled="isInvalid">
                Update
              </button>
              <button
                @click="cancel"
                class="btn btn-outline-primary"
                type="button"
              >
                Cancel
              </button>
            </div>
          </div>
        </form>
        <div class="card-body" v-show="!editing">
          <div class="card-title">
            <div class="d-flex align-items-center">
              <h1>{{ title }}</h1>
              <div class="ml-auto">
                <a href="/questions" class="btn btn-outline-secondary"
                  >Back to all Questions</a
                >
              </div>
            </div>
          </div>
          <hr />
          <div class="media">
            <vote :model="question" name="question"></vote>
            <div class="media-body">
              <div v-html="bodyHtml" ref="bodyHtml"></div>
              <div class="row">
                <div class="col-4">
                  <div class="ml-auto">
                    <a
                      v-if="authorize('modify', question)"
                      @click.prevent="edit"
                      class="btn btn-sm btn-outline-info"
                      >Edit</a
                    >
                    <button
                      v-if="authorize('deleteQuestion', question)"
                      class="btn btn-sm btn-outline-danger"
                      @click="destroy"
                    >
                      Delete
                    </button>
                  </div>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
                  <user-info label="Question asked" :model="question">
                  </user-info>
                </div>
              </div>
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
  data() {
    return {
      title: this.question.title,
      body: this.question.body,
      bodyHtml: this.question.body_html,
      id: this.question.id,
      before_editing_cache: {},
    };
  },
  mixins: [modification],
  components : {MEditor},
  props: 
    {
    question: {
      type: [Object],
    },
  },
  computed: {
    isInvalid() {
      return this.body.length < 10 || this.title.length < 10;
    },

    endpoint() {
      return `/questions/${this.id}`;
    },

        uniqueName () {
      return `question-${this.id}`;
    }
  },

  methods: {
    setEditCache() {
      this.before_editing_cache = {
        body: this.body,
        title: this.title,
      };
    },

    restoreFromCache() {
      this.body = this.before_editing_cache.body;
      this.title = this.before_editing_cache.title;
    },

    payload() {
      return {
        body: this.body,
        title: this.title,
      };
    },

    refreshRender(data) {
      this.bodyHtml = data.body_html;
      this.$toast.success(data.message, "Success", {
        timeout: 3000,
      });
    },

    update_old() {
      axios
        .put(this.endpoint, {
          body: this.body,
          title: this.title,
        })
        .then(({ data }) => {
          this.bodyHtml = data.body_html;
          this.$toast.success(data.message, "Success", {
            timeout: 3000,
          });
          this.editing = false;
        })
        .catch(({ response }) => {
          this.$toast.error(response.data.message, "Error", {
            timeout: 3000,
          });
        });
    },

    delete() {
      axios.delete(this.endpoint).then(({ data }) => {
        this.$toast.success(data.message, "success", { timeout: 2000 });
      });
      setTimeout(() => {
        window.location.href = "/questions";
      }, 3000);
    },

    destroy() {
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
                this.$toast.success(data.message, "success", { timeout: 2000 });
                // $(this.$el).fadeOut(500, () => {
                //   alert(res.data.message);
                // });
              });
              setTimeout(() => {
                window.location.href = "/questions";
              }, 3000);
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
};
</script>
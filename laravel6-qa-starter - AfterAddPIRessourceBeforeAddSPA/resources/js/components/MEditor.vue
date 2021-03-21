<template>
  <div>
    <div class="card">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" :href="tabId('write','#')">Write</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" :href="tabId('preview','#')">Preview</a>
          </li>
        </ul>
      </div>
      <div class="card-body tab-content">
        <div class="tab-pane active" :id="tabId('write')">
          <slot></slot>
        </div>
        <div class="tab-pane" :id="tabId('preview')" v-html="preview"></div>
      </div>
    </div>
  </div>
</template>

<script>
import MarkDownIt from 'markdown-it';
import prism from 'markdown-it-prism';
import autosize from 'autosize';
const md = new MarkDownIt ();
md.use(prism);
export default {
  props: {
    body: {
      type: [Text, String],
    },

    name: {
      type :[Text,String]
    }
  },

  computed : {
    preview () {
      return md.render(this.body);
    }
  },

  watch : {
    // body :function() {
    //   console.log('Body watch');
    // }
  },
  updated () {
    // autosize(document.querySelector('textarea'));
    autosize(this.$el.querySelector('textarea'));
  },

  methods : {
    tabId(tabName,hash='') {
      return `${hash}${tabName}${this.name}`;
    }
  }
};
</script>
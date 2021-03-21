import Prism from 'prismjs';
export default {
    methods: {
        highlight(id = "") {
            let el = '';
            el = id ? document.getElementById(id) : this.$refs.bodyHtml;

            console.log(el);
            if (el) Prism.highlightAllUnder(el);
        }
    }
}
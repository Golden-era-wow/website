import { difference } from 'lodash';

export default {
    props: ['value', 'tags'],

    computed: {
        freeTags () {
            return difference(this.tags, this.value)
        }
    },

    methods: {
      selectTag(tag) {
        if (this.value.includes(tag)) {
          return
        }

        this.$emit('input', [...this.value, tag])
      },

      removeTag(tag) {
        this.$emit('input', this.value.filter(t => t !== tag))
      }
    },
    
    render() {
      return this.$scopedSlots.default({
        tags: this.tags,
        options: this.freeTags,
        selected: this.value,
        selectTag: this.selectTag,
        removeTag: this.removeTag,
      })
    },
}
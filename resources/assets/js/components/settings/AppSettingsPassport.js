export default {
    props: {
        user: Object
    },

    data () {
        return {
            showingClients: true,
            showingTokens: false
        }
    },

    methods: {
        showClients () {
            this.showingTokens = false;
            this.showingClients = true;
        },

        showTokens () {
            this.showingClients = false;
            this.showingTokens = true;
        }
    },

    render: function(createElement) {
        return this.$scopedSlots.default({
            showClients: this.showClients,
            showingClients: this.showingClients,
            showTokens: this.showTokens,
            showingTokens: this.showingTokens
        });
    }
}

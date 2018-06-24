import Form from 'form-backend-validation';
import swal from 'sweetalert2';

export default {
    components: { Form },

    render() {
        return this.$scopedSlots.default({
            tokens: this.tokens,
            scopes: this.scopes,
            creatingToken: this.creatingToken,
            createToken: this.showCreateTokenForm,
            showTokens: this.showTokens,
            store: this.store,
            form: this.form
        });
    },

    data() {
        return {
            creatingToken: false,

            tokens: [],
            scopes: [],

            form: new Form({
                name: '',
                scopes: []
            })
        };
    },

    mounted() {
        this.prepareComponent();
    },

    methods: {
        /**
         * Prepare the component.
         */
        prepareComponent() {
            this.getTokens();
            this.getScopes();
        },

        /**
         * Get all of the personal access tokens for the user.
         */
        async getTokens() {
            const { data } = await axios.get('/oauth/personal-access-tokens')

            this.tokens = data
        },

        /**
         * Get all of the available scopes.
         */
        async getScopes() {
            const { data } = await axios.get('/oauth/scopes')

            this.scopes = data
        },

        /**
         * Revoke the given token.
         */
        async revoke(token) {
            await axios.delete('/oauth/personal-access-tokens/' + token.id)

            this.getTokens()
        },

        /**
         * Create a new personal access token.
         */
        async store() {
            const { token, accessToken } = await this.form.post('/oauth/personal-access-tokens')

            this.tokens.push(token);
            this.creatingToken = false;
            this.showAccessToken(accessToken);

            this.form.name = '';
            this.form.scopes = [];
        },

        /**
         * Show t he users current tokens
         */
        showTokens() {
            this.creatingToken = false;
        },

        /**
         * Show the form for creating new tokens
         */
        showCreateTokenForm() {
            this.creatingToken = true
        },

        /**
         * Show the given access token to the user.
         */
        showAccessToken(accessToken) {
            swal({
                title: 'Here is your new personal access token.',
                type: 'success',
                html:
                    "This is the <b>only</b> time it will be shown so don't lose it!" +
                    '<br>' +
                    '<i>You may now use this token to make API requests.</i>' +
                    '<br><br>' +
                    '<hr class="border border-brand">' +
                    `<blockquote>${accessToken}</blockquote>`,
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: true,
                confirmButtonText:
                    '<i class="fa fa-thumbs-up"></i> I have copied it to a safe place!',
                confirmButtonAriaLabel: 'Thumbs up, I have copied it to a safe place!'
            });
        }
    }
}

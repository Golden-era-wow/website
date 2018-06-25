import swal from "sweetalert2";
import Form from "form-backend-validation/dist/Form";

export default {
    props: { user: Object },

    data: function () {
        return {
            form: new Form({
                name: '',
                email: ''
            })
        }
    },

    watch: {
        user: {
            handler: function (user) {
                if (user) {
                    this.form.name = user.name;
                    this.form.email = user.email;
                }
            },

            immediate: true
        }
    },

    methods: {
        async update() {
            const user = await this.form.put('/api/current-user')
            this.$store.dispatch('setUser', user)
        },

        async destroy() {
            axios.delete('/api/current-user');
            axios.post('/logout');

            window.location = window.Laravel.url;
        },

        async confirmDestroy() {
            const result = await swal({
                title: 'Are you sure?!',
                text: `Your user & game accounts will no longer to usable!`,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            });

            if (result.value) {
                this.destroy();

                swal({
                    title: 'Bye bye beautiful...',
                    type: 'info',
                    html:
                        "We're so sorry to see you go <i class='fas fa-sad-tear'></i>",
                    showCloseButton: true,
                    showCancelButton: false
                });
            }
        },
    },

    render: function () {
        return this.$scopedSlots.default({
            update: this.update,
            destroy: this.confirmDestroy,
            form: this.form
        });
    }
};

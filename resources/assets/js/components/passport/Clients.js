import Form from 'form-backend-validation';
import Swal from 'sweetalert2';

export default {
    components: { Form },

    render() {
        return this.$scopedSlots.default({
            clients: this.clients,
            showClients: this.showClientsTable,
            creating: this.creatingClient,
            create: this.showCreateClientForm,
            createForm: this.createForm,
            editing: this.editingClient,
            edit: this.showEditClientForm,
            editForm: this.editForm,
            store: this.store,
            update: this.update,
            destroy: this.confirmDeleteClient
        });
    },

    data() {
        return {
            clients: [],

            creatingClient: false,
            editingClient: false,

            createForm: new Form({
                name: '',
                redirect: ''
            }),

            editForm: new Form({
                name: '',
                redirect: ''
            })
        };
    },

    mounted() {
        this.fetchClients();
    },

    methods: {
        /**
         * Get all of the OAuth clients for the user.
         */
        async fetchClients() {
            const { data } = await axios.get('/oauth/clients')

            this.clients = data
        },

        /**
         * Create a new OAuth client for the user.
         */
        async store() {
            await this.createForm.post('/oauth/clients');

            this.fetchClients();

            this.showClientsTable();
        },

        /**
         * Update the client being edited.
         */
        async update() {
            await this.editForm.put(`/oauth/clients/${this.editForm.id}`);
                
            this.fetchClients();

            this.showClientsTable();
        },

        /**
         * Destroy the given client.
         */
        async destroy(client) {
            await axios.delete(`/oauth/clients/${client.id}`);

            this.fetchClients();

            this.showClientsTable();
        },

        async confirmDeleteClient (client) {
            const result = await Swal({
                title: 'Are you sure?',
                text: `Client[${client.id}] will be gone for good!`,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            });

            if (result.value) {
                this.destroy(client);

                Swal(
                    'Deleted!',
                    `Client[${client.id}] has been deleted.`,
                    'success'
                )
            }
        },

        showClientsTable () {
            this.creatingClient = false;
            this.editingClient = false;
        },

        /**
         * Show the form for creating new clients.
         */
        showCreateClientForm() {
            this.creatingClient = true;
        },

        /**
         * Edit the given client.
         */
        showEditClientForm(client) {
            this.editForm.id = client.id;
            this.editForm.name = client.name;
            this.editForm.redirect = client.redirect;

            this.creatingClient = false;
            this.editingClient = true;
        }
    }
}

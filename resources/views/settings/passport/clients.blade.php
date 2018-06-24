                    <passport-clients>
                        <div slot-scope="{ clients, showClients, create, createForm, creating, store, edit, editForm, editing, update, destroy }">
                            <button @click="create" class="bg-transparent hover:bg-brand text-brand-dark font-semibold hover:text-white py-2 px-4 border border-brand hover:border-transparent rounded">
                                {{ __('Create OAuth Client') }}
                            </button>

                            <button @click="showClients" class="bg-transparent hover:bg-brand text-brand-dark font-semibold hover:text-white py-2 px-4 border border-brand hover:border-transparent rounded">
                                {{ __('Show clients') }}
                            </button>

                            <transition name="fade">
                                <template v-if="clients.length === 0">
                                    @include('settings.passport.no-clients-alert')
                                </template>
                            </transition>

                            <transition name="fade">
                                <template v-if="! creating && ! editing">
                                    @include('settings.passport.clients-table')
                                </template>
                            </transition>

                            <transition name="fade-slide">
                                <template v-if="editing">
                                    @include('settings.passport.edit-client-form')
                                </template>
                            </transition>

                            <transition name="fade-slide">
                                <template v-if="creating">
                                    @include('settings.passport.create-client-form')
                                </template>
                            </transition>
                        </div>
                    </passport-clients>
import { Tabs, Tab } from 'vue-tabs-component';
import Tooltip from '../Tooltip.vue';
import AppSettingsUser from './AppSettingsUser';
import AppSettingsPassport from './AppSettingsPassport';
import PassportPersonalAccessTokens from '../passport/PersonalAccessTokens.js';
import PassportClients from '../passport/Clients.js';
import PassportAuthorizedClients from '../passport/AuthorizedClients';

Vue.component('app-settings', {
    components: {
        Tab, Tabs,
        Tooltip,
        AppSettingsUser,
        AppSettingsPassport,
        PassportPersonalAccessTokens,
        PassportClients,
        PassportAuthorizedClients
    },

    props: { user: Object },

    // render: function(createElement) {
    //     return createElement('div', [
    //         this.$scopedSlots[0]
    //     ]);
    // }
})

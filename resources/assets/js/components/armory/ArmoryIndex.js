import { Tabs, Tab } from 'vue-tabs-component';
import ArmoryTooltip from './ArmoryTooltip';
import ArmoryGuildLadder from './ArmoryGuildLadder.vue';

Vue.component('armory-index', {
	components: { 
		Tabs, Tab,
		ArmoryTooltip,
		ArmoryGuildLadder
	}
});
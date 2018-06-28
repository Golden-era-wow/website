import { Tabs, Tab } from 'vue-tabs-component';
import ArmoryTooltip from './ArmoryTooltip';
import ArmoryGuildLadder from './ArmoryGuildLadder';

Vue.component('armory-index', {
	components: { 
		Tabs, Tab,
		ArmoryTooltip,
		ArmoryGuildLadder
	}
});
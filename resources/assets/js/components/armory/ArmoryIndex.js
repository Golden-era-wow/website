import { Tabs, Tab } from 'vue-tabs-component';
import ArmoryTooltip from './ArmoryTooltip';
import ArmoryGuildLadder from './ArmoryGuildLadder';

export default {
	render: function (createElement) {
	  return this.$scopedSlots.default({})
	},

	components: { 
		Tabs, Tab,
		ArmoryTooltip,
		ArmoryGuildLadder
	}
}
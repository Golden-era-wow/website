export default {
	computed: {
		isLoaded () {
			return document.querySelectorAll(`script[src='${this.url}']`).length > 0;
		},

		url () {
			return "https://cdn.cavernoftime.com/api/tooltip.js";
		}
	},

	data () {
		return {
			config: {
	            /* Enable or disable the rename of URLs into item, spell and other names automatically */
	            rename: true,
	            /* Enable or disable icons appearing on the left of the tooltip links. */
	            icons: true,
	            /* Overrides the default icon size of 15x15, 13x13 as an example, icons must be true */
	            iconsize: 15,
	            /* Enable or disable link rename quality colors, an epic item will be purple for example. */
	            qualitycolor: true,
	            /* TBA */
	            forcexpac: { },
	            /* Override link colors, qualitycolor must be true. Example: spells: '#000' will color all renamed spell links black. */
	            overridecolor: {
	                spells: '',
	                items: '',
	                npcs: '',
	                objects: '',
	                quests: '',
	                achievements: ''
	            }
			}
		}
	},

	mounted () {
		if (! this.isLoaded) {
			this.appendScriptToHead();
			this.bindConfigurationToWindow();
		}
	},

	methods: {
		appendScriptToHead () {
			let scriptTag = document.createElement('script');

			scriptTag.setAttribute('src', this.url);

			document.head.appendChild(scriptTag);
		},

		bindConfigurationToWindow () {
			window.CoTTooltips = this.config;
		}
	}
}
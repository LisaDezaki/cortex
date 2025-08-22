<!-- <script>

	import ArticleTabs  from '@/Components/UI/ArticleTabs.svelte'

	let {
		children,
		class: className,
		tab = $bindable('details'),
		...restProps
	} = $props()

</script>

<ArticleTabs class={className} value={tab} tabs={[
	{ icon: "UserList",       label: "Details",       value: "details"       },
	{ icon: "Handshake",      label: "Relationships", value: "relationships" },
	{ icon: "FlagBannerFold", label: "Factions",      value: "factions"      },
	{ icon: "Backpack",       label: "Inventory",     value: "items"         },
	{ icon: "MapPinArea",     label: "Location",      value: "location"      },
	{ icon: "ImagesSquare",   label: "Media",         value: "media"         },
	{ icon: "Textbox",        label: "Custom Fields", value: "custom"        }
]} {...restProps}>

	{@render children?.()}

</ArticleTabs> -->
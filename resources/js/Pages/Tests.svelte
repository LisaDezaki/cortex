<script>

	import { page } from '@inertiajs/svelte'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import Flex		from '@/Components/Core/Flex.svelte'
	import Grid		from '@/Components/Core/Grid.svelte'
	import Inline	from '@/Components/Core/Inline.svelte'
	import PanZoom	from '@/Components/Core/PanZoom.svelte'
	import Stack	from '@/Components/Core/Stack.svelte'

	import Avatar    	from '@/Components/UI/Avatar.svelte'
	import Badge     	from '@/Components/UI/Badge.svelte'
	import Button    	from '@/Components/UI/Button.svelte'
	import Chip    		from '@/Components/UI/Chip.svelte'
	import Code    		from '@/Components/UI/Code.svelte'
	import Demo  		from '@/Components/UI/Demo.svelte'
	import DragHandle  	from '@/Components/UI/DragHandle.svelte'
	import Dropdown  	from '@/Components/UI/Dropdown.svelte'
	import Entity    	from '@/Components/UI/Entity.svelte'
	import Field     	from '@/Components/UI/Field.svelte'
	import Heading   	from '@/Components/UI/Heading.svelte'
	import Icon 		from '@/Components/UI/Icon.svelte'
	import Input		from '@/Components/UI/Input'
	import PageHeader	from '@/Components/UI/PageHeader.svelte'
	import PageHeading	from '@/Components/UI/PageHeading.svelte'
	import PageMenu  	from '@/Components/UI/PageMenu.svelte'
	import ReorderableList from '@/Components/Core/ReorderableList.svelte'
	import Section   	from '@/Components/UI/Section.svelte'
	import Separator 	from '@/Components/UI/Separator.svelte'
	import Table     	from '@/Components/UI/Table'
	import Tabs     	from '@/Components/UI/Tabs'
	import Tag     		from '@/Components/UI/Tag.svelte'
	import Thumbnail 	from '@/Components/UI/Thumbnail.svelte'
	import Toast 		from '@/Components/UI/Toast.svelte'
	import Tooltip 		from '@/Components/UI/Tooltip.svelte'

	import CharacterList from '@/services/CharacterList.js'

	const activeProject = $page.props.activeProject?.data
	const characters	= $state(activeProject ? new CharacterList(activeProject.characters) : [])

	let active = $state('avatar')

	let test = $state({
		avatar: {
			fallback: 	'AB',
			size: 		32,
			src: 		'/img/avatar-1.png',
			status:		'loaded'
		},
		badge: {
			disabled:	false,
			error:		false,
			text: 		99,
			style:		'hard',
			theme: 		'accent'
		},
		button: {
			disabled:	false,
			icon:		'At',
			loading:	false,
			size:		'md',
			style:		'hard',
			text:		'Button',
			theme:		'neutral',
		},
		checkbox: {
			checked:	true,
			disabled:	false,
			label:		'Checkbox',
			size:		'md'
		},
		chip: {
			state: 		'',
			text: 		'Chip'
		},
		dropdown: {
			icon: 		'Books',
			label: 		'Dropdown',
			placeholder:'Placeholder...',
			size:		'md',
			text:		'Dropdown',
			value: 		''
		},
		entity: {
			count: 		12,
			layout:		'stack',
			size: 		'md',
			type:		'characters'
		},
		field: {
			disabled:	false,
			icon:		'At',
			name:		'field',
			placeholder:'Placeholder...',
			size:		'md',
			type:		'text',
			value:		'Field'
		},
		icon: {
			name:		'At',
			size:		'md',
			weight:		'regular'
		},
		input: {
			icon:		'At',
			placeholder:'Placeholder...',
			size:		'md',
			type:		'text',
			value:		''
		},
		media: {

		},
		panzoom: {

		},
		popover: {

		},
		radio: {
			disabled:	false,
			name:		'radio',
			size:		'md',
			value:		'radio1'
		},
		reorderable: {

		},
		select: {
			disabled:	false,
			icon:		'At',
			name:		'select',
			placeholder:'Placeholder...',
			size:		'md',
			value:		''
		},
		slider: {
			disabled:	false,
			min:		0,
			max:		100,
			name:		'slider',
			size:		'md',
			style:		'fill',
			ticks:		true,
			value:		50
		},
		switch: {
			checked:	true,
			disabled:	false,
			name:		'switch',
			size:		'md'
		},
		table: {
			selected:	null,
			sortBy:		'name',
			sortFn:		(a,b) => a.name.toLowerCase() < b.name.toLowerCase ? -1 : 1
		},
		tabs: {
			value:		'tabs_1'
		},
		tag: {
			style:		'soft',
			theme:		'neutral',
			text:		'Tag',
			size:		'md'
		},
		thumbnail: {
			alt:		'Thumbnail',
			src:		'/img/avatar-1.png',
			size:		24
		},
		toast: {
			icon:		'At',
			message:	'This is a toast component.',
			theme:		'neutral',
			timeout:	null
		},
		tooltip: {
			text:		'This is a tooltip'
		},
		upload: {
			accept:		'image/png, image/jpeg',
			id:			'upload',
			name:		'upload',
			text:		'Upload',
			value:		null
		}
	})
	
</script>

<svelte:head>
    <title>Test Components</title>
</svelte:head>

<AuthenticatedLayout>
	
	{#snippet article()}
		<Section size="5xl" class="h-full overflow-y-auto">
			<Flex class="w-full">
				<PageMenu class="sticky top-0 py-12 pr-6"
					items={[
						{ label: 'Avatar',		active: active === 'avatar',   	onclick: () => active = "avatar" 	},
						{ label: 'Badge',		active: active === 'badge',    	onclick: () => active = "badge" 	},
						{ label: 'Button',		active: active === 'button',   	onclick: () => active = "button" 	},
						{ label: 'Checkbox',	active: active === 'checkbox',  onclick: () => active = "checkbox" 	},
						{ label: 'Chip',		active: active === 'chip',   	onclick: () => active = "chip" 		},
						{ label: 'Dropdown',	active: active === 'dropdown', 	onclick: () => active = "dropdown" 	},
						{ label: 'Entity',		active: active === 'entity', 	onclick: () => active = "entity" 	},
						{ label: 'Field',		active: active === 'field', 	onclick: () => active = "field" 	},
						{ label: 'Icon',		active: active === 'icon',		onclick: () => active = "icon" 		},
						{ label: 'Input',		active: active === 'input', 	onclick: () => active = "input" 	},
						{ label: 'Media',		active: active === 'media', 	onclick: () => active = "media" 	},
						{ label: 'PanZoom',		active: active === 'panzoom', 	onclick: () => active = "panzoom" 	},
						{ label: 'Popover',		active: active === 'popover', 	onclick: () => active = "popover" 	},
						{ label: 'Radio', 		active: active === 'radio', 	onclick: () => active = "radio" 	},
						{ label: 'Reorderable', active: active === 'reorderable', onclick: () => active = "reorderable" },
						{ label: 'Select', 		active: active === 'select', 	onclick: () => active = "select" 	},
						{ label: 'Slider', 		active: active === 'slider', 	onclick: () => active = "slider" 	},
						{ label: 'Switch', 		active: active === 'switch', 	onclick: () => active = "switch" 	},
						{ label: 'Table',		active: active === 'table', 	onclick: () => active = "table" 	},
						{ label: 'Tabs',		active: active === 'tabs',		onclick: () => active = "tabs" 		},
						{ label: 'Tag',			active: active === 'tag', 		onclick: () => active = "tag" 		},
						{ label: 'Thumbnail',	active: active === 'thumbnail', onclick: () => active = "thumbnail" },
						{ label: 'Toast',		active: active === 'toast', 	onclick: () => active = "toast" 	},
						{ label: 'Tooltip',		active: active === 'tooltip', 	onclick: () => active = "tooltip" 	},
						{ label: 'Upload',		active: active === 'upload',	onclick: () => active = "upload" 	},
					]}
				/>
				<Stack gap={12} class="h-full min-w-96 overflow-y-auto p-12 w-full">

					{#if      active === 'avatar'}
		
						<!-- Avatar -->

						<PageHeading
							title="Avatar"
							subtitle="Represents a user with an image and a fallback placeholder string."
						/>

						<Stack>
							<Demo name="Avatar">
								<Avatar {...test.avatar} class="w-{test.avatar.size}" />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select bind:value={test.avatar.src} icon="ImageSquare" placeholder="Image URL..." class="w-24" options={[
									{ label: 'Blue',   value: '/img/avatar-1.png' },
									{ label: 'Green',  value: '/img/avatar-2.png' },
									{ label: 'Pink',   value: '/img/avatar-3.png' },
									{ label: 'Red',    value: '/img/avatar-4.png' },
									{ label: 'Orange', value: '/img/avatar-5.png' },
								]} />
								<Input.Text bind:value={test.avatar.fallback} icon="TextAa" placeholder="Fallback" class="w-24" />
								<Input.Select bind:value={test.avatar.status} placeholder="Status" options={[
									{ label: 'Loaded',	value: 'loaded' },
									{ label: 'Loading',	value: 'loading' },
									{ label: 'Error',	value: 'error' }
								]} />
								<Input.Slider name="size" bind:value={test.avatar.size} min={8} max={64} step={4} class="ml-auto w-32" />
							</Flex>
							<Code code={
`<script>
	import Avatar from '@/Components/UI/Avatar'
</script>

<Avatar
	fallback="${test.avatar.fallback}"
	src="${test.avatar.src}"
	status="${test.avatar.status}"
	class="w-${test.avatar.size}"
/>`							} />
						</Stack>

						<Stack gap={6}>
							<Heading is="h3" as="h5"
								heading="API Reference"
								class="text-neutral"
							/>

							{#snippet headRow()}
								<Table.Head class="max-w-32" sortable={true}>Property</Table.Head>
								<Table.Head class="max-w-32" sortable={true}>Type</Table.Head>
								<Table.Head class="" sortable={true}>Description</Table.Head>
							{/snippet}
			
							{#snippet bodyRow(item)}
								<Table.Cell class="align-top py-2 max-w-32"><code>{item.property}</code></Table.Cell>
								<Table.Cell class="align-top py-2 max-w-32"><pre>{item.type}</pre></Table.Cell>
								<Table.Cell class="align-top py-2">{item.description}<br/><pre class="text-xs text-neutral-soft">Default: {item.default}</pre></Table.Cell>
							{/snippet}

							<Table class="min-w-96 text-sm" {headRow} {bodyRow} data={[
								{ id: 1, property: 'fallback',	type: 'string',	description: 'The text to display in case an image is not provided or fails to load.', default: '—' },
								{ id: 2, property: 'src',		type: 'string',	description: 'The image URL to display in this component.', default: '—' },
								{ id: 3, property: 'status',	type: 'enum',	description: 'The image URL to display in this component.', default: '—' }
							]} />
						</Stack>

					{:else if active === 'badge'}

						<!-- Badge -->

						<PageHeading
							title="Badge"
							subtitle="Badges show notifications, counts, or status information on navigation items and icons."
						/>

						<Stack>
							<Demo name="Badge">
								<Flex align="center" justify="between" class="bg-neutral-softest p-2 rounded w-48">
									<span class="px-1 text-neutral-softest text-sm">List Item</span>
									<Badge {...test.badge} />
								</Flex>
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Number bind:value={test.badge.text}  icon="Hash"           placeholder="Text" />
								<Input.Select bind:value={test.badge.style} icon="CircleHalfTilt" placeholder="Style" options={[
									{ label: 'Hard',	value: 'hard'  },
									{ label: 'Soft',	value: 'soft'  },
									{ label: 'Plain',	value: 'plain' },
								]} />
								<Input.Select bind:value={test.badge.theme} icon="Palette" placeholder="Theme" options={[
									{ label: 'Accent',	value: 'accent'  },
									{ label: 'Neutral',	value: 'neutral' },
									{ label: 'Danger',	value: 'danger'  },
								]} />
								<Input.Switch bind:checked={test.badge.disabled} label="Disabled"	/>
								<Input.Switch bind:checked={test.badge.error}	 label="Error"		/>
							</Flex>
							<Code code={
`<script>
	import Badge from '@/Components/UI/Badge'
</script>

<Badge
	text="${test.badge.text}"
	style="${test.badge.style}"
	theme="${test.badge.theme}"
/>`
							} />
						</Stack>

						<Stack gap={6}>
							<Heading is="h3" as="h5"
								heading="API Reference"
								class="text-neutral"
							/>

							{#snippet headRow()}
								<Table.Head class="max-w-32" sortable={true}>Property</Table.Head>
								<Table.Head class="max-w-32" sortable={true}>Type</Table.Head>
								<Table.Head class="" sortable={true}>Description</Table.Head>
							{/snippet}
			
							{#snippet bodyRow(item)}
								<Table.Cell class="align-top py-2 max-w-32"><code>{item.property}</code></Table.Cell>
								<Table.Cell class="align-top py-2 max-w-32"><pre>{item.type}</pre></Table.Cell>
								<Table.Cell class="align-top py-2">{item.description}<br/><pre class="text-xs text-neutral-soft">Default: {item.default}</pre></Table.Cell>
							{/snippet}

							<Table class="min-w-96 text-sm" {headRow} {bodyRow} data={[
								{ id: 1, property: 'label',	type: 'number',	description: 'The number to display.', default: '—' },
							]} />
						</Stack>

					{:else if active === 'button'}
		
						<!-- Button -->

						<PageHeading
							title="Button"
							subtitle="A component that can switch between a button and an anchor tag based on the `href` prop."
						/>

						<Stack>
							<Demo name="Button">
								<Button {...test.button} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select icon="CircleHalfTilt" name="style" bind:value={test.button.style} placeholder="Style" options={[
									{ label: 'Hard',	value: 'hard' },
									{ label: 'Soft',	value: 'soft' },
									{ label: 'Plain',	value: 'plain' }
								]} />
								<Input.Select icon="Palette" name="theme" bind:value={test.button.theme} placeholder="Theme" options={[
									{ label: 'Accent',	value: 'accent'  },
									{ label: 'Neutral',	value: 'neutral' },
									{ label: 'Danger',	value: 'danger'  }
								]} />
								<Input.Select icon="Resize" name="size" bind:value={test.button.size} placeholder="Size" options={[
									{ label: 'Tiny',	value: 'xs' },
									{ label: 'Small',	value: 'sm' },
									{ label: 'Medium',	value: 'md' },
									{ label: 'Large',	value: 'lg' },
									{ label: 'Huge',	value: 'xl' }
								]} />
								<Input.Select name="icon" bind:value={test.button.icon} placeholder="Icon" options={[
									{ value: '',		label: 'None' },
									{ value: 'At',		label: 'At',   		icon: 'At' 			},
									{ value: 'Books',	label: 'Books',		icon: 'Books' 		},
									{ value: 'Chats',	label: 'Chats',		icon: 'Chats' 		},
									{ value: 'Compass',	label: 'Compass',	icon: 'Compass' 	},
									{ value: 'DiamondsFour',	label: 'DiamondsFour',	icon: 'DiamondsFour' 	},
									{ value: 'Eye',		label: 'Eye',		icon: 'Eye' 		},
									{ value: 'Funnel',		label: 'Funnel',		icon: 'Funnel' 		},
									{ value: 'List',		label: 'List',		icon: 'List' 		},
								]} />
								<Input.Text icon="TextAa" bind:value={test.button.text} placeholder="Text" />
							</Flex>
							<Code code={
`<script>
	import Button from '@/Components/UI/Button'
</script>

<Button
	icon="${test.button.icon}"
	size="${test.button.size}"
	text="${test.button.text}"
	onclick={() => {}}
/>`							} />
						</Stack>
		
						<Stack gap={6}>
							<Heading is="h3" as="h5"
								heading="API Reference"
								class="text-neutral"
							/>

							{#snippet headRow()}
								<Table.Head class="max-w-32" sortable={true}>Property</Table.Head>
								<Table.Head class="max-w-32" sortable={true}>Type</Table.Head>
								<Table.Head class="" sortable={true}>Description</Table.Head>
							{/snippet}
			
							{#snippet bodyRow(item)}
								<Table.Cell class="align-top py-2 max-w-32"><code>{item.property}</code></Table.Cell>
								<Table.Cell class="align-top py-2 max-w-32"><pre>{item.type}</pre></Table.Cell>
								<Table.Cell class="align-top py-2">{item.description}<br/><pre class="text-xs text-neutral-soft">Default: {item.default}</pre></Table.Cell>
							{/snippet}

							<Table class="min-w-96 text-sm" {headRow} {bodyRow} data={[
								{ id: 1, property: 'disabled', type: 'boolean',  default: false,     description: 'Whether or not the button is disabled. When disabled, the button cannot be interacted with.' },
								{ id: 2, property: 'href',     type: 'string',   default: null,      description: 'An optional prop that when passed converts the button into an anchor tag.' },
								{ id: 3, property: 'icon',     type: 'enum',     default: null,      description: 'The name of a Phosphor icon. You can also provide an array containing up to 3 values, representing the icon\'s name, size, and weight.' },
								{ id: 4, property: 'label',    type: 'string',   default: null,      description: 'The text label on the button.' },
								{ id: 5, property: 'loading',  type: 'boolean',  default: false,     description: 'Whether or not the button is loading. If the button is loading, it will display a loading icon, and be unavailable to click until its process is resolved.' },
								{ id: 6, property: 'onclick',  type: 'function', default: null,      description: 'A function for the button to perform when clicked. If <code>href</code> is provided, then this is not necessary.' },
								{ id: 7, property: 'size',     type: 'enum',     default: 'md',      description: 'The style preset for this button.' },
								{ id: 8, property: 'style',    type: 'enum',     default: 'plain',   description: 'The size code for this button.' },
								{ id: 9, property: 'theme',    type: 'enum',     default: 'neutral', description: 'The theme for this button. This should be combined with the <code>style</code> to establish the button\'s semantic meaning.' },
							]} />
						</Stack>

					{:else if active === 'checkbox'}

						<!-- Checkbox -->

						<PageHeading
							title="Checkbox"
							subtitle="A user input with a boolean type."
						/>

						<Stack>
							<Demo name="Checkbox">
								<Input.Checkbox bind:checked={test.checkbox.checked} labelText={test.checkbox.label} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Text bind:value={test.checkbox.label} icon="TextAa" />
								<Input.Switch bind:checked={test.checkbox.checked} label="Checked" labelText="Checked" />
							</Flex>
							<Code code={
`<script>
	import Input from '@/Components/UI/Input'
</script>

<Input.Checkbox
	bind:checked="${test.checkbox.checked}"
	labelText="${test.checkbox.label}"
/>`
							} />
						</Stack>

					{:else if active === 'chip'}

						<!-- Chip -->

						<PageHeading
							title="Chip"
							subtitle="Chips are compact elements that can represent an input, attribute, or action."
						/>

						<Stack>
							<Demo name="Chip">
								<Chip {...test.chip} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select bind:value={test.chip.icon} placeholder="Icon" options={[
									{ value: '',		label: 'None',   	icon: null 			},
									{ value: 'At',		label: 'At',   		icon: 'At' 			},
									{ value: 'Books',	label: 'Books',		icon: 'Books' 		},
									{ value: 'Chats',	label: 'Chats',		icon: 'Chats' 		},
									{ value: 'Compass',	label: 'Compass',	icon: 'Compass' 	},
									{ value: 'Eye',		label: 'Eye',		icon: 'Eye' 		},
									{ value: 'Funnel',	label: 'Funnel',	icon: 'Funnel' 		},
								]} />
								<Input.Text  bind:value={test.chip.text} icon="TextAa" placeholder="Text" />
								<Input.Select bind:value={test.chip.state} placeholder="Default" options={[
									{ label: 'Default',	value: '' },
									{ label: 'Active',  value: 'active' }
								]} />
							</Flex>
							<Code code={
`<script>
	import Chip from '@/Components/UI/Chip'
</script>

<Chip
	state="${test.chip.state}"
	text="${test.chip.text}"
/>`
							} />
						</Stack>
						
						<!-- <Stack>
							<Heading is="h2" as="h3">Chip</Heading>
							<p class="text-neutral-softer text-lg">Chips are compact elements that can represent an input, attribute, or action.</p>
						</Stack>

						<Stack>
							<Flex gap={1.5} class="mb-1.5">
								<Input type="text" name="text" bind:value={test.chip.text} placeholder="Text" />
								<Input type="select" name="state" bind:value={test.chip.state} placeholder="State" options={[
									{ label: 'Default',	value: '' },
									{ label: 'Active',  value: 'active' }
								]} />
							</Flex>
							<Flex align="center" justify="center" gap={6} class="bg-neutral-softest relative p-12 rounded-t w-full">
								<Chip {...test.chip} />
							</Flex>
						</Stack> -->

					{:else if active === 'dropdown'}

						<!-- Dropdown -->

						<PageHeading
							title="Dropdown"
							subtitle="Displays a menu of items that users can select from when triggered."
						/>

						<Stack>
							<Demo name="Dropdown">
								<Dropdown bind:value={test.dropdown.value} {...test.dropdown} options={[
									{ label: 'Value 1', value: 'dropdown1' },
									{ label: 'Value 2', value: 'dropdown2' },
									{ label: 'Value 3', value: 'dropdown3', options: [
										{ label: 'Value 3.1', value: 'dropdown3.1' },
										{ label: 'Value 3.2', value: 'dropdown3.2' },
										{ label: 'Value 3.3', value: 'dropdown3.3' }
									] },
									{ label: 'Value 4', value: 'dropdown4' },
									{ label: 'Value 5', value: 'dropdown5', options: [
										{ label: 'Value 5.1', value: 'dropdown5.1' },
										{ label: 'Value 5.2', value: 'dropdown5.2' },
										{ label: 'Value 5.3', value: 'dropdown5.3' }
									] },
									{ label: 'Value 6', value: 'dropdown6' },
								]} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select bind:value={test.dropdown.icon} placeholder="Icon" options={[
									{ value: '',		label: 'None',   	icon: null 			},
									{ value: 'At',		label: 'At',   		icon: 'At' 			},
									{ value: 'Books',	label: 'Books',		icon: 'Books' 		},
									{ value: 'Chats',	label: 'Chats',		icon: 'Chats' 		},
									{ value: 'Compass',	label: 'Compass',	icon: 'Compass' 	},
									{ value: 'Eye',		label: 'Eye',		icon: 'Eye' 		},
									{ value: 'Funnel',	label: 'Funnel',	icon: 'Funnel' 		},
								]} />
								<Input.Text bind:value={test.dropdown.label} icon="TextAa" placeholder="Text" />
								<Input.Text bind:value={test.dropdown.placeholder} placeholder="Placeholder" />
								<Input.Select bind:value={test.dropdown.size} icon="Resize" placeholder="Size" class="ml-auto" options={[
									{ label: 'Tiny',	value: 'xs' },
									{ label: 'Small',	value: 'sm' },
									{ label: 'Medium',	value: 'md' },
									{ label: 'Large',	value: 'lg' },
									{ label: 'Huge',	value: 'xl' }
								]} />
							</Flex>
							<Code code={
`<script>
	import Dropdown from '@/Components/UI/Dropdown'
</script>

<Dropdown
	icon="${test.dropdown.icon}"
	label="${test.dropdown.label}"
	placeholder="${test.dropdown.placeholder}"
	bind:value="${test.dropdown.value}"
/>`
							} />
						</Stack>

					{:else if active === 'entity'}
		
						<!-- Entity -->

						<PageHeading
							title="Entity"
							subtitle="The Entity component displays any entity in the project with a range of different formats."
						/>

						<Stack>
							<Demo name="Entity" align="top" class="max-h-96">
								<Grid cols={4} align="start" justify="start" gap={1} class="max-h-full w-full">
									{#each characters?.items?.slice(0,test.entity.count) as character}
										<Entity entity={character} layout={test.entity.layout} size={test.entity.size} />
									{/each}
								</Grid>
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select bind:value={test.entity.size} placeholder="Size" options={[
									{ label: 'Tiny',	value: 'xs' },
									{ label: 'Small',	value: 'sm' },
									{ label: 'Medium',	value: 'md' },
									{ label: 'Large',	value: 'lg' },
									{ label: 'Huge',	value: 'xl' }
								]} />
								<Input.Select bind:value={test.entity.layout} placeholder="Layout" options={[
									{ label: 'Inline',	value: 'inline' },
									{ label: 'Stack',	value: 'stack'  }
								]} />
								<Input.Slider bind:value={test.entity.count} min={8} max={24} step={4} class="ml-auto" />
							</Flex>
							<Code code={
`<Entity
	entity={character}
	layout="{${test.entity.layout}"
	size={${test.entity.size}}
/>`
							} />
						</Stack>

						<!-- <Stack>
							<Heading is="h2" as="h3">Entity</Heading>
							<p class="text-neutral-softer text-lg">The Entity component displays any entity in the project with a range of different formats.</p>
						</Stack> -->

						<!-- <Stack>
							<Flex gap={1.5} class="my-1.5">
								<Input type="select" name="size" bind:value={test.entity.size} placeholder="Size" options={[
									{ label: 'Tiny',	value: 'xs' },
									{ label: 'Small',	value: 'sm' },
									{ label: 'Medium',	value: 'md' },
									{ label: 'Large',	value: 'lg' },
									{ label: 'Huge',	value: 'xl' }
								]} />
								<Input type="slider" name="text" bind:value={test.entity.count} min={8} max={24} step={4} class="w-36" />
							</Flex>
							
						</Stack> -->

						<Stack gap={6}>
							<Heading is="h3" as="h5"
								heading="API Reference"
								class="text-neutral"
							/>
							A table showing the properties, types, and description of each property, along with its default value if applicable.
							<table class="align-top text-sm">
								<thead>
									<tr>
										<th class="text-left text-neutral-softer">Property</th>
										<th class="text-left text-neutral-softer">Type</th>
										<th class="text-left text-neutral-softer">Description</th>
									</tr>
								</thead>
								<tbody>
									<tr class="border-t">
										<td class="align-top p-3 pl-0 min-w-32"><code>entity</code></td>
										<td class="align-top p-3 pl-0 min-w-32"><pre>Entity</pre></td>
										<td class="align-top p-3 pl-0">Description.
											<pre class="mt-3 text-xs text-neutral-soft">Default: &mdash;</pre>
										</td>
									</tr>
									<tr class="border-t">
										<td class="align-top p-3 pl-0 min-w-32"><code>layout</code></td>
										<td class="align-top p-3 pl-0 min-w-32">
											<pre>enum:</pre>
											<pre class="text-neutral-soft text-xs">'inline'|'stack'</pre>
										</td>
										<td class="align-top p-3 pl-0">Description.
											<pre class="mt-3 text-xs text-neutral-soft">Default: "inline"</pre>
										</td>
									</tr>
									<tr class="border-t">
										<td class="align-top p-3 pl-0 min-w-32"><code>size</code></td>
										<td class="align-top p-3 pl-0 min-w-32">
											<pre>enum:</pre>
											<pre class="text-neutral-soft text-xs">'xs'|'sm'|'md'|'lg'|'xl'</pre>
										</td>
										<td class="align-top p-3 pl-0">Description.
											<pre class="mt-3 text-xs text-neutral-soft">Default: "md"</pre>
										</td>
									</tr>
								</tbody>
							</table>
						</Stack>

					{:else if active === 'field'}

						<!-- Field -->

						<PageHeading
							title="Field"
							subtitle="The Field component."
						/>

						<Stack>
							<Demo name="Field">
								<!-- <Field {...test.field} /> -->
							</Demo>
							<!-- <Flex gap={1.5} class="my-1.5">
								<Input type="select" name="size" bind:value={test.entity.size} placeholder="Size" options={[
									{ label: 'Tiny',	value: 'xs' },
									{ label: 'Small',	value: 'sm' },
									{ label: 'Medium',	value: 'md' },
									{ label: 'Large',	value: 'lg' },
									{ label: 'Huge',	value: 'xl' }
								]} />
								<Input type="slider" name="text" bind:value={test.entity.count} min={8} max={24} step={4} class="w-36" />
							</Flex> -->
							<Code code={
`<Field

/>`
							} />
						</Stack>

					{:else if active === 'icon'}

						<!-- Icon -->

						<PageHeading
							title="Icon"
							subtitle="Represents an icon."
						/>

						<Stack>
							<Demo name="Icon">
								<Icon {...test.icon} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select bind:value={test.icon.size} icon="Resize" placeholder="Size" options={[
									{ label: 'Tiny',	value: 'xs' },
									{ label: 'Small',	value: 'sm' },
									{ label: 'Medium',	value: 'md' },
									{ label: 'Large',	value: 'lg' },
									{ label: 'Huge',	value: 'xl' }
								]} />
								<Input.Select bind:value={test.icon.weight} icon="Barbell" placeholder="Weight" options={[
									{ label: 'Thin',	value: 'thin' },
									{ label: 'Light',	value: 'light' },
									{ label: 'Regular',	value: 'regular' },
									{ label: 'Bold',	value: 'bold' },
									{ label: 'Fill',	value: 'fill' },
									{ label: 'Duotone',	value: 'duotone' }
								]} />
								<!-- <Input.Text bind:value={test.icon.name} icon="TextAa" placeholder="Name" /> -->
								<!-- <Input.Slider bind:value={test.icon.size} icon="Resize" min={8} max={64} step={4} class="ml-auto" /> -->
							</Flex>
							<Code code={
`<Icon
	name="${test.icon.name}"
	size="${test.icon.size}"
	weight="${test.icon.weight}"
/>`
							} />
						</Stack>


					{:else if active === 'input'}

						<!-- Input -->

						<PageHeading
							title="Input"
							subtitle="Enables users to input a value, usually to submit to a server via a form."
						/>
						
						<Stack>
							<Demo name="Input">
								<Input {...test.input} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select bind:value={test.input.type} icon="Textbox" placeholder="Type" options={[
									{ label: 'Number', value: 'number' },
									{ label: 'Select', value: 'select' },
									{ label: 'Text',   value: 'text' },
								]} />
								<Input.Select bind:value={test.input.size} icon="Resize" placeholder="Size" options={[
									{ label: 'Tiny',	value: 'xs' },
									{ label: 'Small',	value: 'sm' },
									{ label: 'Medium',	value: 'md' },
									{ label: 'Large',	value: 'lg' },
									{ label: 'Huge',	value: 'xl' }
								]} />
								<Input.Select bind:value={test.input.icon} placeholder="Icon" options={[
									{ value: 'At',		label: 'At',   		icon: 'At' 			},
									{ value: 'Books',	label: 'Books',		icon: 'Books' 		},
									{ value: 'Chats',	label: 'Chats',		icon: 'Chats' 		},
									{ value: 'Compass',	label: 'Compass',	icon: 'Compass' 	},
									{ value: 'DiamondsFour',	label: 'DiamondsFour',	icon: 'DiamondsFour' 	},
									{ value: 'Eye',		label: 'Eye',		icon: 'Eye' 		},
									{ value: 'Funnel',		label: 'Funnel',		icon: 'Funnel' 		},
								]} />
								<Input.Text bind:value={test.input.placeholder} placeholder="Placeholder" />
							</Flex>
							<Code code={
`<Input name={INPUT_NAME}
	icon="${test.input.icon}"
	placeholder="${test.input.placeholder}"
	size="${test.input.size}"
	bind:value={INPUT_VALUE}
/>`
							} />
						</Stack>

					{:else if active === 'media'}

						<PageHeading
							title="Media"
							subtitle="Represents a piece of media, usually an image."
						/>

						<Stack>
							<Demo name="Media">
								media
							</Demo>
							<Flex gap={1.5} class="my-1.5">
							</Flex>
							<Code code={
``
							} />
						</Stack>

					{:else if active === 'panzoom'}
		
						<!-- PanZoom -->

						<PageHeading
							title="PanZoom"
							subtitle="Allows the user to easily navigate around an image while zoomed in."
						/>

						<Stack>
							<Demo name="PanZoom">
								<PanZoom debug constrain class="flex items-center justify-center h-96 mt-3 rounded-lg">
									<img src="/img/world-4.png" alt="world map" />
								</PanZoom>
							</Demo>
							<Code code={
`<PanZoom />`
							} />
						</Stack>

					{:else if active === 'popover'}

						<PageHeading
							title="Popover"
							subtitle="Displays additional information on hover or click."
						/>

						<Stack>
							<Demo name="Popover">
								popover
							</Demo>
							<Flex gap={1.5} class="my-1.5">
							</Flex>
							<Code code={
``
							} />
						</Stack>

					{:else if active === 'radio'}

						<PageHeading
							title="Radio Button"
							subtitle="Groups multiple radio items under a common name for form submission."
						/>

						<Stack>
							<Demo name="Radio">
								<Input.Radio bind:value={test.radio.value} options={[
									{ label: 'Radio #1', value: 'radio1' },
									{ label: 'Radio #2', value: 'radio2' },
									{ label: 'Radio #3', value: 'radio3', disabled: true },
								]} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
							</Flex>
							<Code code={
`<script>
	import Input from '@/Components/UI/Input'
</script>

<Input.Radio
	type="radio"
	bind:value="${test.radio.value}"
	options={[
		{ label: 'Radio #1', value: 'radio1' },
		{ label: 'Radio #2', value: 'radio2' },
		{ label: 'Radio #3', value: 'radio3', disabled: true }
	]}

/>`
							} />
						</Stack>

					{:else if active === 'reorderable'}

						<PageHeading
							title="Reorderable"
							subtitle="Displays additional information on hover or click."
						/>

						<Stack>
							<Demo name="Reorderable">
								<ReorderableList items={[
									{ name: 'Item #1' },
									{ name: 'Item #2' },
									{ name: 'Item #3' }
								]}>
									{#snippet itemTemplate(item)}
										<Inline gap={1.5} class="bg-neutral-softest mb-0.5 min-w-40 p-1.5 rounded text-sm">
											<DragHandle item={item} size="sm" />
											<span>{item.name}</span>
										</Inline>
									{/snippet}
								</ReorderableList>
							</Demo>
							<Flex gap={1.5} class="my-1.5">
							</Flex>
							<Code code={
`<ReorderableList items={ITEM_DATA}>
	{#snippet itemTemplate(item)}
		<div>
			<DragHandle item={item} size="sm" />
			<span>{item.name}</span>
		</div>
	{/snippet}
</ReorderableList>`
							} />
						</Stack>

					{:else if active === 'select'}

						<PageHeading
							title="Select"
							subtitle="Enables users to pick from a list of options displayed in a dropdown."
						/>

						<Stack>
							<Demo name="Select">
								<Input.Select {...test.select} options={[
									{ label: 'Value 1', value: 'dropdown1' },
									{ label: 'Value 2', value: 'dropdown2' },
									{ label: 'Value 3', value: 'dropdown3', options: [
										{ label: 'Value 3.1', value: 'dropdown3.1' },
										{ label: 'Value 3.2', value: 'dropdown3.2' },
										{ label: 'Value 3.3', value: 'dropdown3.3' }
									] },
									{ label: 'Value 4', value: 'dropdown4' },
									{ label: 'Value 5', value: 'dropdown5', options: [
										{ label: 'Value 5.1', value: 'dropdown5.1' },
										{ label: 'Value 5.2', value: 'dropdown5.2' },
										{ label: 'Value 5.3', value: 'dropdown5.3' }
									] },
									{ label: 'Value 6', value: 'dropdown6' },
								]} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select bind:value={test.select.type} icon="Textbox" placeholder="Type" options={[
									{ label: 'Number', value: 'number' },
									{ label: 'Select', value: 'select' },
									{ label: 'Text',   value: 'text' },
								]} />
								<Input.Select bind:value={test.select.icon} placeholder="Icon" options={[
									{ value: 'At',		label: 'At',   		icon: 'At' 			},
									{ value: 'Books',	label: 'Books',		icon: 'Books' 		},
									{ value: 'Chats',	label: 'Chats',		icon: 'Chats' 		},
									{ value: 'Compass',	label: 'Compass',	icon: 'Compass' 	},
									{ value: 'DiamondsFour', label: 'DiamondsFour',	icon: 'DiamondsFour' 	},
									{ value: 'Eye',		label: 'Eye',		icon: 'Eye' 		},
									{ value: 'Funnel',	label: 'Funnel',	icon: 'Funnel' 		},
								]} />
								<Input.Text bind:value={test.select.placeholder} placeholder="Placeholder" />
								<Input.Select bind:value={test.select.size} icon="Resize" placeholder="Size" options={[
									{ label: 'Tiny',	value: 'xs' },
									{ label: 'Small',	value: 'sm' },
									{ label: 'Medium',	value: 'md' },
									{ label: 'Large',	value: 'lg' },
									{ label: 'Huge',	value: 'xl' }
								]} />
							</Flex>
							<Code code={
`<Select
	icon="${test.select.icon}"
	name="${test.select.name}"
	placeholder="${test.select.placeholder}"
	size="${test.select.size}"
	bind:value="${test.select.value}"
/>`
							} />
						</Stack>

					{:else if active === 'slider'}

						<PageHeading
							title="Slider"
							subtitle="Enables users to select a value from a continuous range."
						/>

						<Stack>
							<Demo name="Slider">
								<Input.Slider {...test.slider} bind:value={test.slider.value} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select bind:value={test.slider.style} placeholder="Style" options={[
									{ label: 'Fill',	value: 'fill'  },
									{ label: 'Empty',	value: 'empty' },
									{ label: 'Both',	value: 'both'  },
									{ label: 'None',	value: 'none'  }
								]} />
							</Flex>
							<Code code={
`<Slider
	min="${test.slider.min}"
	max="${test.slider.max}"
	name="${test.slider.name}"
	size="${test.slider.size}"
	ticks="${test.slider.ticks}"
	bind:value="${test.slider.value}"
/>`
							} />
						</Stack>

					{:else if active === 'switch'}

						<PageHeading
							title="Switch"
							subtitle="A toggle control that allows users to switch between 'on' and 'off' states."
						/>

						<Stack>
							<Demo name="Switch">
								<Input.Switch {...test.switch} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
							</Flex>
							<Code code={
`<Switch
	bind:checked="${test.switch.value}"
	disabled="${test.switch.disabled}"
	name="${test.switch.name}"
/>`
							} />
						</Stack>

					

					{:else if active === 'table'}

						<PageHeading
							title="Table"
							subtitle="Represents multi-dimensional data in a simple digestable way."
						/>

						<Stack>
							<Demo name="Table">
								{#snippet headRow()}
									<Table.Head sortable={true}>Name</Table.Head>
									<Table.Head sortable={true}>Role</Table.Head>
									<Table.Head sortable={true}>Color</Table.Head>
								{/snippet}
				
								{#snippet bodyRow(item)}
									<Table.Cell>{item.name}</Table.Cell>
									<Table.Cell>{item.role}</Table.Cell>
									<Table.Cell>{item.color}</Table.Cell>
								{/snippet}
				
								<Table class="min-w-96" {headRow} {bodyRow} data={[
									{ id: 1, name: 'Kirk', role: 'Captain', color: 'Yellow' },
									{ id: 2, name: 'Spock', role: 'Lieutenant', color: 'Blue' },
									{ id: 3, name: 'McCoy', role: 'Doctor', color: 'Blue' }
								]} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">

							</Flex>
							<Code code={
`<script>
	import Table from '@/Components/UI/Table'
</script>

<Table
	data={TABLE_DATA}
	headRow={headRow}
	bodyRow={bodyRow}
	sortBy="${test.table.sortBy}"
/>`
							} />
						</Stack>

					{:else if active === 'tabs'}

						<PageHeading
							title="Tabs"
							subtitle="Organizes content into tabbed sections."
						/>

						<Stack>
							<Demo name="Tabs">
								<Tabs class="min-w-96" value={test.tabs.value}>
									<Tabs.List>
										<Tabs.Trigger value="tab_1">Tab 1</Tabs.Trigger>
										<Tabs.Trigger value="tab_2">Tab 2</Tabs.Trigger>
										<Tabs.Trigger value="tab_3">Tab 3</Tabs.Trigger>
									</Tabs.List>
									<Tabs.Content class="bg-neutral-softest p-3 rounded" value="tab_1">
										This is the content of Tab 1
									</Tabs.Content>
									<Tabs.Content class="bg-neutral-softest p-3 rounded" value="tab_2">
										This is the content of Tab 2
									</Tabs.Content>
									<Tabs.Content class="bg-neutral-softest p-3 rounded" value="tab_3">
										This is the content of Tab 3
									</Tabs.Content>
								</Tabs>
							</Demo>
							<Flex gap={1.5} class="my-1.5">
							</Flex>
							<Code code={
`<Tabs value="${test.tabs.value}">
	<Tabs.List>
		<Tabs.Trigger value="tab_1">Tab 1</Tabs.Trigger>
		<Tabs.Trigger value="tab_2">Tab 2</Tabs.Trigger>
		<Tabs.Trigger value="tab_3">Tab 3</Tabs.Trigger>
	</Tabs.List>
	<Tabs.Content value="tab_1">This is the content of Tab 1</Tabs.Content>
	<Tabs.Content value="tab_2">This is the content of Tab 2</Tabs.Content>
	<Tabs.Content value="tab_3">This is the content of Tab 3</Tabs.Content>
</Tabs>`
							} />
						</Stack>

					{:else if active === 'tag'}

						<PageHeading
							title="Tag"
							subtitle="A toggle control that allows users to switch between 'on' and 'off' states."
						/>

						<Stack>
							<Demo name="Tag">
								<Tag {...test.tag} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select bind:value={test.tag.size} icon="Resize" placeholder="Size" options={[
									{ label: 'Tiny',	value: 'xs' },
									{ label: 'Small',	value: 'sm' },
									{ label: 'Medium',	value: 'md' },
									{ label: 'Large',	value: 'lg' },
									{ label: 'Huge',	value: 'xl' }
								]} />
								<Input.Select bind:value={test.tag.style} icon="CircleHalfTilt" placeholder="Style" options={[
									{ label: 'Hard',	value: 'hard' },
									{ label: 'Soft',	value: 'soft' },
									{ label: 'Plain',	value: 'plain' }
								]} />
								<Input.Select bind:value={test.tag.theme} icon="Palette" placeholder="Theme" options={[
									{ label: 'Accent',	value: 'accent'  },
									{ label: 'Neutral',	value: 'neutral' },
									{ label: 'Danger',	value: 'danger'  }
								]} />
								<Input.Text bind:value={test.tag.text} icon="TextAa" placeholder="Text" />
							</Flex>
							<Code code={
`<Tag
	style="${test.tag.style}"
	theme="${test.tag.theme}"
	text="${test.tag.text}"
/>`
							} />
						</Stack>

					{:else if active === 'thumbnail'}
		
						<!-- Thumbnail -->

						<PageHeading
							title="Thumbnail"
							subtitle="Thumbnails are used to display images in a compact format."
						/>

						<Stack>
							<Demo name="Thumbnail">
								<Thumbnail {...test.thumbnail} class="w-{test.thumbnail.size}" />
							</Demo>
							<Flex gap={1.5} class="my-1.5">
								<Input.Select bind:value={test.thumbnail.src} icon="ImageSquare" placeholder="Image URL..." options={[
									{ label: 'Blue',   value: '/img/avatar-1.png' },
									{ label: 'Green',  value: '/img/avatar-2.png' },
									{ label: 'Pink',   value: '/img/avatar-3.png' },
									{ label: 'Red',    value: '/img/avatar-4.png' },
									{ label: 'Orange', value: '/img/avatar-5.png' },
								]} />
								<Input.Text   bind:value={test.thumbnail.alt} icon="TextAa" placeholder="Alt text..." />
								<Input.Slider bind:value={test.thumbnail.size} min={4} max={64} step={4} />
							</Flex>
							<Code code={
`<Thumbnail
	src="${test.thumbnail.src}"
	alt="${test.thumbnail.alt}"
	class="w-${test.thumbnail.size}"
/>`
							} />
						</Stack>
		
						<!-- <Stack gap={1.5} class="mb-12">
							<Heading is="h3" as="h6">Thumbnail</Heading>
							<p class="max-w-[72ch]">Thumbnails are used to display images in a compact format. They can be used to represent users, products, or any other visual content.</p>
							<Inline gap={6} class="mt-3">
								<Thumbnail class="w-20" src="/img/avatar.jpg" alt="User" />
								<Thumbnail class="w-16" src="/img/avatar.jpg" alt="User" />
								<Thumbnail class="w-14" src="/img/avatar.jpg" alt="User" />
								<Thumbnail class="w-12" src="/img/avatar.jpg" alt="User" />
								<Thumbnail class="w-10" src="/img/avatar.jpg" alt="User" />
								<Thumbnail class="w-9" src="/img/avatar.jpg" alt="User" />
								<Thumbnail class="w-8" src="/img/avatar.jpg" alt="User" />
							</Inline>
						</Stack> -->

					{:else if active === 'toast'}

						<PageHeading
							title="Toast"
							subtitle="A simple alert to let the user know that an operation has completed."
						/>

						<Stack>
							<Demo name="Toast">
								<Toast  {...test.toast} />
							</Demo>
							<Flex gap={1.5} class="my-1.5">

							</Flex>
							<Code code={
`<Toast
	icon="${test.toast.icon}"
	message="${test.toast.message}"
	theme="${test.toast.theme}"
/>`
							} />
						</Stack>

					{:else if active === 'tooltip'}

						<!-- Tooltip -->

						<PageHeading
							title="Tooltip"
							subtitle="Displays supplementary information when users hover over or interact with an element."
						/>

						<Stack>
							<Demo name="Tooltip">
								<Tooltip>
									Tooltip
									{#snippet content()}
										<span>{test.tooltip.text}</span>
									{/snippet}
								</Tooltip>
							</Demo>
							<Flex gap={1.5} class="my-1.5">

							</Flex>
							<Code code={
`<Tooltip>
	Tooltip
</Tooltip>`
							} />
						</Stack>
							
					{:else if active === 'typography'}
		
						<Heading is="h2" as="h3"
							heading="Typography"
							class="mt-12 mb-12"
						/>
		
						<!-- Headings -->
		
						<!-- <h2 class="font-style-h5 mb-2 text-slate-400">Headings</h2> -->
						<div class="flex flex-col items-start justify-start gap-4 mb-8">
							<h1 class="font-style-h1">Heading 1</h1>
							<h2 class="font-style-h2">Heading 2</h2>
							<h3 class="font-style-h3">Heading 3</h3>
							<h4 class="font-style-h4">Heading 4</h4>
							<h5 class="font-style-h5">Heading 5</h5>
							<h6 class="font-style-h6">Heading 6</h6>
						</div>
		
						<h2 class="font-style-h5 mb-2 text-slate-400">Body</h2>
						<div class="flex flex-col items-start justify-start gap-4 mb-8">
		
							<p  class="font-style-large">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							<p  class="font-style-regular">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							<p  class="font-style-small">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							<p  class="font-style-tiny">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		
							<p  class="font-style-button">Button</p>
							<p  class="font-style-label">Label</p>
							<p  class="font-style-input">Input</p>
							<p  class="font-style-placeholder">Placeholder</p>
							
						</div>
		
						<div class="grid grid-cols-1"></div>
						<div class="grid grid-cols-2"></div>
						<div class="grid grid-cols-3"></div>
						<div class="grid grid-cols-4"></div>
						<div class="grid grid-cols-5"></div>
						<div class="grid grid-cols-6"></div>
						<div class="grid grid-cols-7"></div>
						<div class="grid grid-cols-8"></div>
						<div class="grid grid-cols-9"></div>
						<div class="grid grid-cols-10"></div>
						<div class="grid grid-cols-11"></div>
						<div class="grid grid-cols-12"></div>
			
					{:else if active === 'upload'}

						<PageHeading
							title="Upload"
							subtitle="Enables the user to upload a file from their own computer."
						/>

						<Stack>
							<Demo name="Upload">
								<!-- <Upload {...test.upload} bind:value={test.upload.value} /> -->
								 <!-- <Input type="file"
									id="upload"
									class="w-full"
									icon="UploadSimple"
									placeholder="Upload an image"
								/> -->
							</Demo>
							<Flex gap={1.5} class="my-1.5">
							</Flex>
							<Code code={
`<Upload

/>`
							} />
						</Stack>

					{/if}

				</Stack>
			</Flex>
		</Section>
	{/snippet}

</AuthenticatedLayout>
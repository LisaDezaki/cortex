<script>

	import { page, useForm } from '@inertiajs/svelte'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'

	import {
		Form, Inline,
		PanZoom, Stack,
		UploadContext,
		UploadPreview,
		UploadTrigger
	 } from '@/Components/Core'

	import Avatar      from '@/Components/UI/Avatar.svelte'
	import Badge       from '@/Components/UI/Badge.svelte'
	import Button      from '@/Components/UI/Button.svelte'
	import Checkbox    from '@/Components/UI/Inputs/Checkbox.svelte'
	import Dropdown    from '@/Components/UI/Dropdown.svelte'
	import Field       from '@/Components/UI/Field.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'
	import PageHeader  from '@/Components/UI/PageHeader.svelte'
	import Section     from '@/Components/UI/Section.svelte'
	import Table       from '@/Components/UI/Table'
	import Thumbnail   from '@/Components/UI/Thumbnail.svelte'

	let activeTab = $state('general')

	const activeProject = $page.props.activeProject?.data

	const form = useForm({
		input: '',
		text: '',
		icon: '',
		email: '',
		password: '',
		number: null,
		url: '',
		search: '',
		textarea: '',

		select: '',
		select_icons: '',
		select_images: '',
		select_multi_1: [],
		select_multi_2: [],
		select_multi_3: [],

		upload: null,
		upload_multi: [],
		image: null,
		file: null,

		slider_1: 50,
		slider_2: 50,
		slider_3: 50,
		slider_4: 50,
		slider_5: [25,75],
		slider_6: [25,75],
		slider_7: [25,75],
		slider_8: [25,75],

		slider_steps: 30,
		slider_ticks: 70,
		slider_double: [20, 80],
		slider_multiple: [20, 50, 80],
		slider_disabled: 50,

		checkbox_1: true,
		checkbox_2: false,
		checkbox_3: false,

		checkboxes: ['checkbox1'],
		radio: 'radio1',
		switch: false,
		
	})
	
</script>

<svelte:head>
    <title>{activeProject.name || 'Dashboard'}</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Tests"
			tabs={[
				{ icon: 'DiamondsFour',	label: 'General',		active: activeTab === 'general',	onclick: () => activeTab = 'general'	},
				{ icon: 'Textbox',		label: 'Forms',			active: activeTab === 'forms',		onclick: () => activeTab = 'forms'		},
				{ icon: 'Table',		label: 'Table',			active: activeTab === 'table',		onclick: () => activeTab = 'table'		},
				{ icon: 'TextAa',		label: 'Typography',	active: activeTab === 'typography',	onclick: () => activeTab = 'typography'	}
			]}
		/>
	{/snippet}

	{#snippet article()}
		<Section size="5xl" class="overflow-y-auto">

				{#if activeTab === 'general'}

					<Heading is="h2" as="h4"
						heading="General Components"
						class="mt-12 mb-12"
					/>
					
					<!-- Avatar -->

					<Stack gap={1.5} class="mb-12">
						<Heading is="h3" as="h6">Avatar</Heading>
						<p class="max-w-[72ch]">Avatars are used to represent users or entities in your application. They can be images or initials, and can be used in various sizes.</p>
						<Inline gap={6} class="mt-3">
							<Avatar class="w-20" src="/img/avatar.jpg" alt="@username" fallback="AB" />
							<Avatar class="w-16" src="/img/avatar.png" alt="@username" fallback="CD" />
							<Avatar class="w-12" src="/img/avatar.jpg" alt="@username" fallback="EF" />
							<Avatar class="w-8"  src="/img/avatar.png" alt="@username" fallback="GH" />
						</Inline>
					</Stack>

					<!-- Badge -->

					<Stack gap={1.5} class="mb-12">
						<Heading is="h3" as="h6">Badge</Heading>
						<p class="max-w-[72ch]">The Badge component is used to display small counts or notifications. It can be used in various contexts, such as with buttons or avatars.</p>
						<Inline gap={6} class="mt-3">
							<Badge label="9" primary />
							<Badge label="99" secondary />
							<Badge label="999" disabled />
							<Badge />
						</Inline>
					</Stack>

					<!-- Button -->

					<Stack gap={1.5} class="mb-12">
						<Heading is="h3" as="h6">Button</Heading>
						<p class="max-w-[72ch]">Buttons are used to trigger actions in your application. They can be styled in various ways, such as primary, secondary, danger, and disabled.</p>
						<Inline gap={6} class="mt-3">
							<Button style="hard" theme="accent"  icon="Check" label="Primary"    />
							<Button style="hard" theme="neutral" icon="List"  label="Secondary"  />
							<Button style="hard" theme="danger"  icon="Trash" label="Danger"     />
							<Button style="hard" theme="accent"  icon="Check" />
							<Button style="hard" theme="neutral" icon="List" />
							<Button style="hard" theme="danger"  icon="Trash" />
						</Inline>
						<Inline gap={6} class="mt-3">
							<Button style="soft" theme="accent"  icon="Check" label="Primary" />
							<Button style="soft" theme="neutral" icon="List"  label="Secondary" />
							<Button style="soft" theme="danger"  icon="Trash" label="Danger" />
							<Button style="soft" theme="accent"  icon="Check" />
							<Button style="soft" theme="neutral" icon="List" />
							<Button style="soft" theme="danger"  icon="Trash" />
						</Inline>
						<Inline gap={6} class="mt-3">
							<Button style="plain" theme="accent"  icon="Check" label="Primary" />
							<Button style="plain" theme="neutral" icon="List"  label="Secondary" />
							<Button style="plain" theme="danger"  icon="Trash" label="Danger" />
							<Button style="plain" theme="accent"  icon="Check" />
							<Button style="plain" theme="neutral" icon="List" />
							<Button style="plain" theme="danger"  icon="Trash" />
						</Inline>
					</Stack>

					<!-- Dropdown -->

					<Stack gap={1.5} class="mb-12">
						<Heading is="h3" as="h6">Dropdown</Heading>
						<p class="max-w-[72ch]">The Dropdown component is used to display a list of options that can be selected. It can be used with buttons or other elements to trigger the dropdown menu.</p>
						<Inline gap={6} class="mt-3">
							<Dropdown>
								<Button primary>Dropdown</Button>
								{#snippet content()}
									<Dropdown.Link href="/">Link 1</Dropdown.Link>
									<Dropdown.Link href="/">Link 2</Dropdown.Link>
									<Dropdown.Link href="/">Link 3</Dropdown.Link>
									<Dropdown.Link href="/">Link 4</Dropdown.Link>
									<Dropdown.Link href="/">Link 5</Dropdown.Link>
									<Dropdown.Link href="/">Link 6</Dropdown.Link>
								{/snippet}
							</Dropdown>
						</Inline>
					</Stack>



					<Stack gap={1.5} class="mb-12">
						<Heading is="h3" as="h6">PanZoom</Heading>
						<p class="max-w-[72ch]">The PanZoom component is used to display a large area of content within a smaller area, allowing users to click and drag to navigate around.</p>
						<PanZoom debug constrain class="flex items-center justify-center h-96 mt-3 rounded-lg">
							<img src="/img/world-4.png" alt="world map" />
						</PanZoom>
					</Stack>

					<!-- Thumbnail -->

					<Stack gap={1.5} class="mb-12">
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
					</Stack>

				{:else if activeTab === 'forms'}

					<Heading is="h2" as="h4"
						heading="Form Components"
						class="mt-12 mb-12"
					/>

					<Form class="grid grid-cols-4 gap-6" form={form}>
						<div class="col-span-1 space-y-3">
							
							<!-- Input -->

							<Heading is="h3" as="h6">Input</Heading>

							<Field type="text"
								name="text"
								placeholder="Input"
							/>

							<Field type="text"
								name="icon"
								icon="TextAa"
								placeholder="Input with icon"
							/>

							<Field type="email"
								name="email"
								icon="At"
								placeholder="user@email.com"
							/>

							<Field type="password"
								name="password"
								icon="Password"
								placeholder="Input with icon"
							/>

							<Field type="number"
								name="number"
								icon="Hash"
								placeholder={0}
							/>

							<Field type="url"
								name="url"
								icon="Link"
								placeholder="URL input"
							/>

							<Field type="search"
								name="search"
								icon="MagnifyingGlass"
								placeholder="Search..."
							/>

							<Field type="textarea"
								name="textarea"
								placeholder="Textarea"
								rows={3}
							/>

							<!-- <Field type="text"
								id="text"
								label="Text input"
								placeholder="Type something..."
								bind:value={$form.text}
								errors={$form.errors.text}
								required
							/>

							<Field
								label="Text input"
								required={true}
								description="This is a basic text input form. You can use it to input regular text."
								errors={$form.errors.text}
							>
								<Input type="text"
									id="text"
									label="Text input"
									placeholder="Type something..."
									bind:value={$form.text}
								/>
							</Field> -->

						</div>
						<div class="col-span-1 space-y-3">

							<Heading is="h3" as="h6">Select</Heading>

							<!-- Select -->

							<Field type="select"
								name="select"
								class="w-full"
								placeholder="Select..."
								bind:value={$form.select}
								options={[
									{ value: 'characters', label: 'Characters' },
									{ value: 'dialogue',   label: 'Dialogue'   },
									{ value: 'events',     label: 'Events' },
									{ value: 'factions',   label: 'Factions' },
									{ value: 'items',      label: 'Items' }
								]}
							/>

							<Field type="select"
								name="select"
								class="w-full"
								icon="FolderSimple"
								placeholder="Select with icons..."
								bind:value={$form.select_icons}
								options={[
									{ icon: "UsersThree",     value: 'characters', label: 'Characters' },
									{ icon: "Chats",          value: 'dialogue',   label: 'Dialogue'   },
									{ icon: "CalendarDots",   value: 'events',     label: 'Events' },
									{ icon: "FlagBannerFold", value: 'factions',   label: 'Factions' },
									{ icon: "Backpack",       value: 'items',      label: 'Items' }
								]}
							/>

							<Field type="select"
								name="select"
								class="w-full"
								icon="UserCircle"
								placeholder="Select with images..."
								bind:value={$form.select_images}
								options={[
									{ image: "/img/avatar-1.png", value: 'user1', label: 'Blue' },
									{ image: "/img/avatar-2.png", value: 'user2', label: 'Green' },
									{ image: "/img/avatar-3.png", value: 'user3', label: 'Pink' },
									{ image: "/img/avatar-4.png", value: 'user4', label: 'Red' },
									{ image: "/img/avatar-5.png", value: 'user5', label: 'Orange' }
								]}
							/>

							<!-- <Field type="select"
								name="select_multi"
								class="w-full"
								placeholder="Select multi..."
								bind:value={$form.select_multi_1}
								options={[
									{ value: 'option1', label: 'Option 1' },
									{ value: 'option2', label: 'Option 2' },
									{ value: 'option3', label: 'Option 3' },
									{ value: 'option4', label: 'Option 4' },
									{ value: 'option5', label: 'Option 5' }
								]}
								multiple
							/> -->

							<!-- <Field type="select"
								name="select_multi"
								class="w-full"
								icon="FolderSimple"
								placeholder="Multi with icons..."
								bind:value={$form.select_multi_2}
								options={[
									{ icon: "UsersThree",     value: 'characters', label: 'Characters' },
									{ icon: "Chats",          value: 'dialogue',   label: 'Dialogue'   },
									{ icon: "CalendarDots",   value: 'events',     label: 'Events' },
									{ icon: "FlagBannerFold", value: 'factions',   label: 'Factions' },
									{ icon: "Backpack",       value: 'items',      label: 'Items' }
								]}
								multiple
							/> -->

							<!-- <Input type="select"
								id="select_multi"
								class="w-full"
								icon="UserCircle"
								placeholder="Multi with images..."
								bind:value={$form.select_multi_3}
								options={[
									{ image: "/img/avatar-1.png", value: 'user1', label: 'Blue' },
									{ image: "/img/avatar-2.png", value: 'user2', label: 'Green' },
									{ image: "/img/avatar-3.png", value: 'user3', label: 'Pink' },
									{ image: "/img/avatar-4.png", value: 'user4', label: 'Red' },
									{ image: "/img/avatar-5.png", value: 'user5', label: 'Orange' }
								]}
								multiple
							/> -->

							<!-- Combobox -->

							<!-- <Input type="combobox"
								id="combox1"
								placeholder="Combobox..."
								bind:value={$form.combobox}
								options={[
									{ value: 'characters', label: 'Characters' },
									{ value: 'dialogue',   label: 'Dialogue'   },
									{ value: 'events',     label: 'Events' },
									{ value: 'factions',   label: 'Factions' },
									{ value: 'items',      label: 'Items' }
								]}
							/>

							<Input type="combobox"
								id="combox2"
								icon="Textbox"
								placeholder="Combobox with icons..."
								bind:value={$form.combobox_icons}
								options={[
									{ icon: "UsersThree",     value: 'characters', label: 'Characters' },
									{ icon: "Chats",          value: 'dialogue',   label: 'Dialogue'   },
									{ icon: "CalendarDots",   value: 'events',     label: 'Events' },
									{ icon: "FlagBannerFold", value: 'factions',   label: 'Factions' },
									{ icon: "Backpack",       value: 'items',      label: 'Items' }
								]}
							/>

							<Input type="combobox"
								id="combox3"
								icon="Textbox"
								placeholder="Combobox with images..."
								bind:value={$form.combobox_images}
								options={[
									{ image: "/img/avatar-1.png", value: 'user1', label: 'Blue' },
									{ image: "/img/avatar-2.png", value: 'user2', label: 'Green' },
									{ image: "/img/avatar-3.png", value: 'user3', label: 'Pink' },
									{ image: "/img/avatar-4.png", value: 'user4', label: 'Red' },
									{ image: "/img/avatar-5.png", value: 'user5', label: 'Orange' }
								]}
							/> -->

							

							<!-- Upload -->

							<!-- <Input type="file"
								id="upload"
								class="w-full"
								icon="UploadSimple"
								placeholder="Upload an image"
								bind:value={$form.upload}
							/> -->

							<!-- <Input type="file"
								id="image"
								class="w-full"
								icon="Image"
								placeholder="Upload an image..."
								bind:value={$form.image}
							/>

							<Input type="file"
								id="file"
								class="w-full"
								icon="File"
								placeholder="Upload a file..."
								bind:value={$form.file}
							/> -->

						</div>
						<div class="col-span-1 space-y-3">

							<!-- Slider -->
						
							<!-- <Input type="slider"
								id="slider1"
								style="fill"
								bind:value={$form.slider_1}
							/>
							<Input type="slider"
								id="slider2"
								style="empty"
								bind:value={$form.slider_2}
								step={6.25}
							/>
							<Input type="slider"
								id="slider3"
								style="none"
								bind:value={$form.slider_3}
								step={12.5}
								showTicks
							/>
							<Input type="slider"
								id="slider4"
								style="both"
								bind:value={$form.slider_4}
								step={25}
								showTicks
							/> -->

							<!-- <Input type="slider"
								id="slider5"
								style="fill"
								bind:value={$form.slider_5}
								multiple
							/>
							<Input type="slider"
								id="slider6"
								style="empty"
								bind:value={$form.slider_6}
								step={6.25}
								multiple
							/>
							<Input type="slider"
								id="slider7"
								style="none"
								bind:value={$form.slider_7}
								step={12.5}
								showTicks
								multiple
							/>
							<Input type="slider"
								id="slider8"
								style="both"
								bind:value={$form.slider_8}
								step={25}
								showTicks
								multiple
							/> -->
							<!-- <Form.Field
								id="slider"
								inputType="slider"
								bind:value={$form.slider_steps}
								label="Slider (steps)"
								step={10}
							/>
							<Form.Field
								id="slider"
								inputType="slider"
								bind:value={$form.slider_ticks}
								label="Slider (steps & ticks)"
								step={10} showTicks
							/>
							<Form.Field
								id="slider"
								inputType="slider"
								bind:value={$form.slider_double}
								label="Slider (double)"
								multiple
							/>
							<Form.Field
								id="slider"
								inputType="slider"
								bind:value={$form.slider_multiple}
								label="Slider (multiple)"
								multiple
							/>
							<Form.Field disabled
								id="slider"
								inputType="slider"
								bind:value={$form.slider_disabled}
								label="Slider (disabled)"
							/> -->

						</div>

						<div class="col-span-1 space-y-3">

							<!-- Checkbox -->

							<!-- <Input type="checkbox"
								id="checkbox1"
								bind:checked={$form.checkbox_1}
								labelText="Checkbox example #1"
							/>
							<Input type="checkbox"
								id="checkbox2"
								bind:checked={$form.checkbox_2}
								labelText="Checkbox example #2"
							/>
							<Input type="checkbox"
								id="checkbox3"
								bind:checked={$form.checkbox_3}
								labelText="Checkbox example #3"
								disabled
							/>
							<Input type="checkbox"
								id="checkboxes"
								bind:checked={$form.checkboxes}
								label="Checkboxes"
								options={[
									{ value: 'checkbox1', label: 'Checkbox example #1' },
									{ value: 'checkbox2', label: 'Checkbox example #2' },
									{ value: 'checkbox3', label: 'Checkbox example #3', disabled: true },
								]}
							/> -->

							<!-- Radio -->

							<!-- <Input type="radio"
								id="radio"
								bind:checked={$form.radio}
								options={[
									{ value: 'radio1', label: 'Radio example #1' },
									{ value: 'radio2', label: 'Radio example #2' },
									{ value: 'radio3', label: 'Radio example #3', disabled: true },
								]}
							/> -->

							<!-- Switch -->

							<!-- <Form.Field
								id="switch"
								bind:checked={$form.switch}
								inputType="switch"
								label="Switch"
							/> -->

						</div>
							
					</Form>

				{:else if activeTab === 'table'}

					<Heading is="h2" as="h3"
						heading="Table example"
						class="mt-12 mb-12"
					/>

					{#snippet headRow()}
						<Table.Head shrink={true}><Checkbox checked={false} /></Table.Head>
						<Table.Head sortable={true}>Name</Table.Head>
						<Table.Head sortable={true}>Role</Table.Head>
						<Table.Head sortable={true}>Color</Table.Head>
					{/snippet}

					{#snippet bodyRow(item)}
						<Table.Cell shrink={true}><Checkbox checked={false} /></Table.Cell>
						<Table.Cell><Thumbnail class="w-9" src="/img/avatar.jpg" alt="User" />{item.name}</Table.Cell>
						<Table.Cell>{item.role}</Table.Cell>
						<Table.Cell>{item.color}</Table.Cell>
					{/snippet}

					<Table {headRow} {bodyRow} data={[
						{ id: 1, name: 'Kirk', role: 'Captain', color: 'Yellow' },
						{ id: 2, name: 'Spock', role: 'Lieutenant', color: 'Blue' },
						{ id: 3, name: 'McCoy', role: 'Doctor', color: 'Blue' }
					]} />
						
				{:else if activeTab === 'typography'}

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
		
				{/if}

		</Section>
	{/snippet}
	
</AuthenticatedLayout>

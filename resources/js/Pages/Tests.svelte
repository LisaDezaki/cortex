<script>

	import { page, useForm } from '@inertiajs/svelte'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import UpdateProjectForm from '@/Forms/UpdateProjectForm.svelte'
	import DeleteProjectForm from '@/Forms/DeleteProjectForm.svelte'
	import Article      from '@/Components/Article.svelte'
	import Avatar      from '@/Components/Avatar.svelte'
	import Badge       from '@/Components/Badge.svelte'
	import Breadcrumbs from '@/Components/Breadcrumbs.svelte'
	import Button      from '@/Components/Button.svelte'
	import Dropdown    from '@/Components/Dropdown'
	import Form        from '@/Components/Form'
	import Heading     from '@/Components/Heading.svelte'
	import Section     from '@/Components/Section.svelte'
	import Table       from '@/Components/Table'
	import Tabs        from '@/Components/Tabs'
	import Thumbnail   from '@/Components/Thumbnail.svelte'

	// let active  = $page.props.active_project?.data
	let project = $page.props.active_project?.data

	const form = useForm({
		input: '',
		textarea: '',
		select: '',
		combobox: '',
		number: null,
		slider: 50,
		slider_multiple: [20, 80],
		slider_ticks: 50,
		checkbox: false,
		checkboxes: ['checkbox1'],
		radio: 'radio1',
		switch: false,
		upload: null
	})
	
</script>

<svelte:head>
    <title>{project.name || 'Dashboard'}</title>
</svelte:head>

<AuthenticatedLayout>

    {#snippet header()}
		<Breadcrumbs data={[
			{ title: project.name, href: "/" },
		]} />
    {/snippet}

	{#snippet article()}
		<Tabs value="tab1" class="max-w-4xl">

			<Tabs.List class="max-w-4xl">
				<Tabs.Trigger value="tab1">General</Tabs.Trigger>
				<Tabs.Trigger value="tab2">Forms</Tabs.Trigger>
				<Tabs.Trigger value="tab3">Table</Tabs.Trigger>
				<Tabs.Trigger value="tab4">Typography</Tabs.Trigger>
			</Tabs.List>

			<Tabs.Content value="tab1" class="space-y-6 mt-6">

				<Section>
					<Heading is="h2" as="h4"
						heading="General Components"
						subheading="Most non-form components can be found here."
						class="mt-12 mb-12"
					/>
				</Section>

				<!-- Avatar -->

				<Section>
					<Heading is="h2" as="h5">Avatar</Heading>
					<p class="max-w-[72ch]">Avatars are used to represent users or entities in your application. They can be images or initials, and can be used in various sizes.</p>
					<div class="flex items-center justify-start gap-6 px-3 py-6">
						<Avatar class="w-20" src="/img/avatar.jpg" alt="@username" fallback="AB" />
						<Avatar class="w-16" src="/img/avatar.png" alt="@username" fallback="CD" />
						<Avatar class="w-12" src="/img/avatar.jpg" alt="@username" fallback="EF" />
						<Avatar class="w-8"  src="/img/avatar.png" alt="@username" fallback="GH" />
					</div>
				</Section>

				<!-- Badge -->

				<Section>
					<Heading is="h2" as="h5">Badge</Heading>
					<p class="max-w-[72ch]">The Badge component is used to display small counts or notifications. It can be used in various contexts, such as with buttons or avatars.</p>
					<div class="flex items-center justify-start gap-6 px-3 py-6">
						<Badge label="9" primary />
						<Badge label="99" secondary />
						<Badge label="999" disabled />
						<Badge />
					</div>
				</Section>

				<!-- Button -->

				<Section>
					<Heading is="h2" as="h5">Button</Heading>
					<p class="max-w-[72ch]">Buttons are used to trigger actions in your application. They can be styled in various ways, such as primary, secondary, danger, and disabled.</p>
					<div class="flex flex-wrap items-center justify-start gap-6 px-3 py-6">
						<Button style="hard" theme="accent"  icon="Check" label="Primary"    />
						<Button style="hard" theme="neutral" icon="List"  label="Secondary"  />
						<Button style="hard" theme="danger"  icon="Trash" label="Danger"     />
						<Button style="hard" theme="accent"  icon="Check" />
						<Button style="hard" theme="neutral" icon="List" />
						<Button style="hard" theme="danger"  icon="Trash" />

						<Button style="soft" theme="accent"  icon="Check" label="Primary" />
						<Button style="soft" theme="neutral" icon="List"  label="Secondary" />
						<Button style="soft" theme="danger"  icon="Trash" label="Danger" />
						<Button style="soft" theme="accent"  icon="Check" />
						<Button style="soft" theme="neutral" icon="List" />
						<Button style="soft" theme="danger"  icon="Trash" />

						<Button style="plain" theme="accent"  icon="Check" label="Primary" />
						<Button style="plain" theme="neutral" icon="List"  label="Secondary" />
						<Button style="plain" theme="danger"  icon="Trash" label="Danger" />
						<Button style="plain" theme="accent"  icon="Check" />
						<Button style="plain" theme="neutral" icon="List" />
						<Button style="plain" theme="danger"  icon="Trash" />
					</div>
				</Section>

				<!-- Dropdown -->

				<Section>
					<Heading is="h2" as="h5">Dropdown</Heading>
					<p class="max-w-[72ch]">The Dropdown component is used to display a list of options that can be selected. It can be used with buttons or other elements to trigger the dropdown menu.</p>
					<div class="flex items-center justify-start gap-6 px-3 py-6">
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
					</div>
				</Section>

				<!-- Thumbnail -->

				<Section>
					<Heading is="h2" as="h5">Thumbnail</Heading>
					<p class="max-w-[72ch]">Thumbnails are used to display images in a compact format. They can be used to represent users, products, or any other visual content.</p>
					<div class="flex flex-wrap items-start justify-start gap-6 px-3 py-6">
						<Thumbnail class="w-20" src="/img/avatar.jpg" alt="User" />
						<Thumbnail class="w-16" src="/img/avatar.jpg" alt="User" />
						<Thumbnail class="w-14" src="/img/avatar.jpg" alt="User" />
						<Thumbnail class="w-12" src="/img/avatar.jpg" alt="User" />
						<Thumbnail class="w-10" src="/img/avatar.jpg" alt="User" />
						<Thumbnail class="w-9" src="/img/avatar.jpg" alt="User" />
						<Thumbnail class="w-8" src="/img/avatar.jpg" alt="User" />
					</div>
				</Section>

			</Tabs.Content>
			<Tabs.Content value="tab2">

				<!-- Form Fields -->

				<Section
					title="Form Fields"
					subtitle="Various input components for forms."
				>
				
					<Form class="space-y-6">

						<!-- Input -->

						<Form.Field
							type="text"
							id="input"
							layout="block"
							description="This is an example of an input component."
							label="Input"
							placeholder="Type something..."
							bind:value={$form.input}
						/>

						<!-- Number -->

						<Form.Field
							type="number"
							id="number"
							layout="block"
							description="This is an example of a number component."
							label="Number"
							placeholder={0}
							bind:value={$form.number}
						/>

						<!-- Select -->

						<Form.Field
							id="select"
							layout="block"
							description="This is an example of a select component."
							type="select"
							label="Select"
							placeholder="Select an option..."
							options={[
								{ value: 'option1', label: 'Option 1' },
								{ value: 'option2', label: 'Option 2' },
								{ value: 'option3', label: 'Option 3' },
								{ value: 'option4', label: 'Option 4' },
								{ value: 'option5', label: 'Option 5' },
								{ value: 'option6', label: 'Option 6' },
								{ value: 'option7', label: 'Option 7' },
								{ value: 'option8', label: 'Option 8' },
								{ value: 'option9', label: 'Option 9' },
								{ value: 'option10', label: 'Option 10' }
							]}
							bind:value={$form.select}
						/>

						<!-- Combobox -->

						<Form.Field
							id="combo"
							layout="block"
							description="This is an example of a combobox component."
							type="combobox"
							label="Combobox"
							placeholder="Select an option..."
							options={[
								{ value: 'option1', label: 'Option 1' },
								{ value: 'option2', label: 'Option 2' },
								{ value: 'option3', label: 'Option 3' },
								{ value: 'option4', label: 'Option 4' },
								{ value: 'option5', label: 'Option 5' },
								{ value: 'option6', label: 'Option 6' },
								{ value: 'option7', label: 'Option 7' },
								{ value: 'option8', label: 'Option 8' },
								{ value: 'option9', label: 'Option 9' },
								{ value: 'option10', label: 'Option 10' }
							]}
							bind:value={$form.combobox}
						/>

						<!-- Textarea -->

						<Form.Field
							type="textarea"
							id="textarea"
							layout="block"
							description="This is an example of a textarea component."
							label="Textarea"
							placeholder="Type something longer..."
							rows={4}
							bind:value={$form.textarea}
						/>

						<!-- Upload -->

						<Form.Field
							id="upload"
							layout="block"
							description="This is an example of a file upload component."
							type="file"
							label="Upload"
							bind:value={$form.upload}
						/>


						<!-- Slider -->
						
						<Form.Field
							type="slider"
							id="slider"
							layout="block"
							description="This is an example of a slider component."
							label="Slider"
							bind:value={$form.slider}
						/>

						<Form.Field
							type="slider"
							multiple
							id="slider"
							layout="block"
							description="This is an example of a slider component with multiple values."
							label="Slider (multiple)"
							bind:value={$form.slider_multiple}
						/>

						<Form.Field
							type="slider"
							id="slider"
							layout="block"
							description="This is an example of a slider component with steps and ticks."
							label="Slider (steps & ticks)"
							bind:value={$form.slider_ticks}
							step={10} showTicks
						/>

						
						<!-- Checkbox -->

						<Form.Field
							type="checkbox"
							id="checkbox"
							layout="block"
							description="This is an example of a checkbox component."
							label="Checkbox"
							labelText="Checkbox example #1"
							bind:checked={$form.checkbox}
						/>

						<Form.Field
							type="checkbox"
							id="checkboxes"
							layout="block"
							description="This is an example of a checkboxes component."
							label="Checkboxes"
							bind:checked={$form.checkboxes}
							options={[
								{ value: 'checkbox1', label: 'Checkbox example #1' },
								{ value: 'checkbox2', label: 'Checkbox example #2' },
								{ value: 'checkbox3', label: 'Checkbox example #3', disabled: true },
							]}
						/>

							<!-- Radio -->

						<Form.Field
							type="radio"
							id="radio"
							layout="block"
							description="This is an example of a radio component."
							label="Radio buttons"
							bind:checked={$form.radio}
							options={[
								{ value: 'radio1', label: 'Radio example #1' },
								{ value: 'radio2', label: 'Radio example #2' },
								{ value: 'radio3', label: 'Radio example #3', disabled: true },
							]}
						/>

						<!-- Switch -->

						<Form.Field
							id="switch"
							layout="block"
							description="This is an example of a switch component."
							type="switch"
							label="Switch"
							bind:checked={$form.switch}
						/>
							
					</Form>
				</Section>

			</Tabs.Content>
			<Tabs.Content value="tab3">

				<Article
					title="Table example"
					subtitle="Tables are used to display data in a structured format. They can include sorting, filtering, and pagination."
					bodyclass="p-0"
				>
					{#snippet headRow()}
						<Table.Head shrink={true}><Form.Checkbox checked={false} /></Table.Head>
						<Table.Head sortable={true}>Name</Table.Head>
						<Table.Head sortable={true}>Role</Table.Head>
						<Table.Head sortable={true}>Color</Table.Head>
					{/snippet}

					{#snippet bodyRow(item)}
						<Table.Cell shrink={true}><Form.Checkbox checked={false} /></Table.Cell>
						<Table.Cell><Thumbnail class="w-9" src="/img/avatar.jpg" alt="User" />{item.name}</Table.Cell>
						<Table.Cell>{item.role}</Table.Cell>
						<Table.Cell>{item.color}</Table.Cell>
					{/snippet}

					<Table {headRow} {bodyRow} data={[
						{ id: 1, name: 'Kirk', role: 'Captain', color: 'Yellow' },
						{ id: 2, name: 'Spock', role: 'Lieutenant', color: 'Blue' },
						{ id: 3, name: 'McCoy', role: 'Doctor', color: 'Blue' }
					]} />
					
				</Article>
			</Tabs.Content>
			<Tabs.Content value="tab4">
				<Article class="p-6">
	
					<!-- Headings -->
	
					<h2 class="font-style-h5 mb-2 text-slate-400">Headings</h2>
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
	
				</Article>
			</Tabs.Content>
		</Tabs>
	{/snippet}
	
</AuthenticatedLayout>

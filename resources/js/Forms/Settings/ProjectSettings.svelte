<script>
	import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Grid, Inline, Stack } from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Field   from '@/Components/UI/Field.svelte'

	const project  = $page.props.activeProject?.data
	const settings = $page.props.settings?.project?.data

	let {
		class: className,
        oncancel = () => {},
		...restProps
    } = $props()

	const form = useForm({
		name: project?.name,
		type: project?.type,
		description: project?.description,
		enable_characters: true,
		enable_factions: true,
		enable_items: true,
		enable_locations: true,
    })
	
	function updateSettings() {
		console.log('update settings');
	}

</script>

<Form {form}
	class="flex flex-col gap-3 {className}"
	onsubmit={updateSettings}
>
	<!-- Project Settings -->

	<Field type="text"
		name="name"
		layout="block"
		label="Name"
		description="What is the name of this project?"
	/>

	<Field type="text"
		name="type"
		layout="block"
		label="Type"
		description="Describe what kind of project this is (in a few words)."
	/>

	<Field type="textarea"
		name="description"
		layout="block"
		label="Description"
		description="Describe the project."
		rows={5}
	/>

	<Field type="select"
		name="theme"
		layout="block"
		label="Theme"
		description="What theme do you want to use for this project?"
		options={[
			{ label: 'Emerald', value: 'emerald' },
			{ label: 'Sky',		value: 'sky' },
			{ label: 'Rose',	value: 'rose' },
			{ label: 'Violet',	value: 'violet' }
		]}
	/>

	<Field
		name="theme"
		layout="block"
		label="Theme"
		description="What theme do you want to use for this project?"
	>
		<Stack cols={2} gap={3}>
			{#each ['emerald', 'sky', 'pink', 'violet'] as color}
				<Flex align="center" gap={3}>
					<Inline align="stretch" class="aspect-video bg-slate-100 border-2 border-{color}-600 rounded overflow-hidden w-32">
						<Stack class="flex-none bg-{color}-600 w-1/5"></Stack>
						<Stack class="flex-1"></Stack>
					</Inline>
					<span class="text-lg">{color}</span>
				</Flex>
			{/each}
		</Stack>
	</Field>

	<!-- <Field type="switch"
		name="enable_characters"
		layout="block"
		description="Does this project contain Characters?"
	/>

	<Field type="switch"
		name="enable_factions"
		layout="block"
		description="Does this project contain Factions?"
	/>

	<Field type="switch"
		name="enable_items"
		layout="block"
		description="Does this project contain Items?"
	/>

	<Field type="switch"
		name="enable_locations"
		layout="block"
		description="Does this project contain Locations?"
	/> -->

	{#snippet actions()}
		<Button style="hard" theme="neutral"
			type="button"
			text="Cancel"
			onclick={oncancel ? oncancel : () => history.back()}
		/>
		<Button style="hard" theme="accent"
			type="submit"
			text="Save changes"
			onclick={updateSettings}
			disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
		/>
	{/snippet}

</Form>
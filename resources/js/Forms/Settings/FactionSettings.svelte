<script>
	import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form }   from '@/Components/Core'

	import Button  from '@/Components/UI/Button.svelte'
	import Field   from '@/Components/UI/Field.svelte'
	import Input   from '@/Components/UI/Input'

	const customFields = $page.props.customFields?.data

	let {
		class: className,
    } = $props()

	const form = useForm({
		enabled: true,
        subheading: '',
		enable_aesthetic: false,
		enable_ideology: false,
		enable_headquarters: true
    })

</script>

<Form {form} {oncancel}
	class="flex flex-col gap-6 {className}"
	enctype="multipart/form-data"
	endpoint={route('factions.settings')}
	method="patch"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>

	<Input.Switch name="enabled" bind:checked={$form.enabled}
		label="Enable Factions"
	/>

	<Field type="select"
		name="subheading"
		inputClass="w-full"
		label="Faction subheading"
		description="Which field would you like to show under the faction's name when viewing it?"
		layout="block"
		options={customFields?.map((field) => {
			return { value: field.name, label: field.label }
		})}
	/>

	<Field type="switch"
		name="enable_aesthetic"
		description="Should Factions have an aesthetic description field?"
		layout="block"
	/>

	<Field type="switch"
		name="enable_ideology"
		description="Should Factions have an ideology description field?"
		layout="block"
	/>

	<Field type="switch"
		name="enable_headquarters"
		description="Should Factions have a 'headquarters' field?"
		layout="block"
	/>

	<!-- <Field name="subheading"
		layout="block"
		inputClass="w-full"
		type="select"
		label="Faction subheading"
		description="Which field would you like to show under the faction's name when viewing them?"
		options={customFields?.map((field) => {
			return { value: field.name, label: field.label }
		})}
	/> -->

	<!-- <Field name="enable_ranks"
		layout="block"
		type="switch"
		label="Enable faction ranks?"
		description="Adds hierarchical ranks to faction members so that some members can outrank others."
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
		/>
	{/snippet}

</Form>
<script>
	import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form }   from '@/Components/Core'

	import Button  from '@/Components/UI/Button.svelte'
	import Field   from '@/Components/UI/Field.svelte'
	import Heading from '@/Components/UI/Heading.svelte'
	import Input   from '@/Components/UI/Input'

	const customFields = $page.props.customFields?.data
	const settings = $page.props.settings?.characters?.data

	let {
		class: className,
    } = $props()

	const form = useForm({
		enabled: true,
        subheading: '',
		enable_appearance: true,
		enable_personality: true,
    })

</script>



<Form {form} {oncancel}
	class="flex flex-col gap-6 {className}"
	enctype="multipart/form-data"
	endpoint={route('characters.settings')}
	method="patch"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<Input.Switch name="enabled"
		label="Enable Characters"
	/>

	<Field type="select"
		name="subheading"
		inputClass="w-full"
		label="Character subheading"
		description="Which field would you like to show under the character's name when viewing them?"
		layout="block"
		options={customFields?.map((field) => {
			return { value: field.name, label: field.label }
		})}
	/>

	<Field type="switch"
		name="enable_appearance"
		description="Should Characters have an appearance description field?"
		layout="block"
	/>

	<Field type="switch"
		name="enable_personality"
		description="Should Characters have a personality description field?"
		layout="block"
	/>

	<Field type="switch"
		name="enable_locations"
		description="Should Characters have specific Location connections in this project?"
		layout="block"
	/>

	<Field type="switch"
		name="enable_relationships"
		description="Should Characters have relationship connections with other Characters in this project?"
		layout="block"
	/>

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
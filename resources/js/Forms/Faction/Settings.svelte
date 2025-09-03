<script>
	import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form }   from '@/Components/Core'

	import Button  from '@/Components/UI/Button.svelte'
	import Field   from '@/Components/UI/Field.svelte'
	import Heading from '@/Components/UI/Heading.svelte'
	import Input   from '@/Components/UI/Input.svelte'

	const customFields = $page.props.customFields?.data
	const settings = $page.props.settings?.characters?.data

	let {
		class: className,
        oncancel = () => {}
    } = $props()

	const form = useForm({
		enabled: true,
        subheading: ''
    })

</script>

<Form {form} {oncancel}
	class={className}
	enctype="multipart/form-data"
	endpoint={route('factions.settings')}
	method="patch"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>

	<Flex align="center" class="mb-6 max-w-[32ch]">
		<Heading is="h3" as="h5">Overview</Heading>
	</Flex>

	<Input name="enabled"
		type="switch"
		label="Enable Factions"
	/>

	<Field name="subheading"
		layout="block"
		inputClass="w-full"
		type="select"
		label="Character subheading"
		description="Which field would you like to show under the faction's name when viewing them?"
		options={customFields?.map((field) => {
			return { value: field.name, label: field.label }
		})}
	/>

	{#snippet actions()}
		<Button style="hard" theme="neutral"
			type="button"
			label="Cancel"
			onclick={oncancel ? oncancel : () => history.back()}
		/>
		<Button style="hard" theme="accent"
			type="submit"
			label="Save changes"
			onclick={updateSettings}
		/>
	{/snippet}

</Form>
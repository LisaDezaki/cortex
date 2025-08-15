<script>
	import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Form }   from '@/Components/Core'

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
	
	function updateSettings() {
		console.log('update settings');
	}

</script>

<Form onsubmit={updateSettings} class={className}>

	<Heading is="h4" as="h6" class="mb-6"
		heading="Overview"
		subheading="The most important settings for the Character entity."
	/>

	<Input
		type="switch"
		label="Enable Characters"
		bind:checked={$form.enabled}
		errors={$form.errors.enabled}
	/>

	<Field layout="block" inputClass="w-full"
		type="select"
		label="Character subheading"
		description="Which field would you like to show under the character's name when viewing them?"
		options={customFields.map((field) => {
			return { value: field.name, label: field.label }
		})}
		bind:value={$form.subheading}
		errors={$form.errors.subheading}
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
			disabled={!$form.isDirty || $form.processing || $form.recentlySuccessful}
		/>
	{/snippet}

</Form>
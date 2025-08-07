<script>
	import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form.svelte'

	const settings = $page.props.settings?.project?.data

	let {
		class: className,
        oncancel = () => {}
    } = $props()

	const form = useForm({
        subheading: ''
    })
	
	function updateSettings() {
		console.log('update settings');
	}

</script>

<!-- <pre>{JSON.stringify($form,null,4)}</pre> -->

<Form
	class="mt-6 space-y-2 {className}"
	onsubmit={updateSettings}
>
	<!-- Project Settings -->

	<!-- <Form.Field
		type="select"
		layout="block"
		label="Character subheading"
		description="Which field would you like to show under the character's name when viewing them?"
		options={[
			{ value: '1', label: 'Species'},
			{ value: '2', label: 'Language'},
			{ value: '3', label: 'Origin'}
		]}
		bind:value={$form.subheading}
		errors={$form.errors.subheading}
	/> -->

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
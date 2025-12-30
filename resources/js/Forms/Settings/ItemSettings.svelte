<script>
	import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form }   from '@/Components/Core'

	import Button  from '@/Components/UI/Button.svelte'
	import Field   from '@/Components/UI/Field.svelte'
	import Heading from '@/Components/UI/Heading.svelte'
	import Input   from '@/Components/UI/Input'
	import PageHeading from '@/Components/UI/PageHeading.svelte'

	const customFields = $page.props.customFields?.data
	const settings = $page.props.settings?.items?.data

	let {
		class: className,
    } = $props()

	const form = useForm({
		enabled: true,
        // subheading: 'type',
		enable_currency: true,
		currency: 'gold',
		enable_weight: true,
		weight: 'cg'
    })

</script>



<Form {form}
	class="flex flex-col gap-6 {className}"
	enctype="multipart/form-data"
	endpoint={route('items.settings')}
	method="patch"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>

	<Field type="switch"
		name="enabled"
		label="Enable Items"
	/>

	<!-- <Field name="subheading"
		inputClass="w-full"
		type="select"
		label="Item subheading"
		description="What should be the default field for Items' secondary label?"
		options={[
			{ label: 'Type', value: 'type' },
			...customFields?.map((field) => {
				return { value: field.name, label: field.label }
			})
		]}
	/> -->

	<Field name="enable_currency"
		type="switch" layout="block"
		label="Enable currencies"
		description="Currency is how you can add prices to items."
	/>

	{#if $form.enable_currency}
		<Field name="currency"
			type="select" layout="block"
			icon="Coins" label="Currency"
			description="What is the smallest unit of currency available in this game?"
			options={[
				'Caps', 'Cred', 'Credits', 'Coins', 'Dollars', 'Energy', 'Gold', 'Reputation', 'Septims', 'Tokens', 'Units'
			].map(o => ({ label: o, value: o.toLowerCase() }))}
		/>
	{/if}

	<Field name="enable_weight"
		type="switch" layout="block"
		label="Item weight"
		description="Set relative weights for every item. Useful if the game contains an over-encumbered mechanic."
	/>

	<Field name="weight"
		type="select" layout="block"
		icon="Feather" label="Currency"
		description="What is the smallest unit of weight possible in this game?"
		options={[
			{ label: 'Grams (g)', value: 'g' },
			{ label: 'Centigrams (0.1kg)', value: 'cg' },
			{ label: 'Kilograms (kg)', value: 'kg' },
			{ label: 'Ounces (oz)', value: 'oz' },
			{ label: 'Pounds (lb)', value: 'lbs' }
		]}
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
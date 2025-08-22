<script>
	import { useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Flex, Form, Grid } from '@/Components/Core'

	import Button from '@/Components/UI/Button.svelte'
	import Card from '@/Components/UI/Card.svelte'
	import CardNew from '@/Components/UI/CardNew.svelte'
	import Heading from '@/Components/UI/Heading.svelte'

	let {
		character,
		class: className,
		items,
		...restProps
	} = $props()

	let editMode = $state(false)

	const form = useForm({
		inventory: items
	})

</script>





<Form
	endpoint={ character ? route('characters.update', {character: character.slug}) : route('characters.store') }
	method={character ? 'patch' : 'post'}
	submitText={character ? 'Update' : 'Save'}
	class={className}
{...restProps}>

	<Flex items="center" justify="between" class="bg-neutral-softest mb-6 -mx-3 px-3 py-1.5 rounded-lg w-full">
		<Heading is="h3" as="h5" heading="Inventory" />
		<Flex justify="end" class="p-1.5">
			{#if editMode}
				<Button style="soft" theme="neutral" class="rounded-full"
					icon="X" type="button" onclick={() => editMode = false }
					disabled={$form.processing}
				/>
				<Button style="soft" theme="accent" class="rounded-full"
					icon="Check" type="submit"
					disabled={$form.processing}
				/>
			{:else}
				<Button style="soft" theme="neutral" class="rounded-full"
					icon="Plus" type="button" onclick={() => editMode = true }
				/>
			{/if}
		</Flex>
	</Flex>


	{#if items == undefined || items.length == 0}

		<p class="font-style-placeholder">{character.name} doesn't have any items in their inventory yet.</p>

	{:else}
		<Grid cols={6}>
			{#each items as item, i}
				<Card aspect="square"
					icon="User"
				/>
			{/each}
			<CardNew aspect="square"
				onclick={() => {}}
			/>
		</Grid>
	{/if}

</Form>
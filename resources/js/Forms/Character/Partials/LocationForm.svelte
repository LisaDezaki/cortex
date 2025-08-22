<script>
	import { useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Flex, Form, Grid } from '@/Components/Core'

	import Button  from '@/Components/UI/Button.svelte'
	import Card    from '@/Components/UI/Card.svelte'
	import CardNew from '@/Components/UI/CardNew.svelte'
	import Heading from '@/Components/UI/Heading.svelte'

	import Map     from '@/Components/Features/Location/Map.svelte'

	let {
		character,
		class: className,
		location,
		...restProps
	} = $props()

	let editMode = $state(false)

	const form = useForm({
		location: location
	})

</script>





<Form
	endpoint={ character ? route('characters.update', {character: character.slug}) : route('characters.store') }
	method={character ? 'patch' : 'post'}
	submitText={character ? 'Update' : 'Save'}
	class={className}
{...restProps}>

	<Flex items="center" justify="between" class="bg-neutral-softest mb-6 -mx-3 px-3 py-1.5 rounded-lg">
		<Heading is="h3" as="h5" heading="Location" />
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


	{#if location == undefined}

		<p class="font-style-placeholder">{character.name} hasn't been assigned a location yet.</p>

	{:else}
		<Map class="aspect-square w-full"
			location={character.location}
		/>
	{/if}

</Form>
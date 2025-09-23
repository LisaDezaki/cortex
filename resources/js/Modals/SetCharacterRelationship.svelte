<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { onMount, onDestroy } from 'svelte'
	import { route } from 'momentum-trail'

	import { Flex, Form, Grid, Stack } from '@/Components/Core'

	import Button    from '@/Components/UI/Button.svelte'
	import Heading   from '@/Components/UI/Heading.svelte'
	import Icon		 from '@/Components/UI/Icon.svelte'
	import Input     from '@/Components/UI/Input.svelte'
	import ModalForm 	 from '@/Components/UI/ModalForm.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	import CharacterCard from '@/Components/Features/Character/CharacterCard.svelte'

	let characters = $page.props.activeProject?.data.characters

	let {
		character,
		relationship,
		isOpen = false,
		// onsubmit,
		oncancel
	} = $props()

	let form = useForm({
		relationships: [{
			// character: character || null,
			// related: characters.find(c => c.id === relationship?.id) || null,
			related_character_id: relationship?.id || null,
			// id: relationship?.id,
			character_role: relationship?.parentRole || null,
			related_character_role:   relationship?.role || null
		}]
	})

	let relatedCharacter		  = $derived(characters.find(c => c.id === relationship?.id))
	let existingRelationshipSlugs = $derived(character.relationships.map(rel => rel.slug))

	// let relatedCharacter = $derived(characters.find(char => char.id === $form.related.id))

	function selectRelatedCharacter(e, related_character) {
		e.preventDefault()
		// console.log(e,related_character)
		$form.relationships[0].related_character_id = related_character.id
		// $form.relationships[0].related = related_character
		relatedCharacter = related_character
	}

	// function submitRelationship(e) {
	// 	if (onsubmit) {
	// 		onsubmit(e, $form)
	// 		$form.reset()
	// 	} else {
	// 		e.preventDefault()
	// 		$form.patch(
	// 			route('characters.update', { character: character.slug }),
	// 			{ onSuccess: () => { $form.reset() }}
	// 		)
	// 	}
	// }

	// function handleCancel() {
	// 	oncancel()
	// 	$form.reset()
	// }

	// onMount(() => {
	// 	$form.reset()
		// console.log('onMount')
	// });
	
	// onDestroy(() => {
		// 	$form.reset()
		// console.log('onDestroy')
	// });

</script>





<ModalForm title="Set relationship to {character?.name}?" size="xl"
	endpoint={route('characters.update', { character: character.slug})}
	form={form}
	method="patch"
	reloadPageProps={['characters']}
>
	{#if relatedCharacter == null}

		<Grid cols={5} class="px-6 py-3">
			{#each characters.filter(c => c.id !== character.id) as char}
				<CharacterCard
					character={char}
					onclick={(e) => selectRelatedCharacter(e,char)}
					disabled={existingRelationshipSlugs.includes(char.slug)}
				>
					{#if existingRelationshipSlugs.includes(char.slug)}
						<Icon name="Handshake" class="absolute bg-accent-gradient border-accent-strong p-2 rounded-full text-white" />
					{/if}
				</CharacterCard>
			{/each}
		</Grid>

	{:else}

		<Button icon="ArrowLeft" class="absolute top-3 left-3 rounded-full" onclick={() => relatedCharacter = null} />

		<Flex justify="center" class="p-6 pb-3 -space-x-8 w-full">
			<Stack gap={1.5}>
				<Thumbnail class="rounded-full h-40 w-40" src={character?.image?.url} />
			</Stack>
			
			<Stack gap={1.5}>
				<Thumbnail class="rounded-full h-40 w-40" src={relatedCharacter?.image?.url} />
			</Stack>
		</Flex>

		<Flex align="center" justify="center">
			<p class="font-style-large text-center w-32">{character?.name}</p>
			<Icon class="w-8" name="Handshake" size={40} weight="light" />
			<p class="font-style-large text-center w-32">{relatedCharacter?.name}</p>
		</Flex>

		<Flex justify="center" class="p-6 pt-3 w-full">
			<Input bind:value={$form.relationships[0].character_role} placeholder="Label (e.g, Parent)"
				class="w-48"
			/>
			<Input bind:value={$form.relationships[0].related_character_role} placeholder="Label (e.g, Child)"
				class="w-48"
			/>
		</Flex>

	{/if}

		<!-- <div class="flex flex-col gap-6">
			<div class="flex items-center gap-3">
				<Thumbnail class="rounded-full h-16 w-16" src={$form.character?.image?.url} />
				<div class="space-y-1">
					<div>{$form.character?.name} is {$form.related?.name}'s</div>
					<Input bind:value={$form.role} placeholder="Label (e.g, Parent)" />
				</div>
			</div>

			<div class="flex items-center gap-3">
				<Thumbnail class="rounded-full w-16" src={$form.related?.image?.url} />
				<div class="space-y-1">
					<div>{$form.related?.name} is {$form.character?.name}'s</div>
					<Input bind:value={$form.related_role} placeholder="Label (e.g, Child)" />
				</div>
			</div>
		</div> -->

		<!-- <Flex gap={0} class="border-t flex-0 min-h-12">
			<Button style="hard" theme="neutral" class="border-none rounded-none w-1/2"
				type="button"
				label="Cancel"
				onclick={oncancel}
			/>
			<Button style="hard" theme="accent" class="border-none rounded-none w-1/2"
				type="submit"
				label="Confirm"
			/>
		</Flex> -->
</ModalForm>
<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { onMount, onDestroy } from 'svelte'
	import { route } from 'momentum-trail'

	import { Form, Grid } from '@/Components/Core'

	import Button    from '@/Components/UI/Button.svelte'
	import Heading   from '@/Components/UI/Heading.svelte'
	import Input     from '@/Components/UI/Input.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	import CharacterCard from '@/Components/Features/Character/CharacterCard.svelte'

	let characters = $page.props.activeProject?.data.characters

	let {
		character,
		relationship,
		onsubmit,
		oncancel
	} = $props()

	let relationshipForm = useForm({
		character: character || null,
		related: characters.find(c => c.id === relationship?.id) || null,
		// related_id: relationship?.id || null,
		character_role: relationship?.parentRole || null,
		related_role:   relationship?.role || null
	})

	let existingRelationshipSlugs = $derived(character.relationships.map(rel => rel.slug))

	// let relatedCharacter = $derived(characters.find(char => char.id === $relationshipForm.related.id))

	function selectRelatedCharacter(e, related_character) {
		e.preventDefault()
		$relationshipForm.related = related_character
		// console.log($relationshipForm.related_character)
	}

	function submitRelationship(e) {
		if (onsubmit) {
			onsubmit(e, $relationshipForm)
			$relationshipForm.reset()
		} else {
			e.preventDefault()
			$relationshipForm.patch(
				route('characters.update', { character: character.slug }),
				{ onSuccess: () => { $relationshipForm.reset() }}
			)
		}
	}

	function handleCancel() {
		oncancel()
		$relationshipForm.reset()
	}

	onMount(() => {
		$relationshipForm.reset()
	});

	onDestroy(() => {
		$relationshipForm.reset()
	});

</script>





<Form onsubmit={submitRelationship}>

	<Heading is="h4" as="h6" class="mb-6"
		heading={relationship
			? `Edit ${character.name}'s relationship with ${$relationshipForm.related.name}`
			: `Add a new relationship to ${character.name}`
		}
	/>

	<!-- <pre>{JSON.stringify(relationship,null,4)}</pre> -->
	<!-- <pre>{JSON.stringify(relatedCharacter,null,4)}</pre> -->
	<!-- <pre>{JSON.stringify($relationshipForm.related_character,null,4)}</pre> -->

	{#if $relationshipForm.related == null}

		<Grid cols={6}>
			{#each characters.filter(c => c.id !== character.id) as char}
				<CharacterCard character={char} onclick={selectRelatedCharacter} disabled={existingRelationshipSlugs.includes(char.slug)} />
			{/each}
		</Grid>

	{:else}

		<div class="flex flex-col gap-6">
			<div class="flex items-center gap-3">
				<Thumbnail class="rounded-full h-16 w-16" src={$relationshipForm.character?.portrait?.url} />
				<div class="space-y-1">
					<div>{$relationshipForm.character?.name} is {$relationshipForm.related?.name}'s</div>
					<Input bind:value={$relationshipForm.character_role} />
				</div>
			</div>

			<div class="flex items-center gap-3">
				<Thumbnail class="rounded-full w-16" src={$relationshipForm.related?.portrait?.url} />
				<div class="space-y-1">
					<div>{$relationshipForm.related?.name} is {$relationshipForm.character?.name}'s</div>
					<Input bind:value={$relationshipForm.related_role} />
				</div>
			</div>
		</div>

		<div class="mt-6 flex-shrink-0">
			<div class="flex items-center justify-center gap-3 pt-2">
				<Button style="hard" theme="neutral"
					type="button"
					label="Cancel"
					onclick={handleCancel}
				/>
				<Button style="hard" theme="accent"
					type="submit"
					label="Save relationship"
				/>
			</div>
		</div>

	{/if}
</Form>
<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Flex, Grid, Stack } from '@/Components/Core'

	import Button    from '@/Components/UI/Button.svelte'
	import Icon		 from '@/Components/UI/Icon.svelte'
	import Input     from '@/Components/UI/Input.svelte'
	import ModalForm from '@/Components/UI/ModalForm.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	import CharacterCard from '@/Components/Features/Character/CharacterCard.svelte'

	let characters = $page.props.activeProject?.data.characters

	let {
		character,
		related,
		relationship,
	} = $props()

	let relatedCharacter		  = $derived(related ? characters.find(c => c.slug === related) : characters.find(c => c.id === relationship?.id))
	let existingRelationshipSlugs = $derived(character.relationships?.items.map(rel => rel.slug) || [])

	const form = useForm({
		relationships: [{
			related_character_id: relationship?.id || null,
			character_role: relationship?.parentRole || null,
			related_character_role:   relationship?.role || null
		}]
	})

	function selectRelatedCharacter(e, related_character) {
		e.preventDefault()
		$form.relationships[0].related_character_id = related_character.id
		relatedCharacter = related_character
	}

</script>



<ModalForm title="Set relationship to {character?.name}?" size="xl"
	endpoint={route('characters.update', { character: character.slug})}
	form={form}
	method="patch"
	reloadPageProps={['characters']}
>
	{#if relatedCharacter == null}

		<Grid cols={5} class="px-6 pt-0 pb-3">
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

		<Button icon="ArrowLeft" class="absolute top-0 left-3 rounded-full" onclick={() => relatedCharacter = null} />

		<Flex justify="center" class="p-3 pt-6 -space-x-6 w-full">
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
</ModalForm>
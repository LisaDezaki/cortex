<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Flex, Grid, Stack } from '@/Components/Core'

	import Entity    from '@/Components/UI/Entity.svelte'
	import Input     from '@/Components/UI/Input'
	import ModalForm from '@/Components/UI/ModalForm.svelte'

	import CharacterList from '@/services/CharacterList';

	const characters = $page.props.activeProject?.data.characters
	// const characters = new CharacterList($page.props.activeProject?.data?.characters)

	let {
		character
	} = $props()

	const form = useForm({
		relationships: [...character.relationships.items.map(r => r.id)]
	})

	function toggleRelationship(id) {
		let isActive = $form.relationships?.includes(id)
		$form.relationships = isActive
			? [ ...$form.relationships.filter(f => f !== id) ]
			: [ ...$form.relationships, id ]
	}

</script>



<ModalForm title="Set {character?.name}'s relationships with other characters" size="xl"
	endpoint={route('characters.update', { character: character.slug})}
	form={form}
	method="patch"
	reloadPageProps={['characters']}
>
	<Input.Text class="mx-3" type="search" icon="MagnifyingGlass" placeholder="Search..." />
	<Grid cols={4} gap={1} class="max-h-[60vh] overflow-y-auto p-3">
		{#each characters.filter(c => c.id !== character.id) as char}
			<Entity entity={char}
				class="cursor-pointer"
				active={$form.relationships.includes(char.id)}
				onclick={() => toggleRelationship(char.id)}
			/>
		{/each}
	</Grid>
</ModalForm>
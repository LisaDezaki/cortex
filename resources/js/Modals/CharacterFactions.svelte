<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Flex, Grid, Stack } from '@/Components/Core'

	import Input     from '@/Components/UI/Input'
	import ModalForm from '@/Components/UI/ModalForm.svelte'

	import FactionCard from '@/Components/Features/Faction/FactionCard.svelte'
	import FactionList from '@/services/FactionList';

	const factions = new FactionList($page.props.activeProject?.data?.factions)

	let {
		character
	} = $props()

	const form = useForm({
		factions: [...character.factions.items.map(f => f.id)]
	})

	function toggleFaction(id) {
		let isActive = $form.factions?.includes(id)
		$form.factions = isActive
			? [ ...$form.factions.filter(f => f !== id) ]
			: [ ...$form.factions, id ]
	}

</script>



<ModalForm title="Set which factions {character?.name} belongs to?" size="xl"
	endpoint={route('characters.update', { character: character.slug})}
	form={form}
	method="patch"
	reloadPageProps={['characters']}
>
	<Input.Text class="mx-3" type="search" icon="MagnifyingGlass" placeholder="Search..." />
	<Grid cols={4} gap={1} class="max-h-[60vh] overflow-y-auto p-3">
		{#each factions.items as faction}
			<FactionCard faction={faction}
				class="cursor-pointer"
				active={$form.factions.includes(faction.id)}
				onclick={() => toggleFaction(faction.id)}
			/>
		{/each}
	</Grid>
</ModalForm>
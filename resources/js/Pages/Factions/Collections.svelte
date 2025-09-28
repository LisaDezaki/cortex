<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import Grid				from '@/Components/Core/Grid.svelte'
	import CardNew			from '@/Components/UI/CardNew.svelte'
	import CollectionCard	from '@/Components/UI/CollectionCard.svelte'
	import Empty			from '@/Components/UI/Empty.svelte'
	import PageHeader		from '@/Components/UI/PageHeader.svelte'
	import Section			from '@/Components/UI/Section.svelte'

	
	//	Page props

	import CollectionList from '@/services/CollectionList'
	const collections = new CollectionList($page.props.collections?.data, 'factions')


	//	State & derived states

	let rowSize   = $state(10)
	let gridRows = $derived(16-rowSize)

</script>



<svelte:head>
    <title>Faction Collections</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Faction Collections"
			tabs={[
				{ label: "List",			href: route('factions') },
				{ label: "Collections", 	active: true },
				{ label: "Settings", 		href: route('factions.settings') },
			]}
		/>
	{/snippet}

	{#snippet article()}

		<Section gap={6} class="p-12">
			{#if collections.items?.length > 0}

				<Grid cols={gridRows} gap={6}>
					{#each collections.items as collection}
						<CollectionCard
							collection={collection}
							aspect="square"
							icon="User"
							href={route('collections.show', {collection: collection.slug})}
							title={collection.name}
							subtitle="{collection.items_count} faction{collection.items_count !== 1 ? "s" : ""}"
							options={[
								{ label: "View",     icon: "Eye", 		href: collection.routes.show },
								{ label: "Rename",   icon: "Textbox", 	onclick: () => collection.rename() },
								{ separator: true },
								{ label: "Add Tags", icon: "TagSimple", onclick: () => collection.applyTags() },
								{ separator: true },
								{ label: "Delete",	 icon: "Trash",		onclick: () => collection.delete(), theme: "danger" }
							]}
						/>
					{/each}
					<CardNew
						aspect="square"
						icon="Plus"
						onclick={() => collections.create()}
					/>
				</Grid>
				
			{:else}

				<Empty
					icon="FolderSimple"
					message="There are no faction collections for this project yet."
					buttonLabel="Create one?"
					buttonClick={() => collections.create()}
				/>

			{/if}
		</Section>

	{/snippet}

</AuthenticatedLayout>
<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	
	import { Grid } from '@/Components/Core'
	import CardNew			from '@/Components/UI/CardNew.svelte'
	import CollectionCard	from '@/Components/UI/CollectionCard.svelte'
	import Empty			from '@/Components/UI/Empty.svelte'
	import PageHeader		from '@/Components/UI/PageHeader.svelte'
	import Section			from '@/Components/UI/Section.svelte'

	
	//	Page props

	const collections	= $page.props.collections?.data


	//	State

	let rowSize   = $state(8)
	let gridRows = $derived(16-rowSize)


	//	Modal Management

	import { modalActions } from '@/stores/modalStore';
	function createCollection()  { modalActions.open('createCollection') }
	function deleteCollection(c) { modalActions.open('deleteCollection', { collection: c }) }
	function renameCollection(c) { modalActions.open('renameCollection', { collection: c }) }

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
			{#if collections?.length > 0}

				<Grid cols={gridRows}>
					{#each collections as collection}
						<CollectionCard
							collection={collection}
							aspect="square"
							icon="User"
							href={route('collections.show', {collection: collection.slug})}
							title={collection.name}
							subtitle="{collection.items_count} faction{collection.items_count !== 1 ? "s" : ""}"
							options={[
								{ label: "View",   icon: "Eye", href: route('collections.show', {collection: collection.slug}) },
								{ label: "Rename", icon: "Textbox", onclick: () => renameCollection(collection) },
								{ separator: true },
								{ label: "Add Tags", icon: "TagSimple", onclick: () => applyTags(collection) },
								{ separator: true },
								{ label: "Delete Collection", icon: "Trash",		onclick: () => deleteCollection(collection), theme: "danger" }
							]}
						/>
					{/each}
					<CardNew
						aspect="square"
						icon="Plus"
						onclick={createCollection}
					/>
				</Grid>
				
			{:else}

				<Empty
					icon="FolderSimple"
					message="There are no faction collections for this project yet."
					buttonLabel="Create one?"
					buttonClick={createCollection}
				/>

			{/if}
		</Section>

	{/snippet}

</AuthenticatedLayout>
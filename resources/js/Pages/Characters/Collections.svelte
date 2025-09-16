<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'

	import CreateCollectionForm from '@/Forms/Collection/Create.svelte'
	import DeleteCollectionForm from '@/Forms/Collection/Delete.svelte'
	import RenameCollectionForm from '@/Forms/Collection/Rename.svelte'
	
	import { Grid } from '@/Components/Core'
	import CardNew				from '@/Components/UI/CardNew.svelte'
	import CollectionCard		from '@/Components/UI/CollectionCard.svelte'
	import Empty				from '@/Components/UI/Empty.svelte'
	import PageHeader			from '@/Components/UI/PageHeader.svelte'
	import Section				from '@/Components/UI/Section.svelte'

	//	Page props
	const activeProject	= $page.props.activeProject.data
	const collections	= $page.props.collections?.data
	const customFields	= $page.props.customFields?.data
	const tags			= $page.props.tags?.data
	const characters    = activeProject?.characters
	const factions      = activeProject?.factions
	const locations     = activeProject?.locations

	//	Form
	const addToCollectionForm = useForm({
		items: [{ id: null, type: 'characters' }]
	})
	const addToCollection = (char, coll) => {
		$addToCollectionForm.items[0]  = { id: char.id, type: 'characters' }
		$addToCollectionForm.patch(
			route('collections.update', { collection: coll.slug })
		)
	}

	//	Modals
	let addingToCollection	= $state(false)
	let applyingTags		= $state(false)
	let creatingCollection	= $state(false)
	let deletingCollection	= $state(false)
	let renamingCollection	= $state(false)

	const applyTags			= (c) => { selectedCollection = c; applyingTags 	  = true }
	const createCollection	= (c) => { selectedCollection = c; creatingCollection = true }
	const deleteCollection	= (c) => { selectedCollection = c; deletingCollection = true }
	const renameCollection	= (c) => { selectedCollection = c; renamingCollection = true }
	const closeModal		= ( ) => { selectedCollection	= null
										addingToCollection	= false
										applyingTags 		= false
										creatingCollection	= false
										deletingCollection	= false
										renamingCollection	= false
									}

	
	

	//	State
	let selectedCollection	= $state(null)
	let rowSize				= $state(8)

	//	Derived
	let gridRows = $derived(16-rowSize)

</script>

<svelte:head>
    <title>Character Collections</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Character Collections"
			tabs={[
				{ label: "List",			href: route('characters') },
				{ label: "Collections", 	active: true },
				{ label: "Settings", 		href: route('characters.settings') },
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
							subtitle="{collection.items_count} character{collection.items_count !== 1 ? "s" : ""}"
							options={[
								{ icon: "Eye", 		 label: "View", 			 href: route('collections.show', {collection: collection.slug}) },
								{ icon: "Textbox", 	 label: "Rename", 			 onclick: () => renameCollection(collection) },
								{ separator: true },
								{ icon: "TagSimple", label: "Add Tags", 		 onclick: () => applyTags(collection) },
								{ separator: true },
								{ icon: "Trash", 	 label: "Delete Collection", onclick: () => deleteCollection(collection), theme: "danger" }
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
					message="There are no character collections for this project yet."
					buttonLabel="Create one?"
					buttonClick={createCollection}
				/>

			{/if}
		</Section>

	{/snippet}

</AuthenticatedLayout>





<CreateCollectionForm isOpen={creatingCollection} entity={selectedCollection} type="characters"
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['collections']}
/>
<DeleteCollectionForm isOpen={deletingCollection} collection={selectedCollection}
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['collections']}
/>
<RenameCollectionForm isOpen={renamingCollection} collection={selectedCollection}
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['collections']}
/>
<script>
	import { Link, page, router, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'

	import ApplyTagsForm		from '@/Forms/Tags/Apply.svelte'
	import CreateCollectionForm from '@/Forms/Collection/Create.svelte'
	import DeleteCollectionForm from '@/Forms/Collection/Delete.svelte'
	import RenameCollectionForm from '@/Forms/Collection/Rename.svelte'
	
	import { Flex, Grid, Stack } from '@/Components/Core'
	import Card					from '@/Components/UI/Card.svelte'
	import CardNew				from '@/Components/UI/CardNew.svelte'
	import CollectionCard		from '@/Components/UI/CollectionCard.svelte'
	import Dropdown				from '@/Components/UI/Dropdown.svelte'
	import Icon					from '@/Components/UI/Icon.svelte'
	import Input				from '@/Components/UI/Input.svelte'
	import Modal				from '@/Components/UI/Modal.svelte'
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
				{ icon: "ListBullets",	label: "List",			href: route('characters') },
				{ icon: "SquaresFour",	label: "Collections", 	active: true },
				{ icon: "GearFine",		label: "Settings", 		href: route('characters.settings') },
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
				<Stack align="center" class="w-full">
					<p class="mt-12 font-style-placeholder">There are no character collections for this project yet.</p>
					<button class="mt-3 px-2 py-1 rounded text-accent hover:bg-accent-softest hover:underline" onclick={createCollection}>Create one?</button>
				</Stack>
			{/if}
		</Section>

	{/snippet}

</AuthenticatedLayout>

<!-- <Modal title="Apply Tags" show={applyingTags} maxWidth="lg"
	onclose={closeModal}>
	<ApplyTagsForm type="collections" entity={selectedCollection || null}
		onSuccess={closeModal} />
</Modal> -->

<Modal title="Create Collection" show={creatingCollection} maxWidth="lg"
	onclose={closeModal}>
	<CreateCollectionForm type="characters" entity={selectedCollection || null}
		onSuccess={closeModal} reloadPageProps={['collections']} />
</Modal>

<Modal title="Delete {selectedCollection?.name}?" show={deletingCollection} maxWidth="lg"
	onclose={closeModal}>
	<DeleteCollectionForm collection={selectedCollection || null}
		onSuccess={closeModal} reloadPageProps={['collections']} />
</Modal>

<Modal title="Rename {selectedCollection?.name}?" show={renamingCollection} maxWidth="lg"
	onclose={closeModal}>
	<RenameCollectionForm collection={selectedCollection || null}
		onSuccess={closeModal} reloadPageProps={['collections']} />
</Modal>
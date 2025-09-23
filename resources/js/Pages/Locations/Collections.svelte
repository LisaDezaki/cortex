<script>
	import { page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'
	
	import { Grid } from '@/Components/Core'
	import CardNew				from '@/Components/UI/CardNew.svelte'
	import CollectionCard		from '@/Components/UI/CollectionCard.svelte'
	import Empty				from '@/Components/UI/Empty.svelte'
	import PageHeader			from '@/Components/UI/PageHeader.svelte'
	import Section				from '@/Components/UI/Section.svelte'

	//	Page props

	const collections	= $page.props.collections?.data

	//	Form

	//	State

	let rowSize	 = $state(8)
	let gridRows = $derived(16-rowSize)


	//	Modal Management

	import { modalActions } from '@/stores/modalStore';
	function createCollection()  { modalActions.open('createCollection') }
	function deleteCollection(c) { modalActions.open('deleteCollection', { collection: c }) }
	function renameCollection(c) { modalActions.open('renameCollection', { collection: c }) }

</script>

<svelte:head>
    <title>Location Collections</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			title="Location Collections"
			tabs={[
				{ label: "List",			href: route('locations') },
				{ label: "Collections", 	active: true },
				{ label: "Settings", 		href: route('locations.settings') },
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
							subtitle="{collection.items_count} location{collection.items_count !== 1 ? "s" : ""}"
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
					message="There are no location collections for this project yet."
					buttonLabel="Create one?"
					buttonClick={createCollection}
				/>

			{/if}
		</Section>

	{/snippet}

</AuthenticatedLayout>

<!-- <Modal title="Apply Tags" show={applyingTags} maxWidth="lg"
	onclose={closeModal}>
	<ApplyTagsForm type="collections" entity={selectedCollection || null}
		onSuccess={closeModal} />
</Modal> -->



<!-- <CreateCollectionForm isOpen={creatingCollection} entity={selectedCollection} type="locations"
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['collections']}
/>
<DeleteCollectionForm isOpen={deletingCollection} collection={selectedCollection}
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['collections']}
/>
<RenameCollectionForm isOpen={renamingCollection} collection={selectedCollection}
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['collections']}
/> -->



<!-- <Modal title="Create Collection" show={creatingCollection} maxWidth="lg"
	onclose={closeModal}>
	<CreateCollectionForm type="locations" entity={selectedCollection || null}
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
</Modal> -->
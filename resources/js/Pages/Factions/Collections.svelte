<script>
	import { Link, page, router, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

    import AuthenticatedLayout	from '@/Layouts/AuthenticatedLayout.svelte'

	import ApplyTagsForm		from '@/Forms/Tags/Apply.svelte'
	import CreateCollectionForm from '@/Forms/Collection/Create.svelte'
	import DeleteCollectionForm from '@/Forms/Collection/Delete.svelte'
	import RenameCollectionForm from '@/Forms/Collection/Rename.svelte'
	
	import { Flex, Grid, Stack } from '@/Components/Core'
	import Card				from '@/Components/UI/Card.svelte'
	import CardNew			from '@/Components/UI/CardNew.svelte'
	import CollectionCard	from '@/Components/UI/CollectionCard.svelte'
	import Dropdown			from '@/Components/UI/Dropdown.svelte'
	import Empty			from '@/Components/UI/Empty.svelte'
	import Icon				from '@/Components/UI/Icon.svelte'
	import Input			from '@/Components/UI/Input.svelte'
	import Modal			from '@/Components/UI/Modal.svelte'
	import PageHeader		from '@/Components/UI/PageHeader.svelte'
	import Section			from '@/Components/UI/Section.svelte'

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
		'collectionable_id': null,
		'collectionable_type': 'characters'
	})
	const addToCollection = (char, coll) => {
		$addToCollectionForm.collectionable_id  = char.id
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
	let activeTab = $state('list')
	let selectedCollection = $state(null)
	let columns   = $state(['name', 'faction', 'relationships', 'location'])
	let filter    = $state('')
	let layout    = $state('grid')
	let query     = $state('')
	let rowSize   = $state(8)
	let sortBy    = $state('name')
	let sortOrder = $state('asc')

	//	Derived
	let gridRows = $derived(16-rowSize)
	// let hasFilter     = $derived(Boolean(filter))
	// let characterList = $derived(
	// 	characters
	// 		.filter(c => {
	// 			if (query.length > 0 && !c.name.toLowerCase().includes(query.toLowerCase())) { return false }
	// 			if (filter === 'faction' && c.factions[0]?.name !== filter.value) { return false }
	// 			if (filter === 'location' && c.location?.name !== filter.value) { return false }
	// 			if (filter === 'relationship' && !c.relationships?.map(r => r.name).includes(filter.value)) { return false }
	// 			if (!['Faction', 'Location', 'Relationship'].includes(filter.name) && filter.value && c.customFieldValues?.find(f => f.field?.label === filter.name)?.value !== filter.value) { return false }
	// 			return true
	// 		}).sort((a, b) => {
	// 			if (sortBy === 'name')       { return a.name                 < b.name                 ? -1 : 1 }
	// 			if (sortBy === 'alias')      { return a.alias                < b.alias                ? -1 : 1 }
	// 			if (sortBy === 'popularity') { return a.relationships.length > b.relationships.length ? -1 : 1 }
	// 			if (sortBy === 'faction')    { return a.factions?.[0]?.name  < b.factions?.[0]?.name  ? -1 : 1 }
	// 			if (sortBy === 'location')   { return a.location?.name       < b.location?.name       ? -1 : 1 }
	// 			if (sortBy === 'created_at') { return a.meta.createdAt       < b.meta.createdAt       ? -1 : 1 }
	// 			if (sortBy === 'updated_at') { return a.meta.updatedAt       < b.meta.updatedAt       ? -1 : 1 }
	// 			if (sortBy === 'random')     { return Math.random()          < 0.5                    ? -1 : 1 }
	// 		})
	// )
	// let characterListSorted = $derived( sortOrder == 'asc' ? characterList : characterList.reverse())

	// function mapToFilterItem(item) {
	// 	return {
	// 		label: (item.label || item.name),
	// 		value: (item.slug || item.value)
	// 	}
	// }

</script>

<svelte:head>
    <title>Faction Collections</title>
</svelte:head>

<AuthenticatedLayout>

	{#snippet header()}
		<PageHeader
			back={route('dashboard')}
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




<CreateCollectionForm isOpen={creatingCollection} type="factions"
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['collections']}
/>
<DeleteCollectionForm isOpen={deletingCollection} collection={selectedCollection}
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['collections']}
/>
<RenameCollectionForm isOpen={renamingCollection} collection={selectedCollection}
	onSuccess={closeModal} oncancel={closeModal} reloadPageProps={['collections']}
/>
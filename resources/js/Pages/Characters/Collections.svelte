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
	const collections = new CollectionList($page.props.collections?.data, 'characters')


	//	States & derived states

	let rowSize	 = $state(10)
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
			{#if collections.items?.length > 0}

				<Grid cols={gridRows} gap={6}>
					{#each collections.items as collection}
						<CollectionCard
							collection={collection}
							aspect="square"
							icon="User"
							href={collection.routes.show}
							title={collection.name}
							subtitle="{collection.items_count} character{collection.items_count !== 1 ? "s" : ""}"
							options={[
								{ icon: "Eye", 		 label: "View", 			 href: collection.routes.show },
								{ icon: "Textbox", 	 label: "Rename", 			 onclick: () => collection.rename() },
								{ separator: true },
								{ icon: "TagSimple", label: "Add Tags", 		 onclick: () => collection.applyTags() },
								{ separator: true },
								{ icon: "Trash", 	 label: "Delete Collection", onclick: () => collection.delete(), theme: "danger" }
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
					message="There are no character collections for this project yet."
					buttonLabel="Create one?"
					buttonClick={() => collections.create()}
				/>

			{/if}
		</Section>

	{/snippet}

</AuthenticatedLayout>
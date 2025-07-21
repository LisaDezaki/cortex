<script>

	import { Link, page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'
	
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.svelte'
	import UpdateProjectForm   from '@/Forms/UpdateProjectForm.svelte'
	import DeleteProjectForm   from '@/Forms/DeleteProjectForm.svelte'

	import Article		from '@/Components/Article.svelte'
	import Avatar 		from '@/Components/Avatar.svelte'
	import Badge		from '@/Components/Badge.svelte'
	import Breadcrumbs 	from '@/Components/Breadcrumbs.svelte'
	import Button		from '@/Components/Button.svelte'
	import Card 		from '@/Components/Card.svelte'
    import CardGrid 	from '@/Components/CardGrid.svelte'
	import Dropdown    	from '@/Components/Dropdown'
	import Form        	from '@/Components/Form'
	import Heading     	from '@/Components/Heading.svelte'
	import Modal       	from '@/Components/Modal.svelte'
	import Section     	from '@/Components/Section.svelte'
	import Table       	from '@/Components/Table'
	import Tabs        	from '@/Components/Tabs'
	import Thumbnail   	from '@/Components/Thumbnail.svelte'

	let project = $page.props.active_project?.data

	let updatingProject = $state(false)
	let deletingProject = $state(false)

	const form = useForm({
        project: project?.id,
    })

	function activateProject(e) {
		e.preventDefault();
		$form.patch(route('projects.activate', { project: project.id }))
	}
	function deactivateProject(e) {
		e.preventDefault();
		$form.post(route('projects.deactivate'))
	}
	function updateProject() {
        updatingProject = true
    }
	function deleteProject() {
        deletingProject = true
    }
	function closeModal() {
        updatingProject = false
		deletingProject = false
    }

</script>

<svelte:head>
    <title>{project?.name} Dashboard</title>
</svelte:head>

<AuthenticatedLayout>

    {#snippet header()}
		<Breadcrumbs data={[
			{ title: project?.name || 'Projects', href: "/" },
		]} />
		<Button style="plain" theme="neutral" class="border-l"
			iconSize={24} iconWeight="light" icon="Pen"   
			onclick={updateProject}
		/>
		<Button style="plain" theme="danger" class="border-l"
			iconSize={24} iconWeight="light" icon="Trash" 
			onclick={deleteProject}
		/>
    {/snippet}

	{#snippet article()}
		{#if project.image_path}
			<img
				src={project.image_path} alt={project.name}
				class="mb-4 w-full max-h-[35vh] object-cover"
			/>
		{/if}
		<Section>
			<Heading is="h2" as="h3"
				heading="Dashboard"
				subheading="Manage your project"
			/>
			<div class="flex justify-around gap-3 my-12 w-full">
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('characters')}>
					<span class="font-style-h3 opacity-60">{project.characters?.length || 0}</span>
					<span class="font-style-button">Characters</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
					<span class="font-style-h3 opacity-60">{project.dialogue?.length || 0}</span>
					<span class="font-style-button">Dialogues</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500">
					<span class="font-style-h3 opacity-60">{project.events?.length || 0}</span>
					<span class="font-style-button">Events</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('factions')}>
					<span class="font-style-h3 opacity-60">{project.factions?.length || 0}</span>
					<span class="font-style-button">Factions</span>
				</Link>
				<Link class="flex flex-col items-center justify-center rounded p-2 pb-4 w-full hover:bg-slate-500/10 hover:text-emerald-500" href={route('locations')}>
					<span class="font-style-h3 opacity-60">{project.locations?.length || 0}</span>
					<span class="font-style-button">Locations</span>
				</Link>
			</div>
		</Section>

		{#if project.characters.length > 0}
			<Section
				title="{project.name} Characters"
				subtitle="{project.characters?.length} characters"
			>
				<div items={project.characters} class="flex justify-start gap-2 pb-3 overflow-x-auto w-full">
					{#each project.characters as character}
						<Card
							class="aspect-[3/4] w-32 flex-shrink-0"
							image={character.image_path}
							icon="User"
							title={character.name}
							subtitle={character.subtitle}
							href={route('characters.show', {character: character.slug})}
						/>
					{/each}
				</div>
			</Section>
		{/if}

		{#if project.factions.length > 0}
			<Section
				title="{project.name} Factions"
				subtitle="{project.factions?.length} factions"
			>
				<div items={project.factions} class="flex justify-start gap-2 pb-3 overflow-x-auto w-full">
					{#each project.factions as faction}
						<Card
							class="aspect-square w-36 flex-shrink-0"
							image={faction.image_path}
							icon="FlagBannerFold"
							title={faction.name}
							subtitle={faction.subtitle}
							href={route('factions.show', {faction: faction.slug})}
						/>
					{/each}
				</div>
			</Section>
		{/if}

		{#if project.locations.length > 0}
			<Section
				title="{project.name} Locations"
				subtitle="{project.locations?.length} locations"
			>
				<div items={project.locations} class="flex justify-start gap-2 pb-3 overflow-x-auto w-full">
					{#each project.locations as location}
						<Card
							class="aspect-video w-56 flex-shrink-0"
							image={location.banner_path}
							icon="MapPin"
							title={location.name}
							subtitle={location.subtitle}
							href={route('locations.show', {location: location.slug})}
						/>
					{/each}
				</div>
			</Section>
		{/if}

	{/snippet}
	
</AuthenticatedLayout>

<Modal class="p-8" show={updatingProject} onclose={closeModal}>
	<UpdateProjectForm {project} oncancel={closeModal} />
</Modal>

<Modal class="p-8" show={deletingProject} onclose={closeModal}>
	<DeleteProjectForm {project} oncancel={closeModal} />
</Modal>
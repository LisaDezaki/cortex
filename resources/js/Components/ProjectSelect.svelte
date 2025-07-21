<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
    import { route } from "momentum-trail"

	// import Dropdown from '@/Components/Dropdown'
	// import Icon from '@/Components/Icon.svelte'
	// import Thumbnail from '@/Components/Thumbnail.svelte'

	let project = $page.props.active_project.data
	// let active = project.id
	let projects = $page.props.projects.data

	const form = useForm({
        project: null,
    })
	// function activateProject(project_id) {
	// 	$form.patch(route('projects.activate', { project: project_id }))
	// }

</script>


{#if project}
	<Link class="project-select" href="/">
		{#if project.image}
			<img class="project-image min-h-full min-w-full object-cover" src={project.image_path} alt={project.name} />
		{/if}
		<div class="project-details">
			<div class="project-details-text text-left -space-y-1">
				<div class="font-style-h6">{project.name}</div>
				<div class="font-style-small">{project.type || 'Project'}</div>
				<!-- <Icon name="CaretUpDown" class="ml-auto flex-grow-0" size={16} /> -->
			</div>
		</div>
	</Link>
{:else if projects.length >= 1}
	<Link class="project-select" href={route('projects')}>
		No project selected. Activate one?
	</Link>
{:else if projects.length == 0}
	<Link class="project-select" href={route('projects.create')}>
		No projects. Create one?
	</Link>
{/if}










<!-- {#if projects.length == 0 && active == null}
	<Link href={route('projects.create')} class="project-select empty">
		<div class="font-light text-center">No projects found.</div>
		<div class="font-light text-center underline text-white">Create one.</div>
	</Link>
{/if} -->

<!-- {#if projects.length > 0}

	<Link class="w-full">

		{#if active == null}
			<div class="project-select empty">
				<div class="font-light text-center">No active project.</div>
				<div class="font-light text-center underline">Activate one.</div>
			</div>
		{:else}
			{#each projects as project}
				{#if project.id == active}
					<div class="project-select">
						{#if project.image}
							<img class="project-image" src={project.image_path} alt={project.name} />
						{/if}
						<div class="project-details">
							<div class="project-details-text font-style-h6 text-left">
								<span class="inline-block flex-grow">{project.name}</span>
								<Icon name="CaretUpDown" class="ml-auto flex-grow-0" size={16} />
							</div>
						</div>
					</div>
				{/if}
			{/each}
		{/if}

		{#snippet content()}
			{#each projects as project}
				{#if project.id != active}
					<Link class="project-item" as="button"
						onclick={() => activateProject(project.id)}
					>
						<Thumbnail class="w-8" src={project.image_path} alt={project.name} />
						<span class="flex flex-col items-start w-full truncate">
							{project.name}
						</span>
					</Link>
				{/if}
			{/each}
			<Link class="flex items-center gap-3 p-2 w-full" href={route('projects')}>
				<Icon name="GlobeStand" size={24} />
				<div class="flex flex-col items-start w-full truncate">
					<div>Manage projects</div>
				</div>
			</Link>
		{/snippet}

	</Link>

{/if} -->

<style lang="postcss">

	:global(.project-select) {
		@apply relative flex items-end gap-2 mx-auto px-3 pt-2 aspect-video overflow-hidden w-full;
		@apply border border-emerald-500 rounded-lg;
		background: repeating-linear-gradient(
						-45deg,
						rgba(0,0,0,0.1),
						rgba(0,0,0,0.1) 10px,
						transparent 10px,
						transparent 20px
					);

		.project-image {
			@apply absolute inset-0 z-0;
		}

		.project-details {
			@apply absolute inset-0 flex items-end justify-start p-2 z-10;
			@apply bg-gradient-to-bl from-slate-600/0 via-slate-700/30 to-slate-800/60 text-white;
			/* @apply backdrop-blur-md; */

			.project-details-text {
				/* @apply bg-white/10 backdrop-blur-md rounded-full px-2 py-1 w-full; */
				/* @apply w-full; */
				/* @apply flex gap-1; */
				/* @apply truncate; */
			}
		}

	}

	:global(.project-select.empty) {
		@apply flex-col items-center justify-center gap-0.5;
	}

	:global(.project-select:hover) {
		@apply border-white text-white;
	}

	:global(.project-item) {
		@apply flex items-center gap-2 p-2 w-full;
		@apply rounded;
		&:hover {
			background-color: rgba(0,0,0,0.05);
		}
	}

	/* :global([data-theme="light"]) .project-select-trigger {
		@apply bg-gradient-to-b from-emerald-600 to-emerald-700;
		@apply border-emerald-900 text-white;
	}

	:global([data-theme="dark"]) .project-select-trigger {
		@apply bg-gradient-to-b from-slate-800 to-slate-900;
		@apply border-slate-950 text-white;
	} */

</style>
<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
    import { route } from "momentum-trail"

	// import Dropdown from '@/Components/Dropdown'
	// import Icon from '@/Components/Icon.svelte'
	// import Thumbnail from '@/Components/Thumbnail.svelte'

	

	const projects = $page.props.projects.data
	const activeProject = $page.props.activeProject?.data
	const form = useForm({
        project: null,
    })
	let media_banner = $derived(activeProject.media?.filter(m => m.type === 'banner')?.[0])

</script>


{#if activeProject}
	<Link class="project-select" href="/">
		{#if media_banner}
			<img class="project-image min-h-full min-w-full object-cover" src={media_banner.url} alt={activeProject.name} />
		{/if}
		<div class="project-details">
			<div class="project-details-text text-left -space-y-1">
				<div class="font-style-h6">{activeProject.name}</div>
				<div class="font-style-tiny">{activeProject.type || 'Project'}</div>
			</div>
		</div>
	</Link>
{:else if projects.length >= 1}
	<Link class="project-select text-sm" href={route('dashboard')}>
		No project selected.<br/>
		Activate one?
	</Link>
{:else if projects.length == 0}
	<Link class="project-select text-sm" href={route('projects.create')}>
		No projects.<br/>
		Create one?
	</Link>
{/if}

<style lang="postcss">

	:global(.project-select) {
		@apply relative flex items-center justify-center gap-2 mx-auto aspect-video overflow-hidden text-center w-full;
		@apply border border-emerald-500 rounded-lg;
		background: repeating-linear-gradient(
						-45deg,
						rgba(0,0,0,0.1),
						rgba(0,0,0,0.1) 10px,
						transparent 10px,
						transparent 20px
					);

		.project-image {
			@apply absolute z-0;
		}

		.project-details {
			@apply absolute inset-0 flex items-end justify-start px-2 py-1 z-10;
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
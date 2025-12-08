<script>
	import { Link, page, useForm } from '@inertiajs/svelte'
    import { route } from "momentum-trail"

	import Box from '@/Components/Core/Box.svelte'
	import Button from '@/Components/UI/Button.svelte'

	const projects = $page.props.projects.data
	const form = useForm({
        project: null,
    })

	let {
		active
	} = $props()

</script>

<Box class="project-select">
	{#if active}
		<Link class="absolute inset-0 flex items-end justify-start" href="/">
			{#if active.getMedia('banner')}
				<img class="project-image min-h-full min-w-full object-cover" src={active.getMedia('banner')?.url} alt={active.name} />
			{/if}
			<div class="project-details">
				<div class="project-details-text text-left -space-y-1">
					<div class="font-style-h6">{active.name}</div>
					<div class="font-style-tiny">{active.type || 'Project'}</div>
				</div>
			</div>
		</Link>
	{:else if projects.length >= 1}
		<Link class="absolute inset-0 flex items-center justify-center text-sm" href={route('dashboard')}>
			No project selected.<br/>
			Activate one?
		</Link>
	{:else if projects.length == 0}
		<Link class="absolute inset-0 flex items-center justify-center text-sm" href={route('projects.create')}>
			No projects.<br/>
			Create one?
		</Link>
	{/if}
	{#if active}
		<Button
			class="absolute top-1 right-1 backdrop-blur-sm bg-danger-softest rounded-full text-danger z-10"
			icon="X" iconSize="sm"
			onclick={() => active.deactivate()}
		/>
	{/if}
</Box>


<!-- <Button size="xs"
	icon="GlobeStand" iconSize="xs" iconWeight="bold"
	label="View all projects"
	class="text-xs"
	onclick={() => active.deactivate()}
/> -->



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
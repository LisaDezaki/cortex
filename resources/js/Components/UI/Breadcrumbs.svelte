<script>
	import { Link, page } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'
	// import { DropdownMenu } from "bits-ui";

	import Dropdown         from '@/Components/UI/Dropdown.svelte'
	import Icon             from '@/Components/UI/Icon.svelte'
	import Thumbnail        from '@/Components/UI/Thumbnail.svelte'

	const user = $page.props.auth?.user?.data
	const projects = $page.props.projects?.data
	const activeProject = $page.props.activeProject?.data

    let {
		class: className,
		data,
		withProject = true,
        ...restProps
    } = $props()

</script>

<div class="breadcrumbs {className}" {...restProps}>

	{#if user}
		<Link href={route('dashboard')} class="inline-flex items-center justify-center rounded-full mx-1.5 border border-transparent p-0.5 hover:border-emerald-500">
			<Thumbnail class="rounded-full w-7" src={user?.avatar?.url} alt={user.name} />
		</Link>
	{/if}

	{#if withProject && activeProject && projects}
		<Icon class="opacity-25" name="CaretRight" size={16} />

		<Dropdown
			class="breadcrumb"
			contentClass="w-52"
			label={activeProject.name}
			options={projects.map((pr => {
				return { label: project.name, value: project.id }
			}))}
		/>


		<!-- <Dropdown class="breadcrumb">
			{activeProject.name}
			<Icon class="translate-y-0.5" name="CaretDown" />
			{#snippet content()}
				<ul>
					{#each projects as project}
						<li>
							<ProjectActivator class="breadcrumb-dropdown-link" activeClass="breadcrumb-dropdown-link-active" projectId={project.id}>{project.name}</ProjectActivator>
						</li>
					{/each}
				</ul>
			{/snippet}
		</Dropdown> -->
	{/if}

    {#each data as breadcrumb, i}
		
		<Icon class="opacity-25" name="CaretRight" size={16} />

		{#if breadcrumb.href}
			<Link class="breadcrumb" href={breadcrumb.href}>{breadcrumb.title}</Link>
		{:else}
			<span class="breadcrumb">{breadcrumb.title}</span>
		{/if}

	{/each}
</div>



<style lang="postcss">

	.breadcrumbs {
		@apply flex items-center justify-start gap-2 px-4 py-2 text-sm w-full;

		:global(a),
		:global(.dropdown-trigger) {
			color: var(--text-accent);
		}
	}

	:global(.breadcrumb) {
		@apply px-1.5 py-1 rounded;
	}
	:global(a.breadcrumb),
	:global(.dropdown-trigger.breadcrumb) {
		&:hover {
			background-color: var(--bg-neutral-softest);
			color: var(--text-accent);
		}
	}

	:global(.breadcrumb-dropdown-link) {
		@apply px-1.5 py-1 rounded text-left w-full;
		&:hover {
			background-color: var(--bg-neutral-softest);
			color: var(--text-accent);
		}
	}
	:global(.breadcrumb-dropdown-link-active) {
		@apply font-semibold pointer-events-none;
		color: var(--text-accent);
	}

</style>
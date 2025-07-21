<script>

	import { Link } from '@inertiajs/svelte'
	import Icon from '@/Components/Icon.svelte'
	import Thumbnail from '@/Components/Thumbnail.svelte'

    let {
		children,
		class: className,
		icon,
		image,
		label,
        onsubmit,
		showImage,
        ...attrs
    } = $props()

</script>

<li class="panel-item">
	<Link class="panel-link {className}" {...attrs} preserveScroll>
		
		<Thumbnail class="h-8" src={image} alt={label} icon={icon} />

		<div class="flex-shrink truncate">
			{#if label}
				{label}
			{/if}
	
			{#if children}
				{@render children()}
			{/if}
		</div>


		{#if attrs.active}
			<Icon class="flex-shrink-0 ml-auto" name="ArrowRight" size={16} />
		{/if}

	</Link>
</li>

<style lang="postcss">

	.panel-item {
		@apply list-none text-sm;
	}

	:global(.panel-link) {
		@apply flex items-center justify-start gap-2 p-1 px-2 min-h-8 w-full truncate;
		&[active="true"] {
			color: var(--text-accent);
			background-color: var(--bg-accent-soft);
		}
		&:not([active="true"]):hover {
			background-color: var(--bg-neutral-soft);
		}
	}

</style>
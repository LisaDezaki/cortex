<script>
	import { Link } from '@inertiajs/svelte'
	import Icon from '@/Components/Icon.svelte';

    let {
		class: className,
		href,
		image,
		icon,
		title,
		subtitle,
        ...restProps
    } = $props()
</script>

<div class="card-item {className}" {...restProps}>

	{#if href}
		<Link class="card-link" href={href}></Link>
	{/if}

	{#if image}
		<img class="card-image" src={image} alt={title} />
	{:else if icon}
		<Icon class="card-icon" name={icon} size={32} />
	{/if}

	<div class="card-filter"></div>

	<div class="card-details">
		<span class="font-style-h5 font-semibold line-clamp-1 text-center w-full">{title}</span>
		{#if subtitle}
			<span class="font-style-regular line-clamp-1 text-center w-full">{subtitle}</span>
		{/if}
	</div>

</div>

<style lang="postcss">

	.card-item {
		@apply relative flex flex-col items-center justify-center min-w-24 rounded-lg shadow cursor-pointer;
		background-color: var(--bg-card);

		&:hover {
			.card-filter {
				@apply bg-gradient-to-bl from-transparent via-white/25 to-white/50;
			}
		}
	}

	:global(.card-link) {
		@apply absolute inset-0 z-10;
	}

	.card-details {
		@apply flex flex-col items-center justify-center absolute inset-0 px-4 pb-2;
		@apply backdrop-blur-sm rounded-md;
		color: var(--text-white);
		text-shadow: 	 1px  1px 8px rgba(0,0,0,0.2),
						 1px -1px 8px rgba(0,0,0,0.2),
						-1px  1px 8px rgba(0,0,0,0.2),
						-1px -1px 8px rgba(0,0,0,0.2);
	}

	.card-image {
		@apply absolute top-0 left-0 h-full w-full rounded-lg object-cover;
	}

	/* :global(.card-icon) {
		color: var(--text-neutral-softest);
		margin-bottom: 2rem;
	} */

</style>
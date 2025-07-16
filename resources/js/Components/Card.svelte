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
        ...attrs
    } = $props()
</script>

<div class="card-item {className}" {...attrs}>

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
		<span class="font-style-small font-semibold line-clamp-1 text-center w-full">{title}</span>
		{#if subtitle}
			<span class="font-style-label line-clamp-1 text-center w-full">{subtitle}</span>
		{/if}
	</div>

</div>

<style lang="postcss">

	.card-item {
		@apply relative flex flex-col items-center justify-center min-w-24 rounded-lg;
		background-color: var(--bg-input);

		.card-filter {
			@apply absolute top-0 left-0 h-full w-full rounded-lg transition-all;
			@apply bg-gradient-to-bl from-transparent via-slate-800/25 to-slate-950/50;
		}

		&:hover {
			background-color: var(--bg-input-hover);
			.card-filter {
				@apply bg-gradient-to-bl from-transparent via-white/25 to-white/50;
			}
		}
	}

	:global(.card-link) {
		@apply absolute inset-0 z-10;
	}

	.card-details {
		@apply flex flex-col items-start justify-end absolute bottom-1 left-1 right-1 px-2 pb-1.5;
		@apply backdrop-blur-sm text-white rounded-md;
	}

	.card-image {
		@apply absolute top-0 left-0 h-full w-full rounded-lg object-cover;
	}

	:global(.card-icon) {
		color: var(--text-label);
		margin-bottom: 1rem;
	}

</style>
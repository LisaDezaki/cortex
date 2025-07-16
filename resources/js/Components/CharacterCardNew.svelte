<script>
	import { Link } from '@inertiajs/svelte'

    let {
		class: className,
		character,
		subtitle,
        ...attrs
    } = $props()
</script>

<div class="character-card {className}" {...attrs}>

	{#if attrs.href}
		<Link class="character-link" href={attrs.href}></Link>
	{/if}

	{#if character.image_path}
		<img class="character-image" src={character.image_path} alt={character.name} />
	{/if}

	<div class="card-filter"></div>

	<div class="character-details">
		<span class="font-style-small truncate w-full">{character.name}</span>
		<span class="font-style-label truncate w-full">{subtitle || character.subtitle}</span>
	</div>

</div>

<style lang="postcss">

	.character-card {
		@apply relative aspect-[3/4] flex flex-col items-center justify-end min-w-24 rounded-lg;
		background-color: var(--bg-input);
		/* border-color: var(--border-input); */

		.card-filter {
			@apply absolute top-0 left-0 h-full w-full rounded-lg transition-all;
			@apply bg-gradient-to-bl from-transparent via-slate-800/25 to-slate-950;
		}

		&:hover {
			background-color: var(--bg-input-hover);
			/* border-color: var(--border-input-hover); */
			.card-filter {
				@apply bg-gradient-to-bl from-transparent via-white/25 to-white/50;
			}
		}

		
	}

	:global(.character-link) {
		@apply absolute inset-0 z-10;
	}

	.character-details {
		@apply flex flex-col items-start justify-end absolute bottom-0 left-0 w-full px-2 pb-2;
		@apply backdrop-blur-sm text-white rounded-b-lg;
	}

	.character-image {
		@apply absolute top-0 left-0 h-full w-full rounded-lg object-cover;
	}

</style>
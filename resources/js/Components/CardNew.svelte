<script>
	import { Link } from '@inertiajs/svelte'

	import Icon from '@/Components/Icon.svelte';

    let {
		aspect,
		class: className,
        ...restProps
    } = $props()
</script>

<button type="button" class="card-new aspect-{aspect} {className}" {...restProps}>

	<Icon class="card-new-icon" name="Plus" size={32} />

</button>

<style lang="postcss">

	.card-new {
		@apply relative aspect-square flex flex-col items-center justify-center min-w-24 rounded-lg;
		background-color: var(--bg-accent-softest);
		&:hover {
			background-color: var(--bg-accent-softer);
		}

		:global(.card-new-icon) {
			@apply aspect-square p-6 rounded-full;
			background-color: var(--bg-accent-softest);
			color: var(--text-accent);
			/* color: var(--text-neutral-softest); */
			/* margin-bottom: 1rem; */
		}

		/* .card-filter {
			@apply absolute top-0 left-0 h-full w-full rounded-lg transition-all;
			@apply bg-gradient-to-bl from-transparent via-slate-800/25 to-slate-950;
		} */
	}

	:global(.character-link) {
		@apply absolute inset-0 z-10;
	}

	/* .character-details {
		@apply flex flex-col items-start justify-end absolute bottom-0 left-0 w-full px-2 pb-2;
		color: var(--text-accent);
	} */

</style>
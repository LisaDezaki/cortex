<script>
    import { inertia } from '@inertiajs/svelte'

    import Logo from '@/Components/UI/Logo.svelte'
    import Page from '@/Components/UI/Page.svelte'
</script>

<Page class="flex flex-col items-center justify-center bg-emerald-700">
	<div class="flex flex-col items-center justify-center">
		<a use:inertia href="/">
			<Logo class="h-12 w-12 fill-emerald-400" />
		</a>
		<slot />
	</div>
</Page>
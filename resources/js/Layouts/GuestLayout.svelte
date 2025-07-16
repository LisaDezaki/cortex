<script>
    import { inertia } from '@inertiajs/svelte'

    import Logo from '@/Components/Logo.svelte'
	import Main from '../Components/Main.svelte'
    import Page from '../Components/Page.svelte'
</script>

<Page class="flex flex-col items-center justify-center bg-emerald-700">
    <div>
        <a use:inertia href="/">
            <Logo class="h-16 w-16 fill-emerald-400" />
        </a>
    </div>

    <div class="mt-6 w-full overflow-hidden bg-slate-50 px-6 py-4 shadow-md max-w-md rounded-lg">
        <slot />
    </div>
</Page>
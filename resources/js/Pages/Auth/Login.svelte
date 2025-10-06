<script>
    import GuestLayout from '@/Layouts/GuestLayout.svelte'
	import LoginForm   from '@/Forms/Auth/LoginForm.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'

    let {
        status,
    } = $props()
</script>



<svelte:head>
    <title>Log in</title>
</svelte:head>

<GuestLayout>
	<div class="bg-surface rounded-lg w-96">
		<Heading is="h1" as="h5" class="px-6 pt-3 text-neutral-softest">Login</Heading>
		{#if status}
			<div class="text-sm font-medium text-accent mb-6">
				{status}
			</div>
		{/if}
		<LoginForm />
	</div>
</GuestLayout>
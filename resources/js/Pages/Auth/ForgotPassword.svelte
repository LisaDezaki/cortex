<script>
	import GuestLayout from '@/Layouts/GuestLayout.svelte'
	import ForgotPasswordForm from '@/Forms/Auth/ForgotPasswordForm.svelte'
	import Heading from '@/Components/UI/Heading.svelte'

    let { status } = $props()
</script>



<svelte:head>
    <title>Forgot Password</title>
</svelte:head>

<GuestLayout>
	<div class="bg-surface rounded-lg w-96">
		<Heading is="h1" as="h5" class="px-6 pt-3 text-neutral-softest">Forgot Password</Heading>
		{#if status}
			<div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
				{status}
			</div>
		{/if}
		<ForgotPasswordForm />
	</div>
</GuestLayout>

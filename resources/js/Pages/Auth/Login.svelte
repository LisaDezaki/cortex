<script>
	import { useForm } from '@inertiajs/svelte'
    import { route }   from 'momentum-trail'

    import GuestLayout from '@/Layouts/GuestLayout.svelte'
	import LoginForm   from '@/Forms/Auth/LoginForm.svelte'
	import Heading     from '@/Components/UI/Heading.svelte'

    let {
        status,
    } = $props()

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    })

    const submit = (e) => {
        e.preventDefault()
        $form.post(route('login'), {
            onFinish: () => $form.reset('password'),
        })
    }
</script>

<svelte:head>
    <title>Log in</title>
</svelte:head>

<GuestLayout>
	
	<div class="bg-surface rounded-lg w-96">
		<Heading is="h1" as="h5" class="border-b px-3 py-1.5">Login</Heading>
		{#if status}
			<div class="text-sm font-medium text-accent mb-6">
				{status}
			</div>
		{/if}
		<LoginForm />
	</div>

</GuestLayout>
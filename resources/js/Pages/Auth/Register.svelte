<script>
    import GuestLayout from '@/Layouts/GuestLayout.svelte'
    import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form'
    import { inertia, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    })

    function submit(e) {
        e.preventDefault()

        $form.post(route('register'), {
            onFinish: () => $form.reset('password', 'password_confirmation'),
        })
    }
</script>

<svelte:head>
    <title>Register</title>
</svelte:head>

<GuestLayout>
    <Form title="Register" onsubmit={submit}>

		<Form.Field
			id="name"
			type="text"
			class="mt-1 block w-full"
			bind:value={$form.name}
			errors={$form.errors.name}
			label="Name"
			required
			autofocus
			autocomplete="name"
		/>

		<Form.Field
			id="email"
			type="email"
			class="mt-1 block w-full"
			bind:value={$form.email}
			errors={$form.errors.email}
			label="Email"
			required
			autocomplete="username"
		/>

		<Form.Field
			id="password"
			type="password"
			class="mt-1 block w-full"
			bind:value={$form.password}
			errors={$form.errors.password}
			label="Password"
			required
			autocomplete="current-password"
		/>

		<Form.Field
			id="password_confirmation"
			type="password"
			class="mt-1 block w-full"
			bind:value={$form.password_confirmation}
			errors={$form.errors.password_confirmation}
			label="Confirm password"
			required
			autocomplete="new-password"
		/>

        <div class="mt-4 flex items-center justify-end">
            <a
                use:inertia
                href={route('login')}
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
            >
                Already registered?
            </a>

            <Button primary class="ms-4" loading={$form.processing} disabled={$form.processing}>
                Register
            </Button>
        </div>
    </Form>
</GuestLayout>
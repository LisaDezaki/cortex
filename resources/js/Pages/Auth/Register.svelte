<script>
	import { inertia, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

    import GuestLayout from '@/Layouts/GuestLayout.svelte'
	import Form   from '@/Components/Core/Form.svelte'
    import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'

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

    <Form title="Register" onsubmit={submit} class="form-styles w-96">

		<Field
			id="name"
			type="text"
			label="Name"
			icon="TextAa"
			bind:value={$form.name}
			errors={$form.errors.name}
			required
			autofocus
			autocomplete="name"
		/>

		<Field
			id="email"
			type="email"
			label="Email"
			icon="At"
			bind:value={$form.email}
			errors={$form.errors.email}
			required
			autocomplete="username"
		/>

		<Field
			id="password"
			type="password"
			label="Password"
			icon="Password"
			bind:value={$form.password}
			errors={$form.errors.password}
			required
			autocomplete="current-password"
		/>

		<Field
			id="password_confirmation"
			type="password"
			label="Confirm password"
			icon="Password"
			bind:value={$form.password_confirmation}
			errors={$form.errors.password_confirmation}
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

            <Button style="hard" theme="accent" class="ms-4" loading={$form.processing} disabled={$form.processing} label="Register" />
        </div>
    </Form>
</GuestLayout>
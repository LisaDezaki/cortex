<script>
    import GuestLayout from '@/Layouts/GuestLayout.svelte'
    import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form'

    import { inertia, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

    let {
        canResetPassword,
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
	
    {#if status}
        <div class="mb-4 text-sm font-medium text-green-600">
            {status}
        </div>
    {/if}

    <Form title="Log in" onsubmit={submit}>

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
			id="remember"
			type="checkbox"
			class="mt-4 block w-full"
			bind:value={$form.remember}
			errors={$form.errors.remember}
			labelText="Remember me"
		/>

        <div class="mt-4 flex items-center justify-end">
            {#if canResetPassword}
                <a
                    use:inertia
                    href={route('password.request')}
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                >
                    Forgot your password?
                </a>
            {/if}

            <Button primary class="ms-4" loading={$form.processing} disabled={$form.processing} type="submit">Log in</Button>
        </div>
    </Form>
</GuestLayout>
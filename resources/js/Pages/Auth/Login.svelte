<script>
	import { inertia, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

    import GuestLayout from '@/Layouts/GuestLayout.svelte'
    import Button from '@/Components/Button.svelte'
    import Card from '@/Components/Card.svelte'
	import Form from '@/Components/Form.svelte'
    import Field from '@/Components/Field.svelte'
    import Input from '@/Components/Input.svelte'

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

		console.log('submitting login request')

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
        <div class="text-sm font-medium text-green-600 mb-6">
            {status}
        </div>
    {/if}

	<Form title="Log in" onsubmit={submit} class="form-styles w-96">

		<Field
			id="email"
			type="email"
			label="Email"
			icon="At"
			bind:value={$form.email}
			errors={$form.errors.email}
			autocomplete="username"
			autofocus
			required
		/>

		<Field
			id="password"
			type="password"
			label="Password"
			icon="Password"
			bind:value={$form.password}
			errors={$form.errors.password}
			autocomplete="current-password"
			required
		/>

		<Field
			id="remember"
			type="checkbox"
			class="mt-4"
			bind:value={$form.remember}
			labelText="Remember me"
			errors={$form.errors.remember}
		/>

		<div class="flex items-center justify-end gap-3 mt-6">
			{#if canResetPassword}
				<a
					use:inertia
					href={route('password.request')}
					class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
				>
					Forgot your password?
				</a>
			{/if}

			<Button style="hard" theme="accent" class="ml-4"
				type="submit" 
				label="Log in"
				loading={$form.processing}
				disabled={$form.processing}
			/>
		</div>
	</Form>
</GuestLayout>
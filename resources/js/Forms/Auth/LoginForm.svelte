<script>

	import { inertia, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Form		from '@/Components/Core/Form.svelte'
	import Stack	from '@/Components/Core/Stack.svelte'
    import Button	from '@/Components/UI/Button.svelte'
    import Field	from '@/Components/UI/Field.svelte'

    let {
        canResetPassword,
        status,
    } = $props()

	let loginForm = useForm({
		email: '',
        password: '',
        remember: false,
	})

</script>





<Form
	endpoint={route('login')}
	form={loginForm}
	method="post"
>
	<Stack class="p-6" gap={3}>
		<Field name="email"
			type="email"
			icon="At"
			label="Email"
			placeholder="Email"
			autocomplete="username"
			autofocus
			required
		/>
	
		<Field name="password"
			type="password"
			icon="Password"
			label="Password"
			placeholder="Password"
			autocomplete="current-password"
			required
		/>
	
		<Field name="remember"
			type="checkbox"
			class="ml-3"
			labelText="Remember me"
		/>
	</Stack>

	<div class="flex items-center justify-end gap-3 p-1.5">
		{#if canResetPassword}
			<a
				use:inertia
				href={route('password.request')}
				class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
			>
				Forgot your password?
			</a>
		{/if}

		<Button style="hard" theme="accent"
			class="ml-4 w-full"
			size="lg"
			type="submit" 
			label="Log in"
		/>
	</div>
</Form>
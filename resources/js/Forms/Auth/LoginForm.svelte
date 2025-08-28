<script>

	import { inertia, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Form    from '@/Components/Core/Form.svelte'
    import Button      from '@/Components/UI/Button.svelte'
    import Field       from '@/Components/UI/Field.svelte'

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

	<Field name="email"
		type="email"
		label="Email"
		icon="At"
		autocomplete="username"
		autofocus
		required
	/>

	<Field name="password"
		type="password"
		label="Password"
		icon="Password"
		autocomplete="current-password"
		required
	/>

	<Field name="remember"
		type="checkbox"
		class="mt-2 ml-4"
		labelText="Remember me"
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

		<Button style="hard" theme="accent" class="ml-4 w-full"
			type="submit" 
			label="Log in"
		/>
	</div>
</Form>
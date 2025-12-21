<script>
	import { Link, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Flex		from '@/Components/Core/Flex.svelte'
	import Form		from '@/Components/Core/Form.svelte'
	import Stack	from '@/Components/Core/Stack.svelte'
    import Button	from '@/Components/UI/Button.svelte'
    import Field	from '@/Components/UI/Field.svelte'

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
	<Stack class="px-6 py-3" gap={3}>
		<Field name="email" type="email"
			label="Email" labelIcon="At"
			placeholder="Email"
			autocomplete="email"
			autofocus
			required
		/>
	
		<Field name="password" type="password"
			label="Password" labelIcon="Password"
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

	<Stack gap={3} class="gap-3 px-6 pb-3">

		<Button style="hard" theme="accent"
			size="lg"
			type="submit" 
			text="Log in"
		/>

		<Flex justify="center" gap={6} class="w-full">
			<Link
				href={route('password.request')}
				class="place-self-center font-style-small text-accent hover:underline"
			>
				I forgot my password
			</Link>
	
			<Link
				href={route('register')}
				class="place-self-center font-style-small text-accent hover:underline"
			>
				I don't have an account
			</Link>
		</Flex>

	</Stack>
</Form>
<script>
	import { Link, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Flex		from '@/Components/Core/Flex.svelte'
	import Form		from '@/Components/Core/Form.svelte'
	import Stack	from '@/Components/Core/Stack.svelte'
    import Button	from '@/Components/UI/Button.svelte'
    import Field	from '@/Components/UI/Field.svelte'

	let registerForm = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    })

</script>



<Form
	endpoint={route('register')}
	form={registerForm}
	method="post"
>
	<Stack class="px-6 py-3" gap={3}>
		<Field name="name"
			type="text"
			label="Name"
			placeholder="Username"
			autocomplete="name"
			required
			autofocus
		/>
	
		<Field name="email"
			type="email"
			label="Email"
			icon="At"
			autocomplete="email"
			required
		/>
	
		<Field name="password"
			type="password"
			label="Password"
			icon="Password"
			autocomplete="current-password"
			required
		/>
	
		<Field name="password_confirmation"
			type="password"
			label="Confirm password"
			icon="Password"
			autocomplete="new-password"
			required
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
				href={route('login')}
				class="place-self-center font-style-small text-accent hover:underline"
			>
				I already have an account
			</Link>
		</Flex>

	</Stack>
</Form>
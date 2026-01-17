<script>
	import { Link, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Flex		from '@/Components/Core/Flex.svelte'
	import Form		from '@/Components/Core/Form.svelte'
	import Stack	from '@/Components/Core/Stack.svelte'
    import Button	from '@/Components/UI/Button.svelte'
    import Field	from '@/Components/UI/Field.svelte'
    import Icon		from '@/Components/UI/Icon.svelte'

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

		<Flex align="center" justify="center" class="aspect-square bg-accent-softest min-h-24 place-self-center p-3 relative rounded-full">
			<Icon name="UserList" size={32} weight="thin" class="text-accent" />
			<Flex align="center" justify="center" class="absolute inset-0 border-accent rounded-full {$registerForm.processing ? 'animate-spin border-t border-r' : ''}"></Flex>
		</Flex>

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
			icon="At" label="Email"
			autocomplete="email"
			required
		/>
	
		<Field name="password"
			type="password"
			icon="Password" label="Password"
			placeholder="Password"
			required
		/>
	
		<Field name="password_confirmation"
			type="password"
			label="Confirm password"
			icon="Password"
			required
		/>
	</Stack>

	<Stack gap={3} class="gap-3 px-6 pb-3">

		<Button style="hard" theme="accent"
			size="lg"
			type="submit" 
			text="Register"
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
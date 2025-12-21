<script>
	import { Link, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Flex		from '@/Components/Core/Flex.svelte'
	import Form		from '@/Components/Core/Form.svelte'
	import Stack	from '@/Components/Core/Stack.svelte'
    import Button	from '@/Components/UI/Button.svelte'
    import Field	from '@/Components/UI/Field.svelte'

	let forgotPasswordForm = useForm({
		email: '',
	})

</script>



<Form
	endpoint={route('login')}
	form={forgotPasswordForm}
	method="post"
>
	<Stack class="px-6 py-3" gap={3}>
		
		<Field name="email"
			type="email"
			icon="At"
			placeholder="Email"
			required
			autocomplete="email"
		/>

		<Button style="hard" theme="accent"
			class="w-full {$forgotPasswordForm.processing && 'opacity-25'}"
			disabled={$forgotPasswordForm.processing}
			text="Email Password Reset Link"
		/>

		<Flex justify="center" gap={6} class="w-full">
			<Link
				href={route('login')}
				class="place-self-center font-style-small text-accent hover:underline"
			>
				Wait, I remembered it
			</Link>
		</Flex>

	</Stack>
</Form>
<script>
	import { Link, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Flex		from '@/Components/Core/Flex.svelte'
	import Form		from '@/Components/Core/Form.svelte'
	import Stack	from '@/Components/Core/Stack.svelte'
    import Button	from '@/Components/UI/Button.svelte'
    import Field	from '@/Components/UI/Field.svelte'

	let resetPasswordForm = useForm({
		email: '',
        password: '',
        password_confirmation: '',
	})

</script>



<Form
	endpoint={route('reset-password')}
	onsubmit={submit}
	class="form-styles w-96"
>
	<Stack class="px-6 py-3" gap={3}>
		<Field name="email"
			type="email"
			label="Email"
			placeholder="Email"
			autocomplete="email"
			autofocus
			required
		/>

		<Field name="password"
			type="password"
			label="Password"
			placeholder="Password"
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

		<Flex justify="center" gap={6} class="w-full">
			<Link
				href={route('login')}
				class="place-self-center font-style-small text-accent hover:underline"
			>
				Wait, I remembered it!
			</Link>
		</Flex>

		<Button style="hard" theme="accent"
			size="lg"
			type="submit" 
			text="Reset Password"
		/>

	</Stack>






	<!-- <div>
		<Form.Label for="email" value="Email" />
		<Form.Input
			id="email"
			type="email"
			bind:value={$form.email}
			required
			autofocus
			autocomplete="username"
		/>
		<Form.Error class="mt-2" message={$form.errors.email} />
	</div>

	<div class="mt-4">
		<Form.Label for="password" value="Password" />
		<Form.Input
			id="password"
			type="password"
			bind:value={$form.password}
			required
			autocomplete="new-password"
		/>
		<Form.Error class="mt-2" message={$form.errors.password} />
	</div>

	<div class="mt-4">
		<Form.Label for="password_confirmation" value="Confirm Password" />

		<Form.Input
			id="password_confirmation"
			type="password"
			bind:value={$form.password_confirmation}
			required
			autocomplete="new-password"
		/>

		<Form.Error class="mt-2" message={$form.errors.password_confirmation} />
	</div>

	<div class="mt-4 flex items-center justify-end">
		<Button primary class={$form.processing && 'opacity-25'} disabled={$form.processing}
			>Reset Password</Button
		>
	</div> -->
</Form>
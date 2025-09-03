<script>
    import { page, router, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Grid, Stack }   from '@/Components/Core'
	import Button from '@/Components/UI/Button.svelte'
	import Card from '@/Components/UI/Card.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import CharacterCard from '@/Components/Features/Character/CharacterCard.svelte'

    let {
		type,
		entity,
		oncancel = () => {},
	} = $props()

	const form = useForm({
		collection_type: type,
		name: '',
		description: '',
	});

</script>



<!-- {#if entity && entity.slug} -->

	<Form
		class="max-w-lg"
		enctype="multipart/form-data"
		endpoint={route('collections.store')}
		form={form}
		method="post"
		processing={$form.processing}
		recentlySuccessful={$form.recentlySuccessful}
		reloadPageProps={['collections']}
		onFinish={oncancel}
	>
		<Stack class="p-3">
			Adding to collection
		</Stack>

		<Flex gap={0} class="border-t flex-0 min-h-12">
			<Button style="hard" theme="neutral" class="border-none rounded-none w-1/2"
				type="button"
				label="Cancel"
				onclick={oncancel}
			/>
			<Button style="hard" theme="accent" class="border-none rounded-none w-1/2"
				type="submit"
				label="Confirm"
			/>
		</Flex>

	</Form>

<!-- 
{:else}

	<div class="p-3">
		<p class="font-style-placeholder">The form couldn't display correctly because no entity was provided.</p>
	</div>

{/if} -->
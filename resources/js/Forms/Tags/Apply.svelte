<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Flex, Form, Stack }   from '@/Components/Core'
	import Button	from '@/Components/UI/Button.svelte'
	import Field	from '@/Components/UI/Field.svelte'
	import Tag  	from '@/Components/UI/Tag.svelte'

    let {
		oncancel = () => {},
		entity
	} = $props()

	const form = useForm({
		entity_id: 		entity?.id,
		entity_type: 	entity?.type,
		tags_list: 		entity?.tags || []
	});

	//	TODO: This needs to work with any entity it's given, like the Collections form.

</script>

{#if entity && entity.slug}

	<Form
		class="max-w-lg"
		enctype="multipart/form-data"
		endpoint={route('characters.update', { character: entity.slug})}
		form={form}
		method="patch"
		processing={$form.processing}
		recentlySuccessful={$form.recentlySuccessful}
	>
		<Stack class="p-3" gap={3}>
			<Field type="text"
				name="name"
				placeholder="Search tags"
				required
				autofocus
			/>
			<Flex wrap class="min-h-10">
				{#each entity.tags?.split(',') as tag}
					<Tag label={tag} />
				{/each}
				<Button style="soft" theme="accent"
					icon="Plus" label="New" class="rounded-full"
				/>
			</Flex>
		</Stack>

		<Flex gap={0} class="border-t flex-0 min-h-12">
			<Button style="hard" theme="neutral" class="border-none rounded-none w-1/2"
				type="button"
				label="Cancel"
				onclick={oncancel}
			/>
			<Button style="hard" theme="accent" class="border-none rounded-none w-1/2"
				type="submit"
				label="Apply tags"
			/>
		</Flex>

	</Form>

{:else}

	<div class="p-3">
		<p class="font-style-placeholder">The form couldn't display correctly because no entity was provided.</p>
	</div>

{/if}
<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Box, Flex, Stack, UploadContext } from '@/Components/Core'
	import Field	 from '@/Components/UI/Field.svelte'
	import Heading	 from '@/Components/UI/Heading.svelte'
	import ModalForm from '@/Components/UI/ModalForm.svelte'
	import Tag		 from '@/Components/UI/Tag.svelte'
    import clsx from 'clsx'

    let {
		endpoint,
		location,
		method,
		options = [],
		tags = $bindable([]),
		title = "Set Tags"
	} = $props()

	const form = useForm({
		tags: tags
	})

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		active: clsx('bg-accent-softest text-accent'),
		tag: 	clsx('bg-neutral-softest text-neutral-soft hover:text-neutral'),
	})

	function toggleTag(tag) {
		let isActive = $form.tags?.includes(tag)
		$form.tags = isActive
			? [...$form.tags.filter(t => t !== tag) ]
			: [...$form.tags, tag ]
	}

</script>



<ModalForm
	endpoint={endpoint}
	form={form}
	method="patch"
	size="xl"
	submitProps={{
		label: 'Save'
	}}
	title={title}
>
	<Stack gap={3} class="max-h-[60vh] overflow-y-auto px-6 py-3">
		<Heading is="h4" as="h6" class="text-neutral-softer">All tags</Heading>
		<Stack>
			{#each ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'] as letter}
				<Flex align="start" class="border-b p-1">
					<Box class="sticky top-0 min-w-8 max-w-8 w-8 text-neutral-softest text-lg">{letter.toUpperCase()}</Box>
					<Flex wrap>
						{#each options.filter(opt => opt.substr(0,1).toLowerCase() === letter) as option}
							<Tag class="{$form.tags.includes(option) ? cx.active : cx.tag} cursor-pointer m-0.5" onclick={() => toggleTag(option)}>{option}</Tag>
						{/each}
					</Flex>
				</Flex>
			{/each}
		</Stack>
	</Stack>
</ModalForm>
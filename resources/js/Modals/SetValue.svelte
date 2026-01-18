<script>
    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Box, Flex, Inline, Stack, UploadContext } from '@/Components/Core'
	import Map	  from '@/Components/Core/Map'
	import Button from '@/Components/UI/Button.svelte'
	import Field  from '@/Components/UI/Field.svelte'
	import Input  from '@/Components/UI/Input'
	import ModalForm from '@/Components/UI/ModalForm.svelte'

    let {
		entity,
		field,
		label,
		title = 'Set Value',
		...restProps
	} = $props()

	const form = useForm({
		[field.name]: entity[field.name] || '',
	})

</script>



<ModalForm title={title} size={field.type === 'textarea' ? '2xl' : 'md'}
	form={form}
	method="patch"
	submitProps={{ label: 'Save' }}
{...restProps}>
	<Box class="px-2">
		{#if field.type === 'textarea'}
			<Flex gap={3} class="mb-3">
				<Input.Select
					bind:value={form[field.name + '_format']}
					options={[
						{ label: 'Heading 1', value: 'h1' },
						{ label: 'Heading 2', value: 'h2' },
						{ label: 'Heading 3', value: 'h3' },
						{ label: 'Heading 4', value: 'h4' },
						{ label: 'Heading 5', value: 'h5' },
						{ label: 'Heading 6', value: 'h6' },
						{ label: 'Normal', value: 'p' },
						{ label: 'Code', value: 'code' },
						{ label: 'Quote', value: 'blockquote' },
					]}
					placeholder="Style"
					size="sm"
				/>
				<Inline class="border rounded">
					<Button size="sm" icon="TextAa" />
					<Button size="sm" icon="TextAUnderline" />
				</Inline>
				<Inline class="border rounded">
					<Button size="sm" icon="TextB" />
					<Button size="sm" icon="TextItalic" />
					<Button size="sm" icon="TextStrikethrough" />
					<Button size="sm" icon="TextUnderline" />
				</Inline>
				<Inline class="border rounded">
					<Button size="sm"icon="TextAlignLeft" />
					<Button size="sm"icon="TextAlignCenter" />
					<Button size="sm"icon="TextAlignRight" />
					<Button size="sm"icon="TextAlignJustify" />
				</Inline>
				<Inline class="border rounded">
					<Button size="sm" icon="ListBullets" />
					<Button size="sm" icon="ListNumbers" />
				</Inline>
				<Inline class="border rounded">
					<Button size="sm" icon="Code" />
					<Button size="sm" icon="Link" />
				</Inline>
			</Flex>
		{/if}
		<Field {...field} autofocus={true} label={undefined} />
	</Box>
</ModalForm>
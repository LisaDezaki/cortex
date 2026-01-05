<script>
	import { onMount } from 'svelte'
    import { page, router, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Box 			from '@/Components/Core/Box.svelte'
	import Flex 		from '@/Components/Core/Flex.svelte'
	import Form 		from '@/Components/Core/Form.svelte'
	import Inline 		from '@/Components/Core/Inline.svelte'
	import ReorderableList from '@/Components/Core/ReorderableList.svelte'
	import Stack 		from '@/Components/Core/Stack.svelte'

	import Button       from '@/Components/UI/Button.svelte'
	import DragHandle   from '@/Components/UI/DragHandle.svelte'
	import Field        from '@/Components/UI/Field.svelte'
	import Heading      from '@/Components/UI/Heading.svelte'
	import Icon         from '@/Components/UI/Icon.svelte'
	import Input        from '@/Components/UI/Input'
	import Label        from '@/Components/UI/Label.svelte'
	import ModalForm    from '@/Components/UI/ModalForm.svelte'

	import { modalActions } from '@/stores/modalStore';

	//  Props
    let {
		class: className,
		field,
        oncancel,
		...restProps
    } = $props()

	//  State & Reactivity
	let blankData = {
		id: null,
		type: 'text',
		name: '',
		default: '',
		description: '',
		filetype: 'image',
		label: '',
		min: '',
		max: '',
		options: [ "", "" ],
		placeholder: '',
		required: false,
		rows: ''
	}

	let multiline = $state(false)
	let inputType = $state('text')

	//  The form object needs to be reactive to changes in the data prop
	let form = useForm({...blankData, ...field})
	$effect(() => {
		for (const [key, value] of Object.entries(field || blankData)) {
			$form[key] = value
		}
	})

	onMount(() => {
		setType(field.type || 'text')
	})

	

	//  Methods
    
	function setType(type) {
		inputType = type
		$form.type = type
		// if (type !== 'select') {
		// 	$form.options = null
		// }
	}

	function setData() {
		if (field == null) { resetData(); return }
		for (const [key, value] of Object.entries(field)) {
			$form[key] = value
		}
	}

	function resetData() {
		let freshData = {
			id: null,
			...blankData
		}
		for (const [key, value] of Object.entries(freshData)) {
			$form[key] = value
		}
	}

	function addOption() {
		$form.options = [
			...$form.options,
			""
		]
	}
	function removeOption(index) {
		$form.options = $form.options.filter((option,i) => i !== index)
	}

	function toggleMultiline() {
		multiline = !multiline
	}

	function submit(e) {
		e.preventDefault()

		console.log('submitting')

		if ($form.type !== 'select') {
			$form.options = null
		}

		//  Map prop data to form data
		// if (field) {
		// 	for (const [key, value] of Object.entries(field)) {
		// 		$form[key] = value
		// 	}
		// }

		//  Map options to form data if applicable
		// $form.options = $form.type == 'select'
		// 	? $form.options
		// 	: null
		
		//  Post data to server and handle response
		if ($form.id) {
			$form.patch( route('customFields.update'), {
				onFinish: (a,b) => {
					if (restProps.reloadPageProps) {
						router.visit( $page.url, { only: restProps.reloadPageProps })
					}
					modalActions.close()
				}
			})
		} else {
			$form.post( route('customFields.store'), {
				onFinish: (a,b) => {
					if (restProps.reloadPageProps) {
						router.visit( $page.url, { only: restProps.reloadPageProps })
					}
					modalActions.close()
				}
			} )
		}
	}

</script>

<ModalForm size="xl"
	endpoint={route('customFields.store')}
	form={form}
	method="post"
	submitProps={{ label: 'Update', onclick: submit }}
{...restProps}>
	<Flex class="border-b px-4 py-3">
		<Heading is="h4" as="h6">Custom field: <span class="text-accent">{$form.label}</span></Heading>
	</Flex>

	<Flex class="flex-1 overflow-hidden p-3 pt-1.5" gap={3}>

		<Stack class="py-5 w-40">
			{#each [
				{ value: 'text',   label: 'Text',    icon: 'TextAa' },
				{ value: 'number', label: 'Number',  icon: 'Hash' },
				{ value: 'link',   label: 'Link',    icon: 'Link' },
				{ value: 'switch', label: 'Switch',  icon: 'ToggleRight' },
				{ value: 'select', label: 'Options', icon: 'RowsPlusBottom' },
				{ value: 'entity', label: 'Entity Link',	icon: 'Table' },
				{ value: 'upload', label: 'File Upload',	icon: 'File' }
			] as type}
				<button type="button"
					class="flex gap-2 pl-3 py-1.5 pr-1 rounded w-full {type.value == inputType ? 'bg-accent-softest text-emerald-500' : 'hover:bg-slate-500/10'}"
					onclick={() => setType(type.value)}
				>
					<Icon name={type.icon} size="md" weight="regular" />
					<span class="text-sm">{type.label}</span>
					{#if type.value == inputType}
						<Icon class="ml-auto" name="CaretRight" size="sm" weight="regular" />
					{/if}
				</button>
			{/each}

		</Stack>

		<Stack gap={3} class="h-full min-h-[420px] overflow-y-auto w-96">

			<!-- <pre>{JSON.stringify($form,null,3)}</pre> -->

			<!-- Data Type Disambiguation -->

			<!-- {#if inputType === 'switch'}
				<Inline>
					<Button text="Checkbox" />
					<Button text="Switch" />
					<Button text="Toggle" />
				</Inline>
			{/if} -->

			<!-- {#if inputType === 'select'}
				<Inline>
					<Button text="Radio" />
					<Button text="Select" />
				</Inline>
			{/if} -->

			<Flex gap={3}>
				
				<!-- Name -->
				<Field
					name="name"
					type="text"
					label="Name"
					placeholder="Custom field name"
					autofocus
					required
				/>
	
				<!-- Label -->
				<!-- <Field
					name="label"
					type="text"
					label="Label"
					placeholder="Custom field label"
					required
				/> -->

			</Flex>


			<!-- Placeholder -->
	
			{#if ['text', 'textarea', 'link', 'number', 'select'].includes(inputType)}
				<Field
					type="text"
					name="placeholder"
					label="Placeholder text"
					placeholder={inputType == 'number' ? "0" : "Empty"}
				/>
			{/if}

			<!-- Description -->
	
			{#if ['text', 'textarea', 'link', 'number', 'select', 'upload', 'entity'].includes(inputType)}
				<Field
					type="text"
					name="description"
					label="Description text"
					placeholder="Describe the field..."
				/>
			{/if}

			<!-- Checkbox label -->
	
			{#if ['checkbox', 'radio', 'switch'].includes(inputType)}
				<Field
					required
					type="text"
					name="label"
					errors={$form.errors.label}
					label="Descriptive label"
					placeholder="Write a descriptive label"
					bind:value={$form.label}
				/>
			{/if}

			<!-- Options -->
	
			{#if inputType == 'select'}

				<div>
					<Label
						text="Field options"
						description="There must be at least two options available."
					/>
					<ReorderableList bind:items={$form.options}>
						{#snippet itemTemplate(item, index)}
							<li class="flex items-center gap-1 w-full mb-1">
								<DragHandle item={item} />
								<Input.Text
									name="option_{index+1}"
									class="flex-grow"
									placeholder="Option {index+1}"
									bind:value={$form.options[index]}
									errors={$form.errors.options?.[index]}
								/>
								{#if $form.options.length > 2}
									<Button size="sm" style="plain" theme="danger"
										icon="X"
										onclick={() => removeOption(index)}
									/>
								{/if}
							</li>
						{/snippet}
					</ReorderableList>
					<div class="flex justify-center">
						<Button size="sm" style="soft" theme="accent" class="h-10 mx-auto w-12" type="button" icon="Plus" onclick={addOption} />
					</div>
				</div>
			{/if}

			<!-- Min. & Max. -->
	
			{#if ['number', 'slider'].includes(inputType)}
				<div class="flex items-center gap-2">
					<Field
						type="number"
						name="min"
						label="Minimum"
						placeholder={0}
						bind:value={$form.min}
						errors={$form.errors.min}
					/>
	
					<Field
						type="number"
						name="default"
						label="Default"
						placeholder={1}
						bind:value={$form.default}
						errors={$form.errors.default}
					/>
	
					<Field
						type="number"
						name="max"
						label="Maximum"
						placeholder={255}
						bind:value={$form.max}
						errors={$form.errors.max}
					/>
				</div>
			{/if}

			<!-- Entity Type -->
	
			{#if ['entity'].includes(inputType)}
				<Field
					type="select"
					name="entitytype"
					label="Entity Type"
					placeholder="Select an entity type"
					bind:value={$form.filetype}
					errors={$form.errors.filetype}
					options={[
						{ icon: 'User',				label: 'Character',		value: 'character'	},
						{ icon: 'FlagBannerFold',	label: 'Faction',		value: 'faction'	},
						{ icon: 'Backpack', 		label: 'Item',			value: 'item'		},
						{ icon: 'MapPinArea',		label: 'Location',		value: 'location'	}
					]}
				/>
			{/if}

			<!-- File Type -->
	
			{#if ['upload'].includes(inputType)}
				<Field
					type="select"
					name="filetype"
					label="File Type"
					bind:value={$form.filetype}
					errors={$form.errors.filetype}
					options={[
						{ icon: 'FileAudio', label: 'Audio',    value: 'audio'    },
						{ icon: 'FileText',  label: 'Document', value: 'document' },
						{ icon: 'FileImage', label: 'Image',    value: 'image'    },
						{ icon: 'FileVideo', label: 'Video',    value: 'video'    }
					]}
				/>
			{/if}

			<!-- Multiline -->
	
			<!-- {#if ['text', 'textarea'].includes($form.type)}
				<div class="grid grid-cols-2 items-center gap-2">
					<Field
						type="switch"
						id="multiline"
						class="pt-6"
						description="Set this to 'true' if you want the field to be taller to allow for more text."
						label="Multiline"
						bind:checked={multiline}
						onCheckedChange={toggleMultiline}
					/>
					{#if multiline}
						<Field
							type="number"
							id="rows"
							description="The number of rows that this text area will have."
							errors={$form.errors.rows}
							label="Number of rows"
							placeholder={3}
							bind:value={$form.rows}
							min={2}
							max={12}
						/>
					{/if}
				</div>
			{/if} -->

			<!-- Required -->
		
			<!-- {#if $form.type !== 'switch'}
				<Field
					type="switch"
					id="required"
					class="pt-8"
					description="Set this to 'true' if completing this field is necessary for the user to submit the form."
					errors={$form.errors.required}
					label="Required"
					bind:checked={$form.required}
				/>
			{/if} -->
			<!-- <div class="mt-auto flex-shrink-0">
				<div class="flex items-center justify-center gap-3 pt-2">
					<Button style="hard" theme="neutral"
						type="button"
						text="Cancel"
						onclick={oncancel}
					/>
					<Button style="hard" theme="accent"
						type="submit"
						text="Save Custom Field"
					/>
				</div>
			</div> -->
		</Stack>
		
	</Flex>

	<!-- <Flex gap={0} class="border-t flex-0 min-h-12">
		<Button style="hard" theme="neutral" class="border-none rounded-none px-4 w-1/2"
			type="button"
			icon="X"
			text="Cancel"
			onclick={oncancel}
		/>
		<Button style="hard" theme="accent" class="border-none rounded-none px-4 w-1/2"
			type="submit"
			icon="Check"
			text="Save"
		/>
	</Flex> -->

</ModalForm>
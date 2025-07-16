<script>

	//  Imports
    import { page, useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import Button from '@/Components/Button.svelte'
	import Form from '@/Components/Form'
	import Icon from '@/Components/Icon.svelte'

	//  Props
    let {
		class: className,
		data = $bindable(),
        oncancel
    } = $props()

	//  Form
	const form = useForm({data})

	//  State & Reactivity
	let multiline = $state(false)

	//  Methods
    function submit(e) {
        e.preventDefault()
		//  Map prop data to form data
		for (const [key, value] of Object.entries(data)) {
			$form[key] = value
		}
		//  Map options to form data if applicable
		$form.options = $form.type == 'select'
			? $form.options.map(o => o.label)
			: null

		//  Post data to server and handle response
		if (data.id) {
			$form.post( route('customfields.update', { field: data.id }, {
				onSuccess: () => {
					console.log('field updated')
					oncancel()
				}
			}) )
		} else {
			$form.post( route('customfields.store'), {
				onSuccess: (a,b) => {
					console.log('field created', a, b)
					oncancel()
				}
			} )
		}
    }

	function addOption() {
		data.options = [
			...data.options,
			{ label: '', value: '' }
		]
	}
	function removeOption(index) {
		data.options = data.options.filter((option,i) => i !== index)
	}

	function toggleMultiline() {
		multiline = !multiline
	}

</script>

<!-- <pre>{JSON.stringify(data, null, 4)}</pre> -->

<Form
	onsubmit={submit}
	enctype="multipart/form-data"
	processing={$form.processing}
	recentlySuccessful={$form.recentlySuccessful}
>
	<div class="flex-grow space-y-3">

		<div class="flex mb-4">
			{#each [
				{ value: 'text',   icon: 'TextAa' },
				{ value: 'link',   icon: 'Link' },
				{ value: 'number', icon: 'Hash' },
				{ value: 'switch', icon: 'ToggleRight' },
				{ value: 'select', icon: 'RowsPlusBottom' },
				{ value: 'entity', icon: 'Table' },
				{ value: 'upload', icon: 'ImageSquare' }
			] as type}
				<Button
					primary={data.type == type.value}
					secondary={data.type != type.value}
					onclick={() => data.type = type.value}
					icon={type.icon}
					iconSize={20}
					iconWeight="regular"
					label={type.label}
				/>
			{/each}
		</div>

		<!-- Name -->

		<Form.Field
			type="text"
			required
			id="name"
			description="The name of the field you are creating, as it will be shown in the entity form."
			errors={data.errors.name}
			label="Field name"
			placeholder="Custom field"
			bind:value={data.name}
			autofocus
		/>

		<!-- Placeholder -->

		{#if ['text', 'textarea', 'link', 'number', 'select'].includes(data.type)}
			<Form.Field
				type="text"
				id="placeholder"
				description="The placeholder text that will be shown in the field as an example to the user. This can be left empty."
				errors={data.errors.placeholder}
				label="Placeholder text"
				placeholder="Empty"
				bind:value={data.placeholder}
			/>
		{/if}

		<!-- Description -->

		{#if ['text', 'textarea', 'number', 'select', 'upload', 'entity'].includes(data.type)}
			<Form.Field
				type="text"
				id="description"
				description="A short description of the field's purpose, that will be shown as a tooltip if the user hovers on the 'help' icon, like you are now."
				errors={data.errors.description}
				label="Field description"
				placeholder="Write a description of this field's purpose..."
				bind:value={data.description}
			/>
		{/if}

		<!-- Checkbox label -->

		{#if ['checkbox', 'radio', 'switch'].includes(data.type)}
			<Form.Field
				required
				type="text"
				id="label"
				description="The label that will be shown next to the toggle switch."
				errors={data.errors.label}
				label="Descriptive label"
				placeholder="Write a descriptive label"
				bind:value={data.label}
			/>
		{/if}

		<!-- Options -->

		{#if data.type == 'select'}
			<div>
				<Form.Label
					required
					value="Field options"
					description="The available options for this field. There must be at least two options."
				/>
				<ul>
					{#each data.options as option, i}
						<li class="flex items-center w-full mb-1">
							<button class="flex items-center p-2 cursor-move">
								<Icon name="DotsSixVertical" size={24} />
							</button>
							<Form.Field
								type="text"
								id="option_{i+1}"
								class="flex-grow"
								errors={data.errors.options}
								placeholder="Option {i+1}"
								bind:value={option.label}
							/>
							{#if data.options.length > 2}
								<button class="flex items-center p-2 text-rose-500" type="button" onclick={() => removeOption(i)}>
									<Icon name="X" size={24} />
								</button>
							{/if}
						</li>
					{/each}
				</ul>
				<div class="flex justify-center">
					<Button secondary class="h-10 mx-auto w-12" type="button" icon="Plus" onclick={addOption} />
				</div>
			</div>
		{/if}

		<!-- Min. & Max. -->

		{#if ['number', 'slider'].includes(data.type)}
			<div class="flex items-center gap-2">
				<Form.Field
					type="number"
					id="min"
					description="The smallest value that this field can have."
					errors={data.errors.min}
					label="Minimum value"
					placeholder={0}
					bind:value={data.min}
				/>

				<!-- <Form.Field
					type="number"
					id="default"
					errors={data.errors.default}
					label="Default value"
					placeholder={1}
					bind:value={data.default}
				/> -->

				<Form.Field
					type="number"
					id="max"
					description="The largest value that this field can have."
					errors={data.errors.max}
					label="Maximum value"
					placeholder={255}
					bind:value={data.max}
				/>
			</div>
		{/if}

		<!-- Multiline -->

		{#if ['text', 'textarea'].includes(data.type)}
			<div class="grid grid-cols-2 items-center gap-2">
				<Form.Field
					type="switch"
					id="multiline"
					class="pt-6"
					description="Set this to 'true' if you want the field to be taller to allow for more text."
					label="Multiline"
					bind:checked={multiline}
					onCheckedChange={toggleMultiline}
				/>
				{#if multiline}
					<Form.Field
						type="number"
						id="rows"
						description="The number of rows that this text area will have."
						errors={data.errors.rows}
						label="Number of rows"
						placeholder={3}
						bind:value={data.rows}
						min={2}
						max={12}
					/>
				{/if}
			</div>
		{/if}

		<!-- Required -->
	
		{#if data.type !== 'switch'}
			<Form.Field
				type="switch"
				id="required"
				class="pt-8"
				description="Set this to 'true' if completing this field is necessary for the user to submit the form."
				errors={data.errors.required}
				label="Required"
				bind:checked={data.required}
			/>
		{/if}

	</div>

	<div class="flex-shrink-0 space-y-3 p-3 overflow-hidden">
		<div class="flex items-center justify-center gap-3 pt-3">
			<Button secondary type="button" label="Cancel" onclick={oncancel}  />
			<Button primary   type="submit" label="Save Custom Field" />
		</div>
	</div>

</Form>
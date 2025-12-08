<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

	import Flex			from '@/Components/Core/Flex.svelte'
	import Inline		from '@/Components/Core/Inline.svelte'
	import Stack		from '@/Components/Core/Stack.svelte'
	import Button		from '@/Components/UI/Button.svelte'
	import Collapsible	from '@/Components/UI/Collapsible.svelte'
	import Heading		from '@/Components/UI/Heading.svelte'
	import Icon			from '@/Components/UI/Icon.svelte'
	import Input		from '@/Components/UI/Input.svelte'
	import Media		from '@/Components/UI/Media.svelte'
	import Separator	from '@/Components/UI/Separator.svelte'
	import Sidebar		from '@/Components/UI/Sidebar.svelte'
	import Skeleton		from '@/Components/UI/Skeleton.svelte'
	import Thumbnail	from '@/Components/UI/Thumbnail.svelte'


	//	Page & Component props

	const customFields = $state($page.props.customFields?.data)
	const appearance   = $state($page.props.options.appearance)
	const personality  = $state($page.props.options.personality)
	let   editField    = $state(null)

	let {
		character,
		class: className
	} = $props()


	//	Tailwind class management

	const cx = {
		sidebar:  "bg-slate-50 sticky top-0 h-screen overflow-y-auto shadow-xl z-10 " + className,
		banner:   "relative bg-slate-200 hover:inner-shadow-lg h-40 place-self-center shrink-0 text-neutral-softest w-full transition-all",
		portrait: "relative bg-slate-200 hover:inner-shadow-lg border border-slate-50 h-32 -mt-16 place-self-center rounded shrink-0 text-neutral-softest w-32 transition-all",
		info:     "font-light min-h-8 py-1",
		label:    "text-xs text-neutral-soft min-w-20",
		value:    "text-sm text-neutral my-1",
		empty:    "text-sm text-neutral-softest italic",
		button: {
			edit:    "h-5 w-5 ml-auto rounded-full text-accent hover:bg-accent-softest",
			confirm: "h-5 w-5 ml-auto rounded-full bg-accent text-white",
			view:    "sticky bottom-3 line-clamp-1 mx-6 mt-auto rounded-full"
		}
	}

</script>



<Sidebar class={cx.sidebar} gap={0}>
	{#if character}


		<!-- Head -->

		<Media
			class={cx.banner}
			media={character.getMedia('banner')}
			onclick={() => character.openModal('setMedia', {type: 'banner', aspect: 'aspect-[7/3]'})}
		/>
		<Media
			class={cx.portrait}
			media={character.getMedia('portrait')}
			onclick={() => character.openModal('setMedia', {type: 'portrait', aspect: 'aspect-[1/1]'})}
			icon="UserCircle" iconWeight="fill"
		/>


		<!-- Body -->
		
		<Stack gap={3} class="relative px-4 py-3">


			<!-- Heading -->

			<Stack gap={0.5} class="px-6 -space-y-1">
				<Inline align="center" gap={0} class="place-self-center">
					<Heading is="h3" as="h4" heading={character.name} class="text-center" />
					<div class="relative place-self-start w-0">
						<Button size="sm" theme="accent"
							icon="PencilSimple" iconSize="xs"
							class="absolute ml-1 rounded-full"
							onclick={() => character.openModal('rename')}
						/>
					</div>
				</Inline>
				{#if character.alias}
					<Inline align="center" gap={0} class="place-self-center">
						<p class="text-neutral-soft text-sm">{character.alias}</p>
						<div class="relative w-0">
							<Button class="ml-1 rounded-full"
								size="sm" theme="accent"
								icon="PencilSimple" iconSize="xs"
								onclick={() => character.setAlias()}
							/>
						</div>
					</Inline>
				{/if}
			</Stack>


			<!-- Panel Actions -->

			<Inline align="center" class="border border-neutral-softest place-self-center p-0.5 rounded-full">
				<Button size="sm"
					icon="Star" iconSize="sm" iconWeight={character.starred ? 'fill' : 'regular'}
					class="cursor-pointer p-0.5 rounded-full text-amber-400 hover:bg-amber-50"
					onclick={() => character.star()}
				/>
				<Button size="sm"
					icon="PencilSimple" iconSize="sm" iconWeight="regular"
					class="cursor-pointer p-0.5 rounded-full text-accent hover:bg-accent-softest"
					onclick={() => character.star()}
				/>
				<Button size="sm"
					icon="Trash" iconSize="sm" iconWeight="regular"
					class="cursor-pointer p-0.5 rounded-full text-danger hover:bg-danger-softest"
					onclick={() => character.openModal('delete')}
				/>
			</Inline>


			<!-- Description -->
			
			{#if character.description}
				<Collapsible class="font-style-small min-h-16 px-1.5" collapsed={true}>
					{character.description}
				</Collapsible>
			{/if}
		</Stack>
		<Stack gap={0} class="relative px-4 py-3">
			<Separator />


			<!-- Custom Fields -->
	
			{#each customFields as field}
				<Flex align="center" class={cx.info}>
					<p class={cx.label}>{field?.label}</p>
					<p class={cx.value}>
						{#if editField === field.name}
							<Input {...field}
								label={undefined}
								size="sm"
								value={character.customFieldValues?.find(f => f.name === field.name)?.value}
							/>
						{:else}
							{character.customFieldValues?.find(f => f.name === field.name)?.displayValue}
						{/if}
					</p>
					{#if editField === field.name}
						<Button class={cx.button.confirm} size="sm"
							icon="Check" iconSize="xs"
						/>
					{:else if !editField}
						<Button class={cx.button.edit} size="sm"
							icon="PencilSimple" iconSize="xs"
							onclick={() => editField = field.name}
						/>
					{/if}
				</Flex>
				<Separator />
			{/each}


			<!-- Factions -->
	
			<Flex align="center" class={cx.info}>
				<p class={cx.label}>Factions</p>
				<p class={cx.value}>
					{#if character.factions?.items.length > 0}
						{#each character.factions?.items as fac,i}
							<Link href={fac.routes?.show}>
								{fac.name}
							</Link>{character.factions?.items.length-1 !== i ? ', ' : ''}
						{/each}
					{:else}
						<span class={cx.empty}>None</span>
					{/if}
				</p>
				<Button class={cx.button.edit}
					style="plain" theme="accent" size="md"
					icon="PencilSimple" iconSize="xs"
					onclick={() => character.openModal('factions')}
				/>
			</Flex>
			<Separator />


			<!-- Location -->
	
			<Flex align="center" class={cx.info}>
				<p class={cx.label}>Location</p>
				<p class={cx.value}>
					{#if character.location}
						<Link href={character.location.routes?.show}>
							{character.location?.name}
						</Link>
					{:else}
						<span class={cx.empty}>None</span>
					{/if}
				</p>
				<Button class={cx.button.edit}
					style="plain" theme="accent" size="sm"
					icon="PencilSimple" iconSize="xs"
					onclick={() => character.openModal('location')}
				/>
			</Flex>
			<Separator />


			<!-- Relationships -->
	
			<Flex align="center" class={cx.info}>
				<p class={cx.label}>Relationships</p>
				<p class={cx.value}>
					{#if character.relationships?.items.length > 0}
						{#each character.relationships?.items as rel,i}
							<Link href={rel.routes?.show}>
								{rel.name}
							</Link>{character.relationships?.items.length-1 !== i ? ', ' : ''}
						{/each}
					{:else}
						<span class={cx.empty}>None</span>
					{/if}
				</p>
				<Button class={cx.button.edit}
					style="plain" theme="accent" size="sm"
					icon="PencilSimple" iconSize="xs"
					onclick={() => character.openModal('relationships')}
				/>
			</Flex>
			<Separator />


			<!-- Appearance -->
	
			<Flex align="center" class={cx.info}>
				<p class={cx.label}>Appearance</p>
				<p class="{cx.value} line-clamp-2">
					{#if character.appearance}
						{#each character.appearance.split(',') as trait,i}
							{trait}{character.appearance.split(',').length-1 !== i ? ', ' : ''}
						{/each}
					{:else}
						<span class={cx.empty}>None</span>
					{/if}
				</p>
				<Button class={cx.button.edit}
					style="plain" theme="accent" size="sm"
					icon="PencilSimple" iconSize="xs"
					onclick={() => character.openModal('appearance', { options: appearance })}
				/>
			</Flex>
			<Separator />


			<!-- Personality -->
	
			<Flex align="center" class={cx.info}>
				<p class={cx.label}>Personality</p>
				<p class="{cx.value} line-clamp-2">
					{#if character.personality}
						{#each character.personality.split(',') as trait,i}
							{trait}{character.personality.split(',').length-1 !== i ? ', ' : ''}
						{/each}
					{:else}
						<span class={cx.empty}>None</span>
					{/if}
				</p>
				<Button class={cx.button.edit}
					style="plain" theme="accent" size="sm"
					icon="PencilSimple" iconSize="xs"
					onclick={() => character.openModal('personality', { options: personality })}
				/>
			</Flex>
		</Stack>


	{:else}
		<Thumbnail class="max-h-40 rounded-none w-full" />
		<Thumbnail class="border border-slate-50 h-32 -mt-16 place-self-center rounded shrink-0 w-32" />
		<Stack gap={1.5} class="my-4 w-full" align="center">
			<Skeleton class="h-6 w-1/4" />
			<Skeleton class="h-3 w-1/3" />
			<Inline class="bg-transparent border border-neutral-softest mt-4 p-0.5 rounded-full translate-y-[-2px]">
				<Skeleton class="bg-transparent h-6 rounded-full w-6" />
				<Skeleton class="bg-transparent h-6 rounded-full w-6" />
				<Skeleton class="bg-transparent h-6 rounded-full w-6" />
			</Inline>
		</Stack>
		<Stack gap={2} class="mb-2 px-6">
			<Skeleton class="h-3 mr-5" />
			<Skeleton class="h-3 mr-1" />
			<Skeleton class="h-3 mr-24" />
			<!-- <Skeleton class="h-5 mx-auto my-1 rounded-full w-20" color="bg-accent-softest" /> -->
			<Separator class="mt-6 mb-3" />
			<Flex align="center" class="w-full">
				<Skeleton class="h-3 w-16" />
				<Skeleton class="h-7 ml-auto w-44" />
			</Flex>
			<Flex align="center" class="w-full">
				<Skeleton class="h-3 w-16" />
				<Skeleton class="h-7 ml-auto w-44" />
			</Flex>
			<Flex align="center" class="w-full">
				<Skeleton class="h-3 w-16" />
				<Skeleton class="h-7 ml-auto w-44" />
			</Flex>
			<Flex align="center" class="w-full">
				<Skeleton class="h-3 w-24" />
				<Skeleton class="h-7 ml-auto w-44" />
			</Flex>
			<Flex align="center" class="w-full">
				<Skeleton class="h-3 w-20" />
			</Flex>
			<Flex align="center" class="w-full">
				<Skeleton class="h-3 w-16" />
			</Flex>
		</Stack>


	{/if}
	<Button class={cx.button.view}
		size="xl" style="hard" theme="accent"
		icon="Eye" iconWeight="fill"
		label="View {character?.name}"
		href={character?.routes.show}
	/>
</Sidebar>
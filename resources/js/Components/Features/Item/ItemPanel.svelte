<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

	import Flex				from '@/Components/Core/Flex.svelte'
	import Inline			from '@/Components/Core/Inline.svelte'
	import Stack			from '@/Components/Core/Stack.svelte'
	import Button			from '@/Components/UI/Button.svelte'
	import Collapsible		from '@/Components/UI/Collapsible.svelte'
	import Heading			from '@/Components/UI/Heading.svelte'
	import Icon				from '@/Components/UI/Icon.svelte'
	import Input			from '@/Components/UI/Input.svelte'
	import Media			from '@/Components/UI/Media.svelte'
	import Separator		from '@/Components/UI/Separator.svelte'
	import Sidebar			from '@/Components/UI/Sidebar.svelte'
	import SidebarListItem 	from '@/Components/UI/SidebarListItem.svelte'
	import Skeleton			from '@/Components/UI/Skeleton.svelte'
	import Thumbnail		from '@/Components/UI/Thumbnail.svelte'


	//	Page & Component props

	const customFields = $state($page.props.customFields?.data)
	const appearance   = $state($page.props.options.appearance)
	const personality  = $state($page.props.options.personality)
	let   editField    = $state(null)

	let {
		class: className,
		item
	} = $props()


	//	Tailwind class management

	const cx = {
		sidebar:  "bg-slate-50 sticky top-0 h-screen overflow-y-auto shadow-xl z-10 " + className,
		banner:   "relative bg-slate-200 hover:inner-shadow-lg h-40 place-self-center shrink-0 text-neutral-softest w-full transition-all",
		portrait: "relative bg-slate-200 hover:inner-shadow-lg border border-slate-50 h-32 -mt-16 place-self-center rounded shrink-0 text-neutral-softest w-32 transition-all",
		button: {
			view:    "sticky bottom-3 line-clamp-1 mx-6 mt-auto rounded-full"
		}
	}

</script>



<Sidebar class={cx.sidebar} gap={0}>
	{#if item}


		<!-- Head -->

		<Media
			class={cx.banner}
			media={item.getMedia('banner')}
			onclick={() => item.openModal('setMedia', {type: 'banner', aspect: 'aspect-[7/3]'})}
		/>
		<Media
			class={cx.portrait}
			media={item.getMedia('portrait')}
			onclick={() => item.openModal('setMedia', {type: 'portrait', aspect: 'aspect-[1/1]'})}
			icon="Package" iconWeight="fill"
		/>


		<!-- Body -->
		
		<Stack gap={3} class="relative px-4 py-3">


			<!-- Heading -->

			<Stack gap={0.5} class="px-6 -space-y-1">
				<Inline align="center" gap={0} class="place-self-center">
					<Heading is="h3" as="h4" heading={item.name} class="text-center" />
					<div class="relative place-self-start w-0">
						<Button size="sm" style="soft" theme="accent"
							icon="PencilSimple" iconSize="xs"
							class="absolute ml-1 rounded-full"
							onclick={() => item.openModal('rename')}
						/>
					</div>
				</Inline>
				{#if item.type}
					<Inline align="center" gap={0} class="place-self-center">
						<p class="text-neutral-soft text-sm">{item.type}</p>
						<div class="relative w-0">
							<Button class="ml-1 rounded-full"
								size="sm" style="soft" theme="accent"
								icon="PencilSimple" iconSize="xs"
								onclick={() => item.openModal('type')}
							/>
						</div>
					</Inline>
				{/if}
			</Stack>


			<!-- Panel Actions -->

			<Inline align="center" class="border border-neutral-softest place-self-center p-0.5 rounded-full">
				<Button size="sm"
					icon="Star" iconSize="sm" iconWeight={item.starred ? 'fill' : 'regular'}
					class="cursor-pointer p-0.5 rounded-full text-amber-400 hover:bg-amber-50"
					onclick={() => item.star()}
				/>
				<Button size="sm"
					icon="PencilSimple" iconSize="sm" iconWeight="regular"
					class="cursor-pointer p-0.5 rounded-full text-accent hover:bg-accent-softest"
					onclick={() => item.star()}
				/>
				<Button size="sm"
					icon="Trash" iconSize="sm" iconWeight="regular"
					class="cursor-pointer p-0.5 rounded-full text-danger hover:bg-danger-softest"
					onclick={() => item.openModal('delete')}
				/>
			</Inline>


			<!-- Description -->
			
			{#if item.description}
				<Collapsible class="font-style-small min-h-16 px-1.5" collapsed={true}>
					{item.description}
				</Collapsible>
			{/if}
		</Stack>
		<Stack gap={0} class="relative px-4 py-3">

			<!-- Unique -->
			<SidebarListItem
				label="Unique"
				onclick={() => item.openModal('unique')}
				value={item.unique ? 'Yes' : 'No'}
			/>

			<!-- Type -->
			<SidebarListItem
				label="Type"
				onclick={() => item.openModal('type')}
				value={item.type || undefined}
			/>

			<!-- Cost -->
			<SidebarListItem
				label="Cost"
				onclick={() => item.openModal('cost')}
				value={item.cost || undefined}
			/>

			<!-- Weight -->
			<SidebarListItem
				label="Weight"
				onclick={() => item.openModal('weight')}
				value={item.weight || undefined}
			/>

			<!-- Custom Fields -->
			{#each customFields as field}
				<SidebarListItem
					label={field.label}
					onclick={() => item.openModal('customField', { field: field, value: item.customFieldValues?.find(f => f.name === field.name)?.value })}
					value={item.customFieldValues?.find(f => f.name === field.name)?.displayValue}
				/>
			{/each}

		</Stack>

		<Button class={cx.button.view}
			size="xl" style="hard" theme="accent"
			icon="Eye" iconWeight="fill"
			text="View {item?.name}"
			href={item?.routes.show}
		/>

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
		<Stack gap={2} class="mb-8 mx-1 px-6">
			<Skeleton class="h-3 mr-5" />
			<Skeleton class="h-3 mr-1" />
			<Skeleton class="h-3 mr-24" />
		</Stack>
		<Stack class="-mt-[2px] px-4">
			<Flex align="center" class="border-t py-2.5 w-full">
				<Skeleton class="h-3 w-8 mr-12" />
				<Skeleton class="h-3 w-20" />
			</Flex>
			<Flex align="center" class="border-t py-2.5 w-full">
				<Skeleton class="h-3 w-8 mr-12" />
				<Skeleton class="h-3 w-6" />
			</Flex>
			<Flex align="center" class="border-t py-2.5 w-full">
				<Skeleton class="h-3 w-12 mr-8" />
				<Skeleton class="h-3 w-20" />
			</Flex>
			<Flex align="center" class="border-t py-2.5 w-full">
				<Skeleton class="h-3 w-12 mr-8" />
				<Skeleton class="h-3 w-20" />
			</Flex>
			<Flex align="center" class="border-t py-2.5 w-full" wrap>
				<Skeleton class="h-3 w-12 mr-8" />
				<Skeleton class="h-3 w-28" />
			</Flex>
			<Flex align="center" class="border-t py-2.5 w-full" wrap>
				<Skeleton class="h-3 w-16 mr-4" />
				<Skeleton class="h-3 w-12 mr-1" />
				<Skeleton class="h-3 w-12" />
			</Flex>
			<Flex align="center" class="border-t py-2.5 w-full" wrap>
				<Skeleton class="h-3 w-16 mr-4" />
				<Skeleton class="h-3 w-8 mr-1" />
				<Skeleton class="h-3 w-12 mr-1" />
				<Skeleton class="h-3 w-16" />
			</Flex>
			<Flex align="center" class="border-t py-2.5 w-full" wrap>
				<Skeleton class="h-3 w-16 mr-4" />
				<Skeleton class="h-3 w-12 mr-1" />
				<Skeleton class="h-3 w-12 mr-1" />
				<Skeleton class="h-3 w-10" />
			</Flex>
		</Stack>

		<Skeleton class="sticky bottom-3 bg-accent-softest h-[50px] mx-6 mt-auto rounded-full" />

	{/if}
</Sidebar>
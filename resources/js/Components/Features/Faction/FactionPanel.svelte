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
	import Media		from '@/Components/UI/Media.svelte'
	import Separator	from '@/Components/UI/Separator.svelte'
	import Sidebar		from '@/Components/UI/Sidebar.svelte'
	import SidebarListItem from '@/Components/UI/SidebarListItem.svelte'
	import Skeleton		from '@/Components/UI/Skeleton.svelte'
	import Thumbnail	from '@/Components/UI/Thumbnail.svelte'


	//	Page & Component props

	const customFields = $state($page.props.customFields?.data)

	let {
		faction,
		class: className
	} = $props()


	//	Tailwind class management

	const cx = {
		sidebar:  "bg-slate-50 sticky top-0 h-screen overflow-y-auto shadow-xl z-10 " + className,
		banner:   "relative bg-slate-200 hover:inner-shadow-lg h-40 place-self-center shrink-0 text-neutral-softest w-full transition-all",
		emblem:   "relative bg-slate-200 hover:inner-shadow-lg border border-slate-50 h-32 -mt-16 place-self-center rounded shrink-0 text-neutral-softest w-32 transition-all",
		info:     "font-light group px-1 py-2",
		label:    "text-xs text-neutral-soft min-w-20 pt-0.5",
		value:    "text-sm text-neutral",
		empty:    "text-sm text-neutral-softest italic",
		button: {
			edit: "opacity-0 group-hover:opacity-100 h-5 w-5 ml-auto place-self-start rounded-full",
			view: "sticky bottom-3 line-clamp-1 mx-6 mt-auto rounded-full"
		}
	}

</script>



<Sidebar class={cx.sidebar} gap={0}>
	{#if faction}


		<!-- Head -->

		<Media
			class={cx.banner}
			media={faction.getMedia('banner')}
			onclick={() => faction.openModal('setMedia', {type: 'banner', aspect: 'aspect-[7/3]'})}
		/>
		<Media
			class={cx.emblem}
			media={faction.getMedia('emblem')}
			onclick={() => faction.openModal('setMedia', {type: 'emblem', aspect: 'aspect-[1/1]'})}
			icon="FlagBannerFold" iconWeight="fill"
		/>


		<!-- Body -->

		<Stack gap={3} class="relative px-4 py-3">


			<!-- Heading -->

			<Stack gap={0.5} class="px-6 -space-y-1">
				<Inline align="center" gap={0} class="place-self-center">
					<Heading is="h3" as="h4">{faction.name}</Heading>
					<Button size="xs" style="plain" theme="accent"
						icon="PencilSimple"
						class="ml-1.5 place-self-start rounded-full"
						onclick={() => faction.openModal('rename')}
					/>
				</Inline>
				<p class="place-self-center text-neutral-soft text-sm">{faction.type}</p>
			</Stack>


			<!-- Panel Actions -->

			<Inline align="center" gap={0} class="border border-neutral-softest place-self-center p-0.5 rounded-full">
				<Button size="sm"
					icon="Star" iconSize="sm" iconWeight={faction.starred ? 'fill' : 'regular'}
					class="cursor-pointer p-0.5 rounded-full text-amber-400 hover:bg-amber-50"
					onclick={() => faction.star()}
				/>
				<Button size="sm"
					icon="PencilSimple" iconSize="sm" iconWeight="regular"
					class="cursor-pointer p-0.5 rounded-full text-accent hover:bg-accent-softest"
					onclick={() => faction.star()}
				/>
				<Button size="sm"
					icon="Trash" iconSize="sm" iconWeight="regular"
					class="cursor-pointer p-0.5 rounded-full text-danger hover:bg-danger-softest"
					onclick={() => faction.openModal('delete')}
				/>
			</Inline>


			<!-- Description -->

			{#if faction.description}
				<Collapsible class="font-style-small min-h-16 px-1.5" collapsed={true}>
					{faction.description}
				</Collapsible>
			{/if}
		</Stack>
		<Stack gap={0} class="relative px-4 py-3">

			<!-- Headquarters -->
			<SidebarListItem
				label="Headquarters"
				onclick={() => faction.openModal('headquarters')}
				value={faction.headquarters ? [{ value: faction.headquarters?.name, href: faction.headquarters?.routes?.show }] : undefined}
			/>

			<!-- Members -->
			<SidebarListItem
				label="Members"
				onclick={() => faction.openModal('members', { options: $page.props.activeProject?.data?.characters })}
				value={faction.members.length > 0 ? [ ...faction.members?.items.map(m => ({ value: m.name, href: m.routes?.show })) ] : undefined}
			/>

			<!-- Custom Fields -->
	
			{#each customFields as field}
				<SidebarListItem
					label={field.label}
					onclick={() => faction.openModal('customField', { field: field, value: faction.customFieldValues?.find(f => f.name === field.name)?.value })}
					value={faction.customFieldValues?.find(f => f.name === field.name)?.displayValue}
				/>
			{/each}
		</Stack>


	{:else}
		<Thumbnail class="max-h-40 rounded-none w-full" />
		<Thumbnail class="border border-slate-50 h-32 -mt-16 place-self-center rounded shrink-0 w-32" />
		<Stack gap={1.5} class="my-4 w-full" align="center">
			<Skeleton class="h-6 w-3/4" />
			<Skeleton class="h-3 w-1/4" />
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
	<Button
		size="xl" style="hard" theme="accent"
		class="sticky bottom-3 line-clamp-1 mx-6 mt-auto rounded-full"
		icon="Eye" iconWeight="fill"
		text="View {faction?.name}"
		href={faction?.routes.show}
	/>
</Sidebar>
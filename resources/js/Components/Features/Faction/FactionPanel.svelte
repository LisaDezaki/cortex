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
		info:     "font-light px-1 py-1.5",
		label:    "min-h-5 text-xs text-neutral-soft min-w-20 pt-0.5",
		value:    "min-h-5 text-sm text-neutral",
		empty:    "min-h-5 text-sm text-neutral-softest italic",
		button: {
			edit: "h-5 w-5 ml-auto rounded-full",
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
				<Heading is="h3" as="h4" class="place-self-center text-center">{faction.name}</Heading>
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
			<Separator />

			<!-- Custom Fields -->
	
			{#each customFields as field}
				<Flex align="start" class={cx.info}>
					<p class={cx.label}>{field?.label}</p>
					<p class={cx.value}>{faction.customFieldValues?.find(f => f.name === field.name)?.displayValue}</p>
					<Button class={cx.button.edit}
						style="plain" theme="accent" size="sm"
						icon="PencilSimple" iconSize="xs"
						onclick={() => faction.setCustomField()}
					/>
				</Flex>
				<Separator />
			{/each}



			<!-- Headquarters -->
	
			<Flex align="start" class={cx.info}>
				<p class={cx.label}>Headquarters</p>
				<p class={cx.value}>
					{#if faction.headquarters}
						<Link href={faction.headquarters.routes?.show}>
							{faction.headquarters?.name}
						</Link>
					{:else}
						<span class={cx.empty}>None</span>
					{/if}
				</p>
				<Button class={cx.button.edit}
					style="plain" theme="accent" size="sm"
					icon="PencilSimple" iconSize="xs"
					onclick={() => faction.setHeadquarters()}
				/>
			</Flex>
			<Separator />


	
			<!-- Members -->
	
			<Flex align="start" class={cx.info}>
				<p class={cx.label}>Members</p>
				<p class={cx.value}>
					{#if faction.members?.items.length > 0}
						{#each faction.members?.items as member,i}
							<Link href={member.routes?.show}>
								{member.name}
							</Link>{faction.members?.items.length-1 !== i ? ', ' : ''}
						{/each}
					{:else}
						<span class={cx.empty}>None</span>
					{/if}
				</p>
				<Button class={cx.button.edit}
					style="plain" theme="accent" size="sm"
					icon="PencilSimple" iconSize="xs"
					onclick={() => character.setRelationships()}
				/>
			</Flex>
			<Separator />
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
		label="View {faction?.name}"
		href={faction?.routes.show}
	/>
</Sidebar>
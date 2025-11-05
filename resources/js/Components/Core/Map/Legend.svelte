<script>
	import { getContext } from "svelte";

	import Inline from '@/Components/Core/Inline.svelte'
	import Stack  from '@/Components/Core/Stack.svelte'
	import Button from '@/Components/UI/Button.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'

	const {
		getActive,
		getHovered,
		getItems,
		handleConfirmCoordinates,
		handleItemHover,
		setActiveItem,
		legendClass,
	} = getContext("map-context");

	let {
		class: className,
		pannable,
		zoomable
	} = $props()

	let cx = $derived({
		active: 	"",
		cursor: 	getActive() ? "cursor-crosshair" : (pannable ? "cursor-grab" : "cursor-pointer"),
		icon: 		"bg-neutral-softest text-neutral",
		iconHover: 	"bg-accent text-white",
		item: 		"cursor-pointer text-sm text-neutral",
		itemHover: 	"text-accent bg-accent-softest",
		list: 		"grid grid-cols-2 gap-[1px] min-w-48 shrink-0 w-full",
		title: 		"min-h-6 text-xs text-neutral-soft min-w-20 pt-0.5"
	})

	function isHovered(item) {
		return getHovered()?.mappable?.id === item.mappable?.id
	}

</script>



{#each [
	{ title: 'Locations',  defaultIcon: 'MapPinSimple', list: getItems().locations },
	{ title: 'Characters', defaultIcon: 'User',			list: getItems().characters }
] as mapItems}
	{#if mapItems.list.length > 0}
		<Stack class="pt-3 {legendClass}">
			<p class={cx.title}>{mapItems.title}</p>
			<ul class={cx.list}>
				{#each mapItems.list as item}
					<li class="col-span-1">
						<Inline gap={1.5}
							class="{cx.item} {isHovered(item) ? cx.itemHover : ''}"
							onmouseover={() => handleItemHover(item)}
							onmouseout={ () => handleItemHover()}
						>
							<Icon
								name={item.mappable.icon || mapItems.defaultIcon}
								size="sm"
								weight={isHovered(item) ? 'fill' : 'regular'}
								class="p-1 {isHovered(item) ? cx.iconHover : cx.icon}"
							/>
							<span class="line-clamp-1">{item.mappable.name}</span>
							{#if getActive()?.mappable.id === item.mappable?.id}
								<Button class="bg-accent ml-auto rounded-none text-white"
									icon={item.x && item.y ? "Check" : "Check"} iconWeight="bold"
									iconSize="xs"
									onclick={handleConfirmCoordinates}
								/>
							{:else if !getActive()}
								<Button class="ml-auto rounded-none text-neutral-softer"
									theme={item.x && item.y ? "accent" : ""}
									icon={item.x && item.y ? "GpsFix" : "Gps"}
									iconSize="xs"
									iconWeight={item.x && item.y ? 'fill' : 'regular'}
									onclick={() => setActiveItem(item)}
								/>
							{/if}
						</Inline>
					</li>
				{/each}
			</ul>
		</Stack>
	{/if}
{/each}
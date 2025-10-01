<script>
	import Card  from '@/Components/UI/Card.svelte'

    let {
		class: className,
		faction,
		options,
        ...restProps
    } = $props()
</script>

<Card class={className}
	aspect="square" icon="FlagBannerFold" iconWeight="fill"
	image={faction.image?.url}
	title={faction.name}
	subtitle="{faction.members.length} member{faction.members.length === 1 ? '' : 's'}"
	href={faction.routes.show}
	options={options}
	starred={faction.starred}
	onStar={() => faction.star()}
{...restProps} />
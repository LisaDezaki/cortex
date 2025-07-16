<script>

	import ArrowLeft from "phosphor-svelte/lib/ArrowLeft"
	import ArrowRight from "phosphor-svelte/lib/ArrowRight"
	import Backpack from "phosphor-svelte/lib/Backpack"
	import Books from "phosphor-svelte/lib/Books"
	import Butterfly from "phosphor-svelte/lib/Butterfly"
	import CalendarDots from "phosphor-svelte/lib/CalendarDots"
	import CaretDoubleDown from "phosphor-svelte/lib/CaretDoubleDown"
	import CaretDoubleUp from "phosphor-svelte/lib/CaretDoubleUp"
	import CaretUpDown from "phosphor-svelte/lib/CaretUpDown"
	import Chats from "phosphor-svelte/lib/Chats"
	import Check from "phosphor-svelte/lib/Check"
	import CheckFat from "phosphor-svelte/lib/CheckFat"
	import Compass from "phosphor-svelte/lib/Compass"
	import DotsSixVertical from "phosphor-svelte/lib/DotsSixVertical"
	import DotsThreeOutline from "phosphor-svelte/lib/DotsThreeOutline"
	import DotsThreeOutlineVertical from "phosphor-svelte/lib/DotsThreeOutlineVertical"
	import FilmSlate from "phosphor-svelte/lib/FilmSlate"
	import FlagBannerFold from "phosphor-svelte/lib/FlagBannerFold"
	import GearFine from "phosphor-svelte/lib/GearFine"
	import GlobeStand from "phosphor-svelte/lib/GlobeStand"
	import GridFour from "phosphor-svelte/lib/GridFour"
	import Hash from "phosphor-svelte/lib/Hash"
	import ImageSquare from "phosphor-svelte/lib/ImageSquare"
	import Info from "phosphor-svelte/lib/Info"
	import Link from "phosphor-svelte/lib/Link"
	import List from "phosphor-svelte/lib/List"
	import MapPin from "phosphor-svelte/lib/MapPin"
	import MapPinArea from "phosphor-svelte/lib/MapPinArea"
	import Minus from "phosphor-svelte/lib/Minus"
	import Moon from "phosphor-svelte/lib/Moon"
	import Pen from "phosphor-svelte/lib/Pen"
	import Pentagram from "phosphor-svelte/lib/Pentagram"
	import Plus from "phosphor-svelte/lib/Plus"
	import Question from "phosphor-svelte/lib/Question"
	import RowsPlusBottom from "phosphor-svelte/lib/RowsPlusBottom"
	import SignOut from "phosphor-svelte/lib/SignOut"
	import SortAscending from "phosphor-svelte/lib/SortAscending"
	import SortDescending from "phosphor-svelte/lib/SortDescending"
	import Speedometer from "phosphor-svelte/lib/Speedometer"
	import Sun from "phosphor-svelte/lib/Sun"
	import Table from "phosphor-svelte/lib/Table"
	import TextAa from "phosphor-svelte/lib/TextAa"
	import Textbox from "phosphor-svelte/lib/Textbox"
	import ToggleRight from "phosphor-svelte/lib/ToggleRight"
	import Trash from "phosphor-svelte/lib/Trash"
	import Trophy from "phosphor-svelte/lib/Trophy"
	import UploadSimple from "phosphor-svelte/lib/UploadSimple"
	import User from "phosphor-svelte/lib/User"
	import UserList from "phosphor-svelte/lib/UserList"
	import UsersThree from "phosphor-svelte/lib/UsersThree"
	import Wrench from "phosphor-svelte/lib/Wrench"
	import X from "phosphor-svelte/lib/X"

    let {
		class: className,
        name,
		...attrs
    } = $props()

	const icons = {
		'ArrowLeft': ArrowLeft,
		'ArrowRight': ArrowRight,
		'Backpack': Backpack,
		'Books': Books,
		'Butterfly': Butterfly,
		'CalendarDots': CalendarDots,
		'CaretDoubleDown': CaretDoubleDown,
		'CaretDoubleUp': CaretDoubleUp,
		'CaretUpDown': CaretUpDown,
		'Chats': Chats,
		'Check': Check,
		'CheckFat': CheckFat,
		'Compass': Compass,
		'DotsSixVertical': DotsSixVertical,
		'DotsThreeOutline': DotsThreeOutline,
		'DotsThreeOutlineVertical': DotsThreeOutlineVertical,
		'FilmSlate': FilmSlate,
		'FlagBannerFold': FlagBannerFold,
		'GearFine': GearFine,
		'GlobeStand': GlobeStand,
		'GridFour': GridFour,
		'Hash': Hash,
		'ImageSquare': ImageSquare,
		'Info': Info,
		'Link': Link,
		'List': List,
		'MapPin': MapPin,
		'MapPinArea': MapPinArea,
		'Minus': Minus,
		'Moon': Moon,
		'Pen': Pen,
		'Pentagram': Pentagram,
		'Plus': Plus,
		'Question': Question,
		'RowsPlusBottom': RowsPlusBottom,
		'SignOut': SignOut,
		'SortAscending': SortAscending,
		'SortDescending': SortDescending,
		'Speedometer': Speedometer,
		'Sun': Sun,
		'Table': Table,
		'TextAa': TextAa,
		'Textbox': Textbox,
		'ToggleRight': ToggleRight,
		'Trash': Trash,
		'Trophy': Trophy,
		'UploadSimple': UploadSimple,
		'User': User,
		'UserList': UserList,
		'UsersThree': UsersThree,
		'Wrench': Wrench,
		'X': X,
	}

	const Component = icons[name]

</script>

<div class="icon {className}">
	<Component {...attrs} />
</div>

<style lang="postcss">
	.icon {
		@apply inline-flex items-center justify-center;
	}
</style>
<script>
	import ArrowLeft from "phosphor-svelte/lib/ArrowLeft"
	import ArrowRight from "phosphor-svelte/lib/ArrowRight"
	import ArrowsLeftRight from "phosphor-svelte/lib/ArrowsLeftRight"
	import At from "phosphor-svelte/lib/At"
	import Backpack from "phosphor-svelte/lib/Backpack"
	import Books from "phosphor-svelte/lib/Books"
	import BuildingApartment from "phosphor-svelte/lib/BuildingApartment"
	import Butterfly from "phosphor-svelte/lib/Butterfly"
	import CalendarDots from "phosphor-svelte/lib/CalendarDots"
	import CaretDoubleDown from "phosphor-svelte/lib/CaretDoubleDown"
	import CaretDoubleUp from "phosphor-svelte/lib/CaretDoubleUp"
	import CaretDown from "phosphor-svelte/lib/CaretDown"
	import CaretLeft from "phosphor-svelte/lib/CaretLeft"
	import CaretRight from "phosphor-svelte/lib/CaretRight"
	import CaretUpDown from "phosphor-svelte/lib/CaretUpDown"
	import Chats from "phosphor-svelte/lib/Chats"
	import Check from "phosphor-svelte/lib/Check"
	import CheckFat from "phosphor-svelte/lib/CheckFat"
	import Compass from "phosphor-svelte/lib/Compass"
	import CompassRose from "phosphor-svelte/lib/CompassRose"
	import DotsSixVertical from "phosphor-svelte/lib/DotsSixVertical"
	import DotsThreeOutline from "phosphor-svelte/lib/DotsThreeOutline"
	import DotsThreeOutlineVertical from "phosphor-svelte/lib/DotsThreeOutlineVertical"
	import DotsThreeVertical from "phosphor-svelte/lib/DotsThreeVertical"
	import File from "phosphor-svelte/lib/File"
	import FileAudio from "phosphor-svelte/lib/FileAudio"
	import FileImage from "phosphor-svelte/lib/FileImage"
	import FileText from "phosphor-svelte/lib/FileText"
	import FileVideo from "phosphor-svelte/lib/FileVideo"
	import FilmSlate from "phosphor-svelte/lib/FilmSlate"
	import FlagBannerFold from "phosphor-svelte/lib/FlagBannerFold"
	import FolderSimple from "phosphor-svelte/lib/FolderSimple"
	import Funnel from "phosphor-svelte/lib/Funnel"
	import FunnelSimple from "phosphor-svelte/lib/FunnelSimple"
	import FunnelSimpleX from "phosphor-svelte/lib/FunnelSimpleX"
	import FunnelX from "phosphor-svelte/lib/FunnelX"
	import GearFine from "phosphor-svelte/lib/GearFine"
	import GlobeHemisphereEast from "phosphor-svelte/lib/GlobeHemisphereEast"
	import GlobeHemisphereWest from "phosphor-svelte/lib/GlobeHemisphereWest"
	import GlobeStand from "phosphor-svelte/lib/GlobeStand"
	import Graph from "phosphor-svelte/lib/Graph"
	import GridFour from "phosphor-svelte/lib/GridFour"
	import Hamburger from "phosphor-svelte/lib/Hamburger"
	import Handshake from "phosphor-svelte/lib/Handshake"
	import Hash from "phosphor-svelte/lib/Hash"
	import Image from "phosphor-svelte/lib/Image"
	import ImageSquare from "phosphor-svelte/lib/ImageSquare"
	import ImagesSquare from "phosphor-svelte/lib/ImagesSquare"
	import Info from "phosphor-svelte/lib/Info"
	import Key from "phosphor-svelte/lib/Key"
	import LineVertical from "phosphor-svelte/lib/LineVertical"
	import Link from "phosphor-svelte/lib/Link"
	import List from "phosphor-svelte/lib/List"
	import MagnifyingGlass from "phosphor-svelte/lib/MagnifyingGlass"
	import MapPin from "phosphor-svelte/lib/MapPin"
	import MapPinArea from "phosphor-svelte/lib/MapPinArea"
	import MapTrifold from "phosphor-svelte/lib/MapTrifold"
	import Minus from "phosphor-svelte/lib/Minus"
	import Moon from "phosphor-svelte/lib/Moon"
	import Password from "phosphor-svelte/lib/Password"
	import Pen from "phosphor-svelte/lib/Pen"
	import Pentagram from "phosphor-svelte/lib/Pentagram"
	import Plus from "phosphor-svelte/lib/Plus"
	import Question from "phosphor-svelte/lib/Question"
	import Resize from "phosphor-svelte/lib/Resize"
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
	import UserCircle from "phosphor-svelte/lib/UserCircle"
	import UserList from "phosphor-svelte/lib/UserList"
	import UsersFour from "phosphor-svelte/lib/UsersFour"
	import UsersThree from "phosphor-svelte/lib/UsersThree"
	import Wrench from "phosphor-svelte/lib/Wrench"
	import X from "phosphor-svelte/lib/X"

    let {
		class: className,
		if: showIf = true,
        name,
		size = "lg",
		...restProps
    } = $props()

	const icons = {
		'ArrowLeft': ArrowLeft,
		'ArrowRight': ArrowRight,
		'ArrowsLeftRight': ArrowsLeftRight,
		'At': At,
		'Backpack': Backpack,
		'Books': Books,
		'BuildingApartment': BuildingApartment,
		'Butterfly': Butterfly,
		'CalendarDots': CalendarDots,
		'CaretDoubleDown': CaretDoubleDown,
		'CaretDoubleUp': CaretDoubleUp,
		'CaretDown': CaretDown,
		'CaretLeft': CaretLeft,
		'CaretRight': CaretRight,
		'CaretUpDown': CaretUpDown,
		'Chats': Chats,
		'Check': Check,
		'CheckFat': CheckFat,
		'Compass': Compass,
		'CompassRose': CompassRose,
		'DotsSixVertical': DotsSixVertical,
		'DotsThreeOutline': DotsThreeOutline,
		'DotsThreeOutlineVertical': DotsThreeOutlineVertical,
		'DotsThreeVertical': DotsThreeVertical,
		'File': File,
		'FileAudio': FileAudio,
		'FileImage': FileImage,
		'FileText': FileText,
		'FileVideo': FileVideo,
		'FilmSlate': FilmSlate,
		'FlagBannerFold': FlagBannerFold,
		'FolderSimple': FolderSimple,
		'Funnel': Funnel,
		'FunnelSimple': FunnelSimple,
		'FunnelSimpleX': FunnelSimpleX,
		'FunnelX': FunnelX,
		'GearFine': GearFine,
		'GlobeHemisphereEast': GlobeHemisphereEast,
		'GlobeHemisphereWest': GlobeHemisphereWest,
		'GlobeStand': GlobeStand,
		'Graph': Graph,
		'GridFour': GridFour,
		'Hamburger': Hamburger,
		'Handshake': Handshake,
		'Hash': Hash,
		'Image': Image,
		'ImageSquare': ImageSquare,
		'ImagesSquare': ImagesSquare,
		'Info': Info,
		'Key': Key,
		'LineVertical': LineVertical,
		'Link': Link,
		'List': List,
		'MagnifyingGlass': MagnifyingGlass,
		'MapTrifold': MapTrifold,
		'MapPin': MapPin,
		'MapPinArea': MapPinArea,
		'Minus': Minus,
		'Moon': Moon,
		'Password': Password,
		'Pen': Pen,
		'Pentagram': Pentagram,
		'Plus': Plus,
		'Question': Question,
		'Resize': Resize,
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
		'UserCircle': UserCircle,
		'UserList': UserList,
		'UsersFour': UsersFour,
		'UsersThree': UsersThree,
		'Wrench': Wrench,
		'X': X,
	}

	const sizes = {
		'xs': 12,
		'sm': 16,
		'md': 20,
		'lg': 24,
		'xl': 28,
		'2xl': 32
	}
	
	if (!name) {
		console.log(name+' is not a valid icon name.')
	}

	if (!icons[name]) {
		console.log('Failed to import icon '+name+'. It may not be a valid icon name.')
	}

	const Component = $derived(icons[name])
	const iconSize  = $derived(typeof size == "string" ? sizes[size] : size)

</script>

{#if showIf && Component}
	<div class="icon {className}">
		<Component size={iconSize} {...restProps} />
	</div>
{/if}

<style lang="postcss">
	:global(.icon) {
		@apply aspect-square inline-flex items-center justify-center pointer-events-none flex-shrink-0;
	}
</style>
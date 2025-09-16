<script>
	import ArrowElbowUpLeft from "phosphor-svelte/lib/ArrowElbowUpLeft"
	import ArrowLeft from "phosphor-svelte/lib/ArrowLeft"
	import ArrowRight from "phosphor-svelte/lib/ArrowRight"
	import ArrowsLeftRight from "phosphor-svelte/lib/ArrowsLeftRight"
	import At from "phosphor-svelte/lib/At"
	import Backpack from "phosphor-svelte/lib/Backpack"
	import Bag from "phosphor-svelte/lib/Bag"
	import Bank from "phosphor-svelte/lib/Bank"
	import Barbell from "phosphor-svelte/lib/Barbell"
	import BeerStein from "phosphor-svelte/lib/BeerStein"
	import BookmarkSimple from "phosphor-svelte/lib/BookmarkSimple"
	import Books from "phosphor-svelte/lib/Books"
	import BoxingGlove from "phosphor-svelte/lib/BoxingGlove"
	import Bread from "phosphor-svelte/lib/Bread"
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
	import CircleNotch from "phosphor-svelte/lib/CircleNotch"
	import Compass from "phosphor-svelte/lib/Compass"
	import CompassRose from "phosphor-svelte/lib/CompassRose"
	import Crane from "phosphor-svelte/lib/Crane"
	import DiamondsFour from "phosphor-svelte/lib/DiamondsFour"
	import DotsSixVertical from "phosphor-svelte/lib/DotsSixVertical"
	import DotsThreeOutline from "phosphor-svelte/lib/DotsThreeOutline"
	import DotsThreeOutlineVertical from "phosphor-svelte/lib/DotsThreeOutlineVertical"
	import DotsThreeVertical from "phosphor-svelte/lib/DotsThreeVertical"
	import Eye from "phosphor-svelte/lib/Eye"
	import File from "phosphor-svelte/lib/File"
	import FileAudio from "phosphor-svelte/lib/FileAudio"
	import FileImage from "phosphor-svelte/lib/FileImage"
	import FileText from "phosphor-svelte/lib/FileText"
	import FileVideo from "phosphor-svelte/lib/FileVideo"
	import FilmSlate from "phosphor-svelte/lib/FilmSlate"
	import Fish from "phosphor-svelte/lib/Fish"
	import FlagBannerFold from "phosphor-svelte/lib/FlagBannerFold"
	import FolderSimple from "phosphor-svelte/lib/FolderSimple"
	import FolderSimplePlus from "phosphor-svelte/lib/FolderSimplePlus"
	import Funnel from "phosphor-svelte/lib/Funnel"
	import FunnelSimple from "phosphor-svelte/lib/FunnelSimple"
	import FunnelSimpleX from "phosphor-svelte/lib/FunnelSimpleX"
	import FunnelX from "phosphor-svelte/lib/FunnelX"
	import GasPump from "phosphor-svelte/lib/GasPump"
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
	import Island from "phosphor-svelte/lib/Island"
	import Info from "phosphor-svelte/lib/Info"
	import Key from "phosphor-svelte/lib/Key"
	import Lighthouse from "phosphor-svelte/lib/Lighthouse"
	import LineVertical from "phosphor-svelte/lib/LineVertical"
	import Link from "phosphor-svelte/lib/Link"
	import List from "phosphor-svelte/lib/List"
	import ListBullets from "phosphor-svelte/lib/ListBullets"
	import MagnifyingGlass from "phosphor-svelte/lib/MagnifyingGlass"
	import MagnifyingGlassMinus from "phosphor-svelte/lib/MagnifyingGlassMinus"
	import MagnifyingGlassPlus from "phosphor-svelte/lib/MagnifyingGlassPlus"
	import MapPin from "phosphor-svelte/lib/MapPin"
	import MapPinArea from "phosphor-svelte/lib/MapPinArea"
	import MapPinSimpleArea from "phosphor-svelte/lib/MapPinSimpleArea"
	import MapTrifold from "phosphor-svelte/lib/MapTrifold"
	import Minus from "phosphor-svelte/lib/Minus"
	import Moon from "phosphor-svelte/lib/Moon"
	import Password from "phosphor-svelte/lib/Password"
	import Pen from "phosphor-svelte/lib/Pen"
	import Pentagram from "phosphor-svelte/lib/Pentagram"
	import PipeWrench from "phosphor-svelte/lib/PipeWrench"
	import Plus from "phosphor-svelte/lib/Plus"
	import Question from "phosphor-svelte/lib/Question"
	import Resize from "phosphor-svelte/lib/Resize"
	import RowsPlusBottom from "phosphor-svelte/lib/RowsPlusBottom"
	import Sailboat from "phosphor-svelte/lib/Sailboat"
	import SignOut from "phosphor-svelte/lib/SignOut"
	import Siren from "phosphor-svelte/lib/Siren"
	import SmileySad from "phosphor-svelte/lib/SmileySad"
	import SortAscending from "phosphor-svelte/lib/SortAscending"
	import SortDescending from "phosphor-svelte/lib/SortDescending"
	import Speedometer from "phosphor-svelte/lib/Speedometer"
	import SquaresFour from "phosphor-svelte/lib/SquaresFour"
	import Star from "phosphor-svelte/lib/Star"
	import Student from "phosphor-svelte/lib/Student"
	import Sun from "phosphor-svelte/lib/Sun"
	import Sword from "phosphor-svelte/lib/Sword"
	import Table from "phosphor-svelte/lib/Table"
	import TagSimple from "phosphor-svelte/lib/TagSimple"
	import Tent from "phosphor-svelte/lib/Tent"
	import TextAa from "phosphor-svelte/lib/TextAa"
	import Textbox from "phosphor-svelte/lib/Textbox"
	import ToggleRight from "phosphor-svelte/lib/ToggleRight"
	import Trash from "phosphor-svelte/lib/Trash"
	import TreeEvergreen from "phosphor-svelte/lib/TreeEvergreen"
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
		animation,
		class: className,
		if: showIf = true,
        name,
		size = "lg",
		...restProps
    } = $props()

	const icons = {
		'ArrowElbowUpLeft': ArrowElbowUpLeft,
		'ArrowLeft': ArrowLeft,
		'ArrowRight': ArrowRight,
		'ArrowsLeftRight': ArrowsLeftRight,
		'At': At,
		'Backpack': Backpack,
		'Bag': Bag,
		'Bank': Bank,
		'Barbell': Barbell,
		'BeerStein': BeerStein,
		'BookmarkSimple': BookmarkSimple,
		'Books': Books,
		'BoxingGlove': BoxingGlove,
		'Bread': Bread,
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
		'CircleNotch': CircleNotch,
		'Crane': Crane,
		'Compass': Compass,
		'CompassRose': CompassRose,
		'DiamondsFour': DiamondsFour,
		'DotsSixVertical': DotsSixVertical,
		'DotsThreeOutline': DotsThreeOutline,
		'DotsThreeOutlineVertical': DotsThreeOutlineVertical,
		'DotsThreeVertical': DotsThreeVertical,
		'Eye': Eye,
		'File': File,
		'FileAudio': FileAudio,
		'FileImage': FileImage,
		'FileText': FileText,
		'FileVideo': FileVideo,
		'FilmSlate': FilmSlate,
		'Fish': Fish,
		'FlagBannerFold': FlagBannerFold,
		'FolderSimple': FolderSimple,
		'FolderSimplePlus': FolderSimplePlus,
		'Funnel': Funnel,
		'FunnelSimple': FunnelSimple,
		'FunnelSimpleX': FunnelSimpleX,
		'FunnelX': FunnelX,
		'GasPump': GasPump,
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
		'Island': Island,
		'Info': Info,
		'Key': Key,
		'Lighthouse': Lighthouse,
		'LineVertical': LineVertical,
		'Link': Link,
		'List': List,
		'ListBullets': ListBullets,
		'MagnifyingGlass': MagnifyingGlass,
		'MagnifyingGlassMinus': MagnifyingGlassMinus,
		'MagnifyingGlassPlus': MagnifyingGlassPlus,
		'MapPin': MapPin,
		'MapPinArea': MapPinArea,
		'MapPinSimpleArea': MapPinSimpleArea,
		'MapTrifold': MapTrifold,
		'Minus': Minus,
		'Moon': Moon,
		'Password': Password,
		'Pen': Pen,
		'Pentagram': Pentagram,
		'PipeWrench': PipeWrench,
		'Plus': Plus,
		'Question': Question,
		'Resize': Resize,
		'RowsPlusBottom': RowsPlusBottom,
		'Sailboat': Sailboat,
		'SignOut': SignOut,
		'Siren': Siren,
		'SmileySad': SmileySad,
		'SortAscending': SortAscending,
		'SortDescending': SortDescending,
		'Speedometer': Speedometer,
		'SquaresFour': SquaresFour,
		'Star': Star,
		'Student': Student,
		'Sun': Sun,
		'Sword': Sword,
		'Table': Table,
		'TagSimple': TagSimple,
		'Tent': Tent,
		'TextAa': TextAa,
		'Textbox': Textbox,
		'ToggleRight': ToggleRight,
		'Trash': Trash,
		'TreeEvergreen': TreeEvergreen,
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
		<Component class={animation} size={iconSize} {...restProps} />
	</div>
{/if}

<style lang="postcss">
	:global(.icon) {
		@apply aspect-square inline-flex items-center justify-center pointer-events-none flex-shrink-0;
	}
</style>
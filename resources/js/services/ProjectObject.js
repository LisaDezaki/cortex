/**
 * @typedef {import('@inertiajs/svelte')} router
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 * @typedef {import('@/services/CharacterList')} CharacterList
 * @typedef {import('@/services/FactionList')} FactionList
 * @typedef {import('@/services/LocationList')} LocationList
 */

import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore';
import CharacterList from '@/services/CharacterList'
import FactionList from '@/services/FactionList'
import ItemList from '@/services/ItemList'
import LocationList from '@/services/LocationList'
import CustomFieldList from '@/services/CustomFieldList'

/**
 * Class: Project Object
 * Represents a single Project record
 * @class
 * @classdesc A Project entity as fetched from the database
 * with other functionality to make data handling easier
 */

export default class ProjectObject {

	/**
	 * Creates a new ProjectObject instance
	 * @param {Object} projectData
	 * @throws {TypeError} if projectData is not provided
	 */
	constructor(projectData) {
		if (!projectData || (typeof projectData !== 'object')) {
			throw new TypeError('ProjectObject constructor requires a valid project object');
		}
		Object.assign(this, projectData, {

			/**
			 * Laravel's Model location as printed by Project::class
			 * @type {string}
			 */
			laravelClass: "App\\Models\\Project",

			/**
			 * A CharacterList instance
			 * @type {CharacterList}
			 * @readonly
			 */
			characters: projectData.characters ? new CharacterList(projectData.characters) : null,
			
			/**
			 * A FactionList instance
			 * @type {FactionList}
			 * @readonly
			 */
			factions: projectData.factions ? new FactionList(projectData.factions) : null,

			/**
			 * An ItemList instance
			 * @type {ItemList}
			 * @readonly
			 */
			items: projectData.items ? new ItemList(projectData.items) : null,
			
			/**
			 * A LocationList instance
			 * @type {LocationList}
			 * @readonly
			 */
			locations: projectData.locations ? new LocationList(projectData.locations) : null,

			/**
			 * Custom Fields
			 * @type {Array<Object>}
			 * @readonly
			 */
			customFields: projectData.customFields ? new CustomFieldList(projectData.customFields) : null,

			/**
			 * Actions
			 */
			actions: {
				rename:			() => this.openModal('rename'),
				type:			() => this.openModal('type'),
				description:	() => this.openModal('description'),
				uploadBanner:	() => this.openModal('setMedia', { type: 'banner', aspect: 'aspect-video' }),
				delete:			() => this.openModal('delete')
			},
			
			/**
			 * API routes for project operations
			 * @type {Object}
			 * @property {string} activate   | Route for activating this project
			 * @property {string} deactivate | Route for deactivating this project
			 * @property {string} show    | Route for showing this project
			 * @property {string} update  | Route for updating this project
			 * @property {string} destroy | Route for destroying this project
			 */
			routes: {
				activate:	route('projects.activate',	{ project: projectData.id }),
				deactivate: route('projects.deactivate'),
				show:		route('projects.show',		{ project: projectData.id }),
				update:		route('projects.update',	{ project: projectData.id }),
				destroy:	route('projects.destroy',	{ project: projectData.id })
			}
		})
	}


	getAction(name) {
		return this.actions[name]
	}

	getActions() {
		return [
			{ icon: 'Textbox',			label: 'Rename',			onclick: this.actions.rename },
			{ icon: 'Textbox',			label: 'Type',				onclick: this.actions.type },
			{ icon: 'TextAlignLeft',	label: 'Description',		onclick: this.actions.description },
			{ icon: 'UploadSimple',		label: 'Upload banner',		onclick: this.actions.uploadBanner },
			{	separator: true },
			{ icon: 'Trash',			label: 'Delete',			onclick: this.actions.delete, theme: 'danger' }
		]
	}


	/**
	 * Open Modal
	 * Open any of the available modals with associated props
	 * @param {string} modalName | the name of the modal to open
	 * @param {Array}  props     | any additional props to be added
	 */
	openModal(modalName, props) {

		const updateProps  = { entity: this, endpoint: this.routes.update  }
		const destroyProps = { entity: this, endpoint: this.routes.destroy }

		switch(modalName) {
			
			case 'rename':
				modalActions.open('setValue', { ...updateProps,
					field: { name: 'name', type: 'text' },
					reloadPageProps: ['activeProject.name'],
					title: 'Rename project: ' + this.name,
				...props }); break;
			case 'type':
				modalActions.open('setValue', { ...updateProps,
					field: { name: 'type', type: 'text' },
					reloadPageProps: ['activeProject.type'],
					title: 'Set type: ' + this.name,
				...props }); break;
			case 'description':
				modalActions.open('setValue', { ...updateProps,
					field: { name: 'description', label: 'Description', type: 'textarea', rows: 12 },
					reloadPageProps: ['activeProject.description'],
					title: 'Describe project: ' + this.name,
				...props }); break;
			case 'setMedia':
				modalActions.open('uploadMedia', { ...updateProps,
					aspect: 'aspect-square',
					media: this.getMedia(props.type),
					method: 'patch',
					reloadPageProps: ['activeProject.media'],
					title: 'Upload ' + props.type + ': ' + this.name,
					type: props.type,
				...props }); break;
			case 'delete':
				modalActions.open('deleteProject', { ...destroyProps,
					project: this,
					title: 'Delete project: ' + this.name,
				...props }); break;
			default:
				console.log('ProjectObject.openModal', modalName, props)
		}
	}

	/**
	 * Get Options
	 * Fetch the options for various dropdown lists that relate to this project specifically.
	 * @param {string} entity    | the type of entity to get options for
	 * @param {Array}  optionSet | the set of options to retrieve for this entity
	 */
	getOptions(entity, optionSet) {

		if (entity === 'characters') {
			switch (optionSet) {
				case 'filter':
					return [
						{ label: 'All characters',		value: '*',		  					filterFunction: character => character },
						{ label: 'Starred',				value: 'starred', 					filterFunction: character => character.starred },
						{ separator: true },
						{ label: 'Faction',				value: 'factions',					options: this.factions?.items?.map(f => ({
							label: f.name,				value: `factions.${f.slug}`,		filterFunction: character => character.factions?.items.map(fa => fa.slug).includes(f.slug),
							image: f.image?.url || '',	imageIcon: 'FlagBannerFold'
						}))	},
						{ label: 'Location',			value: 'location',					options: this.locations?.items?.map(l => ({
							label: l.name,				value: `location.${l.slug}`,		filterFunction: character => character.location?.slug == l.slug,
							image: l.image?.url || '',	imageIcon: 'MapPinArea',
						}))	},
						{ label: 'Relationship',		value: 'relationships',				options: this.characters?.items?.map(c => ({
							label: c.name,				value: `relationship.${c.slug}`,	filterFunction: character => character.relationships?.items?.map(r => r.slug).includes(c.slug),
							image: c.image?.url || '',	imageIcon: 'User'
						}))	},
						{ separator: true,	if: this.customFields?.getByFieldable('character').length > 0 },
						...this.customFields?.getByFieldable('character').map(cf => ({
							label: cf.label,			value: cf.name,						options: cf.options ? cf.options.map(opt => ({
								label: opt.label,		value: `${cf.name}.${opt.value}`,	filterFunction: (ent) => ent.customFieldValues.find(f => f.name === cf.name)?.value === opt.value
							})) : undefined
						})),
						{ separator: true },
						{ label: 'Created',				value: 'created',					options: [
							{   label: 'Today',			value: 'created.today',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 24 * 60 * 60 * 1000) },
							{   label: 'This Week',		value: 'created.week',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000) },
							{   label: 'This month',	value: 'created.month',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000) },
							{   label: 'This year',		value: 'created.year',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000) },
						]},
						{ label: 'Updated',				value: 'updated',					options: [
							{   label: 'Today',			value: 'updated.today',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 24 * 60 * 60 * 1000) },
							{   label: 'This week',		value: 'updated.week',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000) },
							{   label: 'This month',	value: 'updated.month',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000) },
							{   label: 'This year',		value: 'updated.year',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000) },
						]}
					]
				case 'sort':
					return [
						{ label: "By name",				value: 'name',						sortFunction: (a,b) => a.name < b.name ? -1 : 1 },
						{ label: "By alias",			value: 'alias',						sortFunction: (a,b) => a.alias < b.alias ? -1 : 1 },
						{ separator: true },
						{ label: "By location",			value: 'location',					sortFunction: (a,b) => (a.location?.name || '_') < (b.location?.name || '_') ? -1 : 1 },
						{ label: "By faction",			value: 'faction',					sortFunction: (a,b) => (a.factions?.items?.[0]?.name || '_') < (b.factions?.items?.[0]?.name || '_') ? -1 : 1 },
						{ label: "By popularity",		value: 'popularity',				sortFunction: (a,b) => a.relationships?.items?.length > b.relationships?.items?.length 	? -1 : 1 },
						{ separator: true, if: this.customFields?.getByFieldable('character').length > 0 },
						...this.customFields?.getByFieldable('character').map(cf => ({
							label: `By ${cf.label.toLowerCase()}`,	value: 'cf.'+cf.name,			sortFunction: (a,b) => {
								a = a.customFieldValues?.find(v => v.name === cf.name)?.displayValue
								b = b.customFieldValues?.find(v => v.name === cf.name)?.displayValue
								if (!a) { return  1 }
								if (!b) { return -1 }
								return !isNaN(a) && !isNaN(b)
									? (Number(a) < Number(b) ? -1 : 1)
									: (a < b ? -1 : 1)
							}
						})),
						{ separator: true },
						{ label: "Date Created",	value: 'created_at',	sortFunction: (a,b) => a.meta.created.at < b.meta.created.at ? -1 : 1 },
						{ label: "Date Updated",	value: 'updated_at',	sortFunction: (a,b) => a.meta.updated.at < b.meta.updated.at ? -1 : 1 },
						{ label: "Randomly",		value: 'random',		sortFunction: (a,b) => Math.random() < 0.5 ? -1 : 1 },
					]
				case 'layout':
					return [
						{ label: "As Graph",		value: "graph", 		icon: "Graph"	  	},
						{ label: "As Grid",			value: "grid",			icon: "GridFour"	},
						{ label: "As Table",		value: "table", 		icon: "Table"	  	}
					]
				default:
					return this.characters?.items?.map(c => ({
						label: c.name,
						value: `relationship.*.${c.slug}`,
						imageIcon: 'User',
						image: c.image?.url || '',
						filterFunction: (c) => c.relationships?.items?.map(r => r.slug).includes(filter.split('.')[2])
					}))
			}
		}

		if (entity === 'factions') {
			switch (optionSet) {
				case 'filter':
					return [
						{ label: 'All factions', 		value: '*',		  				filterFunction: (fac) => { return fac } },
						{ label: 'Starred', 			value: 'starred', 				filterFunction: (fac) => { return fac.starred } },
						{ 	separator: true },
						{ label: 'Headquarters',		value: 'location',				options: this.locations?.items?.map(l => ({
							label: l.name,				value: `location.${l.slug}`,	filterFunction: (fac) => fac.headquarters?.slug == l.slug,
							image: l.image?.url || '',	imageIcon: 'MapPinArea',
						}))	},
						{ label: 'Member',				value: 'member',				options: this.characters?.items?.map(c => ({
							label: c.name,				value: `member.*.${c.slug}`,	filterFunction: (fac) => fac.members?.items.map(m => m.slug).includes(c.slug),
							image: c.image?.url || '',	imageIcon: 'FlagBannerFold'
						})) },
						{ separator: true,	if: this.customFields?.getByFieldable('faction').length > 0 },
						...this.customFields?.getByFieldable('faction').map(cf => ({
							label: cf.label,			value: cf.name,						options: cf.options ? cf.options.map(opt => ({
								label: opt.label,		value: `${cf.name}.${opt.value}`,	filterFunction: (ent) => ent.customFieldValues.find(f => f.name === cf.name)?.value === opt.value
							})) : undefined
						})),
						{ separator: true },
						{ label: 'Created',				value: 'created',					options: [
							{   label: 'Today',			value: 'created.today',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 24 * 60 * 60 * 1000) },
							{   label: 'This Week',		value: 'created.week',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000) },
							{   label: 'This month',	value: 'created.month',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000) },
							{   label: 'This year',		value: 'created.year',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000) },
						]},
						{ label: 'Updated',				value: 'updated',					options: [
							{   label: 'Today',			value: 'updated.today',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 24 * 60 * 60 * 1000) },
							{   label: 'This week',		value: 'updated.week',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000) },
							{   label: 'This month',	value: 'updated.month',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000) },
							{   label: 'This year',		value: 'updated.year',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000) },
						]}
					]
				case 'sort':
					return [
						{ label: "By name",				value: 'name',						sortFunction: (a,b) => a.name < b.name ? -1 : 1 },
						{ label: "By type",				value: 'type',						sortFunction: (a,b) => a.type < b.type ? -1 : 1 },
						{ label: "By member count",		value: 'members',					sortFunction: (a,b) => a.members?.items.length > b.members?.items.length	? -1 : 1 },
						{	separator: true, if: this.customFields?.getByFieldable('faction').length > 0 },
						...this.customFields?.getByFieldable('faction').map(cf => ({
							label: `By ${cf.label.toLowerCase()}`,	value: 'cf.'+cf.name,			sortFunction: (a,b) => {
								a = a.customFieldValues?.find(v => v.name === cf.name)?.displayValue
								b = b.customFieldValues?.find(v => v.name === cf.name)?.displayValue
								if (!a) { return  1 }
								if (!b) { return -1 }
								return !isNaN(a) && !isNaN(b)
									? (Number(a) < Number(b) ? -1 : 1)
									: (a < b ? -1 : 1)
							}
						})),
						{ 	separator: true },
						{ label: "Date Created",	value: 'created_at',	sortFunction: (a,b) => { return a.meta.created.at		< b.meta.created.at 			? -1 : 1 } },
						{ label: "Date Updated",	value: 'updated_at',	sortFunction: (a,b) => { return a.meta.updated.at		< b.meta.updated.at 			? -1 : 1 } },
						{ label: "Randomly",		value: 'random',		sortFunction: (a,b) => { return Math.random()          < 0.5 						? -1 : 1 } },
					]
				case 'layout':
					return [
						{ label: "As Grid",  			value: "grid",			icon: "GridFour"	},
						{ label: "As Table", 			value: "table", 		icon: "Table"	  	}
					]
				default:
					return this.factions?.items?.map(f => ({
						label: f.name,
						value: `factions.${f.slug}`,
						imageIcon: 'FlagBannerFold',
						image: f.image?.url || '',
						filterFunction: (f) => f.factions.map(fa => fa.slug).includes(f.slug)
					}))
			}
		}

		if (entity === 'items') {
			switch (optionSet) {
				case 'filter':
					return [
						{ label: 'All items', 		value: '*',		  				filterFunction: (i) => { return i } },
						{ label: 'Starred', 		value: 'starred', 				filterFunction: (i) => { return i.starred } },
						{ label: 'Unique', 			value: 'unique', 				filterFunction: (i) => { return i.unique } },
						{ 	separator: true },
						{ label: 'Type',			value: 'type',					options: this.items.items.reduce((items,item) => items.find((i) => i.label === item.type) ? items : [...items, {
							label: item.type,		value: 'type.'+item.type,		filterFunction: (i) => { return i.type === item.type }
						}], []).sort((a,b) => a.label > b.label ? 1 : -1) },
						{	separator: true,		if: this.customFields?.getByFieldable('item').length > 0 },
						...this.customFields?.getByFieldable('item').map(cf => ({
							label: cf.label,			value: cf.name,						options: cf.options ? cf.options.map(opt => ({
								label: opt.label,		value: `${cf.name}.${opt.value}`,	filterFunction: (ent) => ent.customFieldValues.find(f => f.name === cf.name)?.value === opt.value
							})) : undefined
						})),
						{ separator: true },
						{ label: 'Created',				value: 'created',					options: [
							{   label: 'Today',			value: 'created.today',				filterFunction: (ent) => new Date(ent.meta.created.at) >= new Date(new Date().getTime() - 24 * 60 * 60 * 1000) },
							{   label: 'This Week',		value: 'created.week',				filterFunction: (ent) => new Date(ent.meta.created.at) >= new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000) },
							{   label: 'This month',	value: 'created.month',				filterFunction: (ent) => new Date(ent.meta.created.at) >= new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000) },
							{   label: 'This year',		value: 'created.year',				filterFunction: (ent) => new Date(ent.meta.created.at) >= new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000) },
						]},
						{ label: 'Updated',				value: 'updated',					options: [
							{   label: 'Today',			value: 'updated.today',				filterFunction: (ent) => new Date(ent.meta.updated.at) >= new Date(new Date().getTime() - 24 * 60 * 60 * 1000) },
							{   label: 'This week',		value: 'updated.week',				filterFunction: (ent) => new Date(ent.meta.updated.at) >= new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000) },
							{   label: 'This month',	value: 'updated.month',				filterFunction: (ent) => new Date(ent.meta.updated.at) >= new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000) },
							{   label: 'This year',		value: 'updated.year',				filterFunction: (ent) => new Date(ent.meta.updated.at) >= new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000) },
						]}
					]
				case 'sort':
					return [
						{ label: "By name",				value: 'name',						sortFunction: (a,b) => a.name < b.name ? -1 : 1 },
						{ label: "By type",				value: 'type',						sortFunction: (a,b) => a.type < b.type ? -1 : 1 },
						{ label: "By cost",				value: 'cost',						sortFunction: (a,b) => a.cost < b.cost	? -1 : 1 },
						{ label: "By weight",			value: 'weight',					sortFunction: (a,b) => a.weight < b.weight	? -1 : 1 },
						{	separator: true, if: this.customFields?.getByFieldable('item').length > 0 },
						...this.customFields?.getByFieldable('item').map(cf => ({
							label: `By ${cf.label.toLowerCase()}`,	value: 'cf.'+cf.name,			sortFunction: (a,b) => {
								a = a.customFieldValues?.find(v => v.name === cf.name)?.displayValue
								b = b.customFieldValues?.find(v => v.name === cf.name)?.displayValue
								if (!a) { return  1 }
								if (!b) { return -1 }
								return !isNaN(a) && !isNaN(b)
									? (Number(a) < Number(b) ? -1 : 1)
									: (a < b ? -1 : 1)
							}
						})),
						{ 	separator: true },
						{ label: "Date Created",	value: 'created_at', sortFunction: (a,b) => { return a.meta.created.at		< b.meta.created.at 			? -1 : 1 } },
						{ label: "Date Updated",	value: 'updated_at', sortFunction: (a,b) => { return a.meta.updated.at		< b.meta.updated.at 			? -1 : 1 } },
						{ label: "Randomly",		value: 'random',     sortFunction: (a,b) => { return Math.random()          < 0.5 						? -1 : 1 } }
					]
				case 'layout':
					return [
						{ label: "As Grid",  			value: "grid",			icon: "GridFour"	},
						{ label: "As Table", 			value: "table", 		icon: "Table"	  	}
					]
				default:

			}
		}

		if (entity === 'locations') {
			switch (optionSet) {
				case 'filter':
					return [
						{ label: 'All locations', 		value: '*',		  				filterFunction: (location) => location				},
						{ label: 'Starred', 			value: 'starred', 				filterFunction: (location) => location.starred		},
						{ label: 'Type',				value: 'type',					options: this.locations?.items?.reduce((acc,item) => acc.includes(item.type) ? acc : [...acc, item.type], []).sort((a,b) => a<b ? -1:1).map(type => ({
							label: type,				value: 'type.'+type,			filterFunction: (location) => location.type === type
						}))},
						{ label: 'Parent location',		value: 'parent',				options: this.locations?.items?.filter(l => l.mapItems?.locations?.length > 0).map(l => ({
							label: l.name, 				value: 'parent.'+l.slug,		filterFunction: (location) => location.mapData?.location?.slug == l.slug,
							image: l.image?.url || '',	imageIcon: 'MapPin'
						}))},
						{	separator: true,		if: this.customFields?.getByFieldable('location').length > 0 },
						...this.customFields?.getByFieldable('location').map(cf => ({
							label: cf.label,			value: cf.name,					options: cf.options ? cf.options.map(opt => ({
								label: opt.label,		value: cf.name+'.'+opt.value,	filterFunction: (ent) => ent.customFieldValues.find(f => f.name === cf.name)?.value === opt.value
							})) : undefined
						})),
						{ separator: true },
						{ label: 'Created',				value: 'created',					options: [
							{   label: 'Today',			value: 'created.today',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 24 * 60 * 60 * 1000) },
							{   label: 'This Week',		value: 'created.week',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000) },
							{   label: 'This month',	value: 'created.month',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000) },
							{   label: 'This year',		value: 'created.year',				filterFunction: (ent) => new Date(ent.meta.created.at) <= new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000) },
						]},
						{ label: 'Updated',				value: 'updated',					options: [
							{   label: 'Today',			value: 'updated.today',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 24 * 60 * 60 * 1000) },
							{   label: 'This week',		value: 'updated.week',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000) },
							{   label: 'This month',	value: 'updated.month',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000) },
							{   label: 'This year',		value: 'updated.year',				filterFunction: (ent) => new Date(ent.meta.updated.at) <= new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000) },
						]}
					]
				case 'sort':
					return [
						{ label: "By name",				value: 'name',						sortFunction: (a,b) => a.name < b.name ? -1 : 1 },
						{ label: "By type",				value: 'type',						sortFunction: (a,b) => a.type < b.type ? -1 : 1 },
						{	separator: true, if: this.customFields?.getByFieldable('location').length > 0 },
						...this.customFields?.getByFieldable('location').map(cf => ({
							label: `By ${cf.label.toLowerCase()}`,	value: cf.name,			sortFunction: (a,b) => {
								a = a.customFieldValues.find(v => v.name === cf.name)?.value
								b = b.customFieldValues.find(v => v.name === cf.name)?.value
								return !isNaN(a) && !isNaN(b)
									? (Number(a) < Number(b) ? -1 : 1)
									: (a < b ? -1 : 1)
							}
						})),
						{ label: "Date Created",		value: 'created_at', 				sortFunction: (a,b) => a.meta.created.at		< b.meta.created.at 			? -1 : 1 },
						{ label: "Date Updated",		value: 'updated_at', 				sortFunction: (a,b) => a.meta.updated.at		< b.meta.updated.at 			? -1 : 1 },
						{ label: "Randomly",			value: 'random',     				sortFunction: (a,b) => Math.random()        < 0.5 						? -1 : 1 }
					]
				case 'layout':
					return [
						{ label: "As Map",  			value: "map",			icon: "Compass"		},
						{ label: "As Grid",  			value: "grid",			icon: "GridFour"	},
						{ label: "As Table", 			value: "table", 		icon: "Table"	  	}
					]
				default:
					return this.locations?.items?.map(l => ({
						label: l.name,
						value: `location.${l.slug}`,
						imageIcon: 'MapPinArea',
						image: l.image?.url || '',
						filterFunction: (ch) => ch.location?.slug == l.slug
					}))
			}
		}

		if (entity === 'customFields') {
			return this.customFields?.getByFieldable(optionSet).map(cf => ({
				label: cf.label,
				value: cf.name,
				options: cf.options ? cf.options.map(opt => ({
					label: opt.label,
					value: `${cf.name}.${opt.value}`,
					filterFunction: (ent) => ent.customFieldValues.find(f => f.name === cf.name)?.value === opt.value
				})) : undefined
			}))
		}
	}



	/**
	 * Get Media
	 * @param {string} type | The "type" of media to filter
	 * @returns {Object} first media instance with specified type
	 */
	getMedia(type) {
		return type ? this.media?.filter(m => m.type === type)?.[0] : null
	}


	/**
	 * Get All Media
	 * @param {string} type | The "type" of media to filter
	 * @returns {Array} all media instances with specified type
	 */
	getAllMedia(type) {
		return type ? this.media?.filter(m => m.type === type) : null
	}


	/**
	 * Controller - Activate
	 * @param {Object} data | The data to ACTIVATE on the database
	 */
	activate() {
		router.post( this.routes.activate, {}, {
			onFinish: () => router.visit( router.page.url, { only: ['activeProject'] })
		})
	}


	/**
	 * Controller - Deactivate
	 * @param {Object} data | The data to DEACTIVATE on the database
	 */
	deactivate() {
		router.post( this.routes.deactivate, {}, {
			onFinish: () => router.visit( router.page.url, { only: ['activeProject'] })
		})
	}


	/**
	 * Controller - Store
	 * @param {Object} data | The data to STORE on the database
	 */
	_store(data) {
		router.post( this.routes.store, data, {
			onFinish: () => router.visit( router.page.url, { only: ['characters', 'character'] })
		})
	}

	/**
	 * Controller - Update
	 * @param {Object} data | The data to UPDATE on the database
	 */
	_update(data) {
		router.patch( this.routes.update, data, {
			onFinish: () => router.visit( router.page.url, { only: ['activeProject'] })
		})
	}

	/**
	 * Controller - Destroy
	 * @param {Object} data | The data to DESTROY on the database
	 */
	_destroy(data) {
		router.destroy( this.routes.destroy, data, {
			onFinish: () => router.visit( router.page.url, { only: ['characters', 'character'] })
		})
	}
}
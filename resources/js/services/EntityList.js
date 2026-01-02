/**
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 * @typedef {import('@/services/EntityObject')} EntityObject
 */

import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore';
import EntityObject from '@/services/EntityObject'


/**
 * Class: Entity List
 * Represents a collection of Entity records
 * @class
 * @classdesc A list of EntityObjects (this.items) with a collection
 * of other functionality to make data handling easier
 */

export default class EntityList {


	/**
	 * Creates a new EntityList instance
	 * @param {Array} list
	 * @throws {TypeError} if list is not an array or object
	 */
	constructor(entityListData) {
		if (!entityListData || (typeof entityListData !== 'object')) {
			throw new TypeError('EntityList constructor requires a constructor object.');
		}
		Object.assign(this, {

			/**
			 * Array of EntityObject instances
			 * @type {Array<EntityObject>}
			 * @readonly
			 */
			items: list.map(i => new EntityObject(i)),

			/**
			 * History stack for undo/redo functionality
			 * @type {Array<Object>}
			 * @private
			 */
			history: [],

			/**
			 * API routes for entity operations
			 * @type {Object}
			 * @property {string} store | Route for storing new entitys
			 */
			routes: {
				// store:	route('entities.store')
			}
		})

		/** @private */
		this._saveToHistory(); // Save initial state to history
	}


	/**
	 * Filter
	 * Returns a filtered list of items based on the strings provided
	 * @param {string} query
	 * @param {string} filter
	 * @param {string} sort
	 * @returns {Array}
	 */
	applyFilters(query, filter, sort) {
		let response = this.items
		if (query)  {	response = response.filter(item => item.name.toLowerCase().includes(query.toLowerCase()))	}
		if (filter) {	response = response.filter(filter)	}
		if (sort)   {	response = response.sort(sort)	}
		return response
	}


	/**
	 * Create
	 * Open the modal for creating a new entity entity
	 * @returns {void}
	 */
	create() {
		modalActions.open('createEntity')
	}


	/**
	 * Find
	 * Returns the item with the provided id, if it exists
	 * @param {string} id
	 * @returns {Object}
	 */
	find(id) {
		return this.items.find(item => item.id === id)
	}




	getOptions(type) {
		switch (type) {
			case 'filter':
				return [
					{ label: 'All entitys',			value: '*',		  					filterFunction: entity => entity },
					{ label: 'Starred',				value: 'starred', 					filterFunction: entity => entity.starred },
					{ separator: true },
					{ label: 'Created',				value: 'created',					options: [
						{   label: 'Today',			value: 'created.today',				filterFunction: entity => new Date(entity.meta.created.at) >= new Date(new Date().getTime() - 24 * 60 * 60 * 1000) },
						{   label: 'This week',		value: 'created.week',				filterFunction: entity => new Date(entity.meta.created.at) >= new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000) },
						{   label: 'This month',	value: 'created.month',				filterFunction: entity => new Date(entity.meta.created.at) >= new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000) },
						{   label: 'This year',		value: 'created.year',				filterFunction: entity => new Date(entity.meta.created.at) >= new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000) },
					]},
					{ label: 'Updated',				value: 'updated',					options: [
						{   label: 'Today',			value: 'updated.today',				filterFunction: entity => new Date(entity.meta.updated.at) >= new Date(new Date().getTime() - 24 * 60 * 60 * 1000) },
						{   label: 'This week',		value: 'updated.week',				filterFunction: entity => new Date(entity.meta.updated.at) >= new Date(new Date().getTime() - 7 * 24 * 60 * 60 * 1000) },
						{   label: 'This month',	value: 'updated.month',				filterFunction: entity => new Date(entity.meta.updated.at) >= new Date(new Date().getTime() - 30 * 24 * 60 * 60 * 1000) },
						{   label: 'This year',		value: 'updated.year',				filterFunction: entity => new Date(entity.meta.updated.at) >= new Date(new Date().getTime() - 365 * 24 * 60 * 60 * 1000) },
					]}
				]
			case 'sort':
				return [
					{ label: "By name",				value: 'name',						sortFunction: (a,b) => a.name < b.name ? -1 : 1 },
					{ separator: true },
					{ label: "Date Created", 		value: 'created_at', 				sortFunction: (a,b) => a.meta.created.at < b.meta.created.at ? -1 : 1 },
					{ label: "Date Updated", 		value: 'updated_at', 				sortFunction: (a,b) => a.meta.updated.at < b.meta.updated.at ? -1 : 1 },
					{ label: "Randomly", 			value: 'random',     				sortFunction: (a,b) => Math.random() < 0.5 ? -1 : 1 },
				]
			default:
				return this.items?.map(entity => ({
					label: entity.name,
					value: entity.slug
				}))
		}
	}


	/**
	 * History / Undo
	 * Keep only the last 50 states to prevent memory issues
	 * @returns {void}
	 */
	_saveToHistory() {
		this.history.push([...this.items]);
		if (this.history.length > 50) {
			this.history.shift();
		}
	}
}
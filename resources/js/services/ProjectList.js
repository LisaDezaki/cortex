/**
 * @typedef {import('momentum-trail')} route
 * @typedef {import('@/stores/modalStore')} modalActions
 * @typedef {import('@/services/ProjectObject')} ProjectObject
 */

import { route } from 'momentum-trail'
import { modalActions } from '@/stores/modalStore';
import ProjectObject from '@/services/ProjectObject'

/**
 * Class: Project List
 * Represents a collection of Project records
 * @class
 * @classdesc A list of ProjectObjects (this.items) with a collection
 * of other functionality to make data handling easier
 */

export default class ProjectList {

	/**
	 * Creates a new ProjectList instance
	 * @param {Array} list
	 * @throws {TypeError} if list is not an array or object
	 */
	constructor(list) {
		if (!list || (typeof list !== 'object')) {
			throw new TypeError('ProjectList constructor requires an array or object');
		}
		Object.assign(this, {

			/**
			 * Array of ProjectObject instances
			 * @type {Array<ProjectObject>}
			 * @readonly
			 */
			items: list.map(i => new ProjectObject(i)),

			/**
			 * History stack for undo/redo functionality
			 * @type {Array<Object>}
			 * @private
			 */
			history: [],

			/**
			 * API routes for project operations
			 * @type {Object}
			 * @property {string} store | Route for storing new projects
			 */
			routes: {
				store:  route('projects.store'),
				create:	route('projects.create'),
				deactivate: route('projects.deactivate'),
			}
		})

		/** @private */
		this._saveToHistory(); // Save initial state to history
	}

	openModal(modalName, props) {

		const storeProps   = { entity: this, endpoint: this.routes.store   }

		switch(modalName) {
			case 'create':
				modalActions.open('createEntity', { ...storeProps,
					reloadPageProps: ['projects'],
					title: 'Create project:',
				...props }); break;
			default:
				console.log('ProjectList.openModal', modalName, props)
		}
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
	 * Open the modal for creating a new project entity
	 * @returns {void}
	 */
	create() {
		this.openModal('create')
	}


	/**
	 * Filter
	 * Returns a filtered list of items based on the strings provided
	 * @param {string} query
	 * @param {string} filter
	 * @param {string} sort
	 * @returns {Array}
	 */
	filter(query, filter, sort) {
		return this.items
			.filter(item => item.name.toLowerCase().includes(query.toLowerCase()))
			.filter(filter).sort(sort)
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
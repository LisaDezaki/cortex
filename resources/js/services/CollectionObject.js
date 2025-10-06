import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import { modalActions } from '@/stores/modalStore';

export default class CollectionObject {
    constructor(collection, type) {
        Object.assign(this, collection, {
			list: collection.items,
			type: type,
			routes: {
				show:    route('collections.show',    { collection: collection.slug }),
				store:   route('collections.store'),
				update:  route('collections.update',  { collection: collection.slug }),
				destroy: route('collections.destroy', { collection: collection.slug })
			}
		})
    }

	addItem(item) {
		console.log('CollectionObject.addItem()', item)
		if (item?.id) {
			router.patch(
				this.routes.update,
				{ items: [{ id: item.id, type: this.type }] },
				{
					onFinish: (response) => {
						router.visit( router.page.url, { only: ['collections'] })
					}
				}
			)
		}
	}

	applyTags() {

	}
    
    create() {
		console.log('CollectionObject.create()')
		modalActions.open('createCollection', { type })
	}

	delete() {
		modalActions.open('deleteCollection', { collection: this })
	}

	

	removeItem(item) {
		console.log('CollectionObject.removeItem()', item)
		router.patch(
			this.routes.update,
			{ items: [{ id: item.id, type: this.type }] },
			{
				onFinish: (response) => {
					router.visit( router.page.url, { only: ['collections'] })
				}
			}
		)
	}

	rename() {
		modalActions.open('renameCollection', { collection: this })
	}
}
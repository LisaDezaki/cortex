// import Base from './Base.svelte'
import List from './List.svelte';
// import Item from './Item.svelte';
import Handle from './Handle.svelte';
// import { LIST_CONTEXT, ITEM_CONTEXT } from './context.js';

// const Reorder = Base
// Reorder.LIST_CONTEXT = LIST_CONTEXT
// Reorder.ITEM_CONTEXT = ITEM_CONTEXT
// Reorder.List = List;
// Reorder.Item = Item;
// Reorder.Handle = Handle;

// export default Reorder

// export { LIST_CONTEXT, ITEM_CONTEXT }
// export { List, Item, Handle }

const Reorder = { List, Handle }
export default Reorder
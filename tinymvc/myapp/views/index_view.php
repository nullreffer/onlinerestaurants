<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/strict.dtd">
<html>
	<head>
		<title>Restaurants</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	</head>
	<body>
		
	  Hi! Use the following:
	  <pre>
/api
- returns api doc

/api/{resource}

- /api/restaurant/{id}
- - get - return restaurant profile
- - post - {secure} create restaurant
- - put - {secure} update restaurant 

- /api/menu/{id}
- - get - return menu and menu items
- - post - (secure) create new menu, return id

- /api/menuitems/{id}
- - get - return menu items for menu with id
- - post - add menu item to menu with id, return menu item id
- - put - update menu item 
- - delete - delete menu item from menu with id

- /api/cart/{id}
- - get - return cart with id 
- - post - create cart, return id
- - put - update cart { add, remove items }

- /api/order/{id}
- - get - return order with id
- - post - {secure} place order

- /api/user/{phone}
- - get - return user by phone
- - post - {secure} create user and send verification
- - put - {secure} update user 

sample jsons
restaurant : {
    id: 11
    name: “Chaat n Roll”,
    desc: “Spicy indian fast food”,
    type: “Indian, Fast Food”,
    address: “123 Some Lane, Redmond, WA 98052”,
    phone: 4251111111
    estlatency: “15-20mins”
    hours: “M-S: 9am-1pm, 5pm-9pm, S: 5pm-9pm “
    menus: [
        1: {  
            id: 1, 
            restaurant_id: 11, 
            name: “chaat”, 
            schedule: “Mon9-13,Mon17-21,…” 
        },
        2: {  
            id: 2, 
            restaurant_id: 11, 
            name: “wine”,  
            schedule: “Mon17-21,…” 
        }
    ]
}

menu : {
    id: 1, 
    restaurant_id: 11, 
    name: “chaat”, 
    schedule: “Mon9-13,Mon17-21,…”,
    menuitems: [
        101: {
            name: “aloo chaat”,
            description: “potato fritter topped with chick peas, spices, onions, and apple sauce”,
            price: 5.95,
            tax: 0.57,
            is_vegetarian: 1, // -1 means not vegetarian, 1 means it is, 0 means can be made if custom
            is_vegan: 0
        },
       102: {
            name: “papdi chaat”,
            description: “wheat crisps mixed with chick peas, spices, onions, and apple sauce”,
            price: 5.95,
            tax: 0.57,
            is_vegetarian: 1, // -1 means not vegetarian, 1 means it is, 0 means can be made if custom
            is_vegan: 0
        }
    ]
}

cart: {
    id: 21, 
    user: null, // or a user object
    creationdate: 2014-05-20 09:20:15.982,
    cartitems: [
        101,
        102
    ],
    comments: “Please make spice level 3 on a sacle of 1 to 5”
}

order: {
    id: 41, 
    user: {
        id: 412,
        phone: 7047632738,
        name: jay
    },
    status: pending,
    estreadytime: 2014-05-20 09:40:15.982 
    creationdate: 2014-05-20 09:25:15.982,
    orderitems: [
        101,
        102
    ],
    ordertotal: 11.9,
    taxtotal: 1.14,
    tip: 5,
    total: 18.04,
    deliverytype: pickup,
    comments: “Please make spice level 3 on a sacle of 1 to 5”,
    payment method: null // eventually
}
	  </pre>
	</body>
</html>


